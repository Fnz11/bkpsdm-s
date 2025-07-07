<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\ref_golongans;
use App\Models\ref_jabatans;
use App\Models\ref_subunitkerjas;
use App\Models\ref_unitkerjas;
use App\Models\RefPegawai;
use App\Models\User;
use App\Rules\Captcha; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeepwareAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pelatihan.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => new Captcha(), 
        ]);

        $credentialsList = [
            ['email' => $request->login, 'password' => $request->password],
            ['nip' => $request->login, 'password' => $request->password],
        ];

        foreach ($credentialsList as $credentials) {
            // Remove password from credentials for user lookup
            $loginField = isset($credentials['email']) ? 'email' : 'nip';
            $loginValue = $credentials[$loginField];

            // Find user by email or NIP
            $user = User::where($loginField, $loginValue)->first();

            if ($user) {
                // Login the user without password check
                Auth::login($user);
                $user->syncRoles([]);

                if (in_array($user->role, ['superadmin', 'admin', 'asn'])) {
                    $user->assignRole($user->role);
                    return redirect()->intended(route('pelatihan.index'));
                }

                Auth::logout();
                return back()->withErrors(['login' => 'Role pengguna tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'login' => 'Email atau NIP dan password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('pelatihan.index');
    }

    public function profile()
    {
        $golongans = ref_golongans::select('id', 'pangkat_golongan')
            ->orderBy('pangkat_golongan')
            ->get();
        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();
        $subunitkerjas = ref_subunitkerjas::select('id', 'sub_unitkerja', 'unitkerja_id')
            ->orderBy('sub_unitkerja')
            ->get();
        $jabatans = ref_jabatans::select('id', 'jabatan')
            ->orderBy('jabatan')
            ->get();
        $atasans = RefPegawai::select('nip', 'name')
            ->orderBy('name')
            ->get();

        $user = Auth::user();
        $activePivots = $user->userPivot()
            ->where('is_active', true)
            ->orderBy('tgl_mulai', 'desc')
            ->paginate(5, ['*'], 'active_page');

        $proposedPivots = $user->userPivot()
            ->where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'proposed_page');

        return view('pelatihan.auth.profile', compact(
            'user',
            'activePivots',
            'proposedPivots',
            'golongans',
            'unitkerjas',
            'subunitkerjas',
            'jabatans',
            'atasans'
        ));
    }

    //masi eror
    public function editProfile()
    {
        $user = Auth::user();
        return view('pelatihan.auth.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_id' => 'required|exists:ref_golongans,id',
            'jabatan_id' => 'required|exists:ref_jabatans,id',
            'sub_unitkerja_id' => 'required|exists:ref_subunitkerjas,id',
            'no_hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $user->nip . ',nip',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Data untuk update ref_pegawai
            $pegawaiData = [
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
            ];

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->refPegawai->foto && Storage::disk('public')->exists($user->refPegawai->foto)) {
                    Storage::disk('public')->delete($user->refPegawai->foto);
                }
                $path = $request->file('foto')->store('uploads/pegawai', 'public');
                $pegawaiData['foto'] = $path;
            }

            // Update data pegawai di tabel ref_pegawai
            $user->refPegawai->update($pegawaiData);

            // Update data user di tabel users
            $user->update([
                'email' => $validated['email'],
            ]);

            // Dapatkan data pivot terakhir yang aktif
            $latestActivePivot = $user->latestUserPivot;

            // Cek apakah ada perubahan pada data pivot (golongan, jabatan, atau unit kerja)
            $isGolonganChanged = $latestActivePivot->id_golongan != $validated['golongan_id'];
            $isJabatanChanged = $latestActivePivot->id_jabatan != $validated['jabatan_id'];
            $isUnitKerjaChanged = $latestActivePivot->id_unitkerja != $validated['sub_unitkerja_id'];

            // Hanya buat pivot baru jika ada perubahan pada data pivot
            if ($isGolonganChanged || $isJabatanChanged || $isUnitKerjaChanged) {
                $newPivotData = [
                    'nip' => $user->nip,
                    'id_unitkerja' => $validated['sub_unitkerja_id'],
                    'id_golongan' => $validated['golongan_id'],
                    'id_jabatan' => $validated['jabatan_id'],
                    'tgl_mulai' => now()->format('Y-m-d'),
                    'is_unit_kerja' => $latestActivePivot->is_unit_kerja,
                    'is_jabatan' => $latestActivePivot->is_jabatan,
                    'is_golongan' => $latestActivePivot->is_golongan,
                    'is_active' => false, // Tetap false karena perlu persetujuan
                ];

                // Buat record pivot baru
                $user->userPivot()->create($newPivotData);

                $message = 'Profil berhasil diperbarui. Perubahan struktural menunggu persetujuan.';
            } else {
                $message = 'Profil berhasil diperbarui.';
            }

            DB::commit();

            return redirect()->back()->with([
                'title' => 'Success',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'title' => 'Error',
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }
}
