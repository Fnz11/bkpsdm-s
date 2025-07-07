<?php

namespace App\Http\Controllers\Admin\PengaturanDasar;

use App\Http\Controllers\Controller;
use App\Models\ref_golongans;
use App\Models\ref_jabatans;
use App\Models\ref_jenisasns;
use App\Models\ref_subunitkerjas;
use App\Models\ref_unitkerjas;
use App\Models\RefPegawai;
use App\Models\User;
use App\Models\UserPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RefPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Logic to handle the index view for Pegawai
        $search = $request->input('search');
        $unit = $request->input('unit_id');
        $asn = $request->input('jenis_asn');

        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();

        $jenisasns = ref_jenisasns::select('id', 'jenis_asn')
            ->orderBy('jenis_asn')
            ->get();

        $pegawais = RefPegawai::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })->orWhere('tempat_lahir', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('user.latestUserPivot.unitKerja', function ($q) use ($unit) {
                    $q->where('unitkerja_id', $unit);
                });
            })
            ->when($asn, function ($query) use ($asn) {
                $query->whereHas('user.latestUserPivot.golongan', function ($q) use ($asn) {
                    $q->where('jenisasn_id', $asn);
                });
            })
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pengaturandasar.pegawai.index', compact('pegawais', 'unitkerjas', 'jenisasns'))->render();
        }

        return view('dashboard.pengaturandasar.pegawai.index', compact('pegawais', 'unitkerjas', 'jenisasns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

        return view('dashboard.pengaturandasar.pegawai.create', compact('golongans', 'unitkerjas', 'subunitkerjas', 'jabatans', 'atasans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:ref_pegawai,nip',
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'nip_atasan' => 'nullable|string|max:20|exists:ref_pegawai,nip',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'id_golongan' => 'required|exists:ref_golongans,id',
            'id_unitkerja' => 'required|exists:ref_unitkerjas,id',
            'id_subunitkerja' => 'required|exists:ref_subunitkerjas,id',
            'id_jabatan' => 'required|exists:ref_jabatans,id',
            'tgl_mulai' => 'required|date',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:admin,superadmin,asn',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $data = $request->all();

        $data['foto'] = $request->hasFile('foto')
            ? $request->file('foto')->store('uploads/pegawai', 'public')
            : 'images/avatarUser.svg';

        $user = User::create([
            'nip' => $data['nip'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole($data['role']);

        RefPegawai::create([
            'nip' => $data['nip'],
            'name' => $data['name'],
            'foto' => $data['foto'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'nip_atasan' => $data['nip_atasan'] ?? null,
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
        ]);

        UserPivot::create([
            'nip' => $data['nip'],
            'id_unitkerja' => $data['id_subunitkerja'],
            'id_golongan' => $data['id_golongan'],
            'id_jabatan' => $data['id_jabatan'],
            'tgl_mulai' => $data['tgl_mulai'],
            'tgl_akhir' => null,
            'is_unit_kerja' => true,
            'is_golongan' => true,
            'is_jabatan' => true,
        ]);

        return redirect()->route('dashboard.pelatihan.pegawai')->with([
            'message' => 'Pegawai baru berhasil ditambahkan.',
            'title' => 'Success',
        ]);
    }

    public function edit($id)
    {
        $pegawai = RefPegawai::findOrFail($id);
        $pivot = UserPivot::where('nip', $pegawai->nip)->latest()->first();

        return view('dashboard.pengaturandasar.pegawai.edit', [
            'pegawai' => $pegawai,
            'unitkerjas' => ref_unitkerjas::select('id', 'unitkerja')
                ->orderBy('unitkerja')
                ->get(),
            'subunitkerjas' => ref_subunitkerjas::select('id', 'sub_unitkerja', 'unitkerja_id')
                ->orderBy('sub_unitkerja')
                ->get(),
            'jabatans' => ref_jabatans::select('id', 'jabatan')
                ->orderBy('jabatan')
                ->get(),
            'golongans' => ref_golongans::select('id', 'pangkat_golongan')
                ->orderBy('pangkat_golongan')
                ->get(),
            'atasans' => RefPegawai::select('nip', 'name')
                ->where('id', '!=', $id)
                ->orderBy('name')
                ->get(),
            'pivot' => $pivot,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pegawai = RefPegawai::findOrFail($id);
        $user = User::where('nip', $pegawai->nip)->firstOrFail();
        $pivot = UserPivot::where('nip', $pegawai->nip)->latest()->first();

        $request->validate([
            'nip' => 'required|string|max:20|unique:ref_pegawai,nip,' . $pegawai->nip . ',nip',
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'nip_atasan' => 'nullable|string|max:20|exists:ref_pegawai,nip',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'id_golongan' => 'required|exists:ref_golongans,id',
            'id_unitkerja' => 'required|exists:ref_unitkerjas,id',
            'id_subunitkerja' => 'required|exists:ref_subunitkerjas,id',
            'id_jabatan' => 'required|exists:ref_jabatans,id',
            'tgl_mulai' => 'required|date',
            'email' => 'required|email|max:255|unique:users,email,' . $user->nip . ',nip',
            'role' => 'required|in:admin,superadmin,asn',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika bukan default
            if ($pegawai->foto && $pegawai->foto !== 'images/avatarUser.svg' && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $data['foto'] = $request->file('foto')->store('uploads/pegawai', 'public');
        }

        $pegawai->update([
            'nip' => $data['nip'],
            'name' => $data['name'],
            'foto' => $data['foto'] ?? $pegawai->foto,
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'nip_atasan' => $data['nip_atasan'] ?? null,
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
        ]);

        $user->update([
            'nip' => $data['nip'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $request->filled('password') ? bcrypt($data['password']) : $user->password,
        ]);

        $user->syncRoles([$data['role']]);

        // Cek apakah ada perubahan pada data pivot
        $pivotChanged = (
            $pivot->id_unitkerja != $data['id_subunitkerja'] ||
            $pivot->id_golongan != $data['id_golongan'] ||
            $pivot->id_jabatan != $data['id_jabatan'] ||
            $pivot->tgl_mulai != $data['tgl_mulai']
        );

        if ($pivotChanged) {
            // Buat record baru untuk history
            UserPivot::create([
                'nip' => $data['nip'],
                'id_unitkerja' => $data['id_subunitkerja'],
                'id_golongan' => $data['id_golongan'],
                'id_jabatan' => $data['id_jabatan'],
                'tgl_mulai' => $data['tgl_mulai'],
                'tgl_akhir' => null,
                'is_unit_kerja' => $data['id_subunitkerja'] != $pivot->id_unitkerja,
                'is_jabatan' => $data['id_jabatan'] != $pivot->id_jabatan,
                'is_golongan' => $data['id_golongan'] != $pivot->id_golongan,
            ]);

            // Update tgl_akhir pada record sebelumnya
            $pivot->update([
                'tgl_akhir' => now(), // Atau bisa menggunakan $data['tgl_mulai']
            ]);
        } else {
            // Jika tidak ada perubahan, update saja record yang ada
            $pivot->update([
                'nip' => $data['nip'],
                'id_unitkerja' => $data['id_subunitkerja'],
                'id_golongan' => $data['id_golongan'],
                'id_jabatan' => $data['id_jabatan'],
                'tgl_mulai' => $data['tgl_mulai'],
            ]);
        }

        return redirect()->route('dashboard.pelatihan.pegawai')->with([
            'message' => 'Data pegawai berhasil diperbarui.',
            'title' => 'Success',
        ]);
    }

    public function destroy($id)
    {
        $pegawai = RefPegawai::findOrFail($id);
        $user = User::where('nip', $pegawai->nip)->first();

        // Hapus foto jika bukan default
        if ($pegawai->foto && $pegawai->foto !== 'images/avatarUser.svg' && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        // Hapus data terkait
        UserPivot::where('nip', $pegawai->nip)->delete();
        $pegawai->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->back()->with([
            'message' => 'Data pegawai berhasil dihapus.',
            'title' => 'Success',
        ]);
    }
}
