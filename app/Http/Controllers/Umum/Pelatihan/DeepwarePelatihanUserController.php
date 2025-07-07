<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan1Info;
use App\Models\Pelatihan2Usulan;
use App\Models\PelatihanList;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\ref_namapelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeepwarePelatihanUserController extends Controller
{
    /**
     * Tampilkan semua pelatihan yang tersedia.
     */
    public function index(Request $request)
    {
        $pelatihan = Pelatihan1Info::orderBy('created_at', 'desc')->get();


        // if ($request->has('keyword') && $request->keyword != '') {
        //     $query->where('nama_pelatihan', 'like', '%' . $request->keyword . '%');
        // }

        //$pelatihan = $query->latest()->paginate(3);

        return view('pelatihan.index', compact('pelatihan'));
    }

    
        /**
     * Tampilkan detail dari pelatihan info.
     */
    public function show(Pelatihan1Info $pelatihan)
    {
        return view('pelatihan.detail', compact('pelatihan'));
    }


    public function autocomplete(Request $request)
    {
        $keyword = $request->get('keyword');

        $results = PelatihanList::where('nama_pelatihan', 'LIKE', "%{$keyword}%")
            ->limit(10)
            ->get(['id', 'nama_pelatihan']);

        return response()->json($results);
    }

    public function daftar()
    {
        $pelatihan = Pelatihan2Usulan::with([
            'user',
        ])->latest()->paginate(9);
        $jenisPelatihan = ref_jenispelatihans::all();
        $metodePelatihan = ref_metodepelatihans::all();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();

        // Return the view with pelatihan data
        return view('pelatihan.daftar-pelatihan', compact('pelatihan', 'jenisPelatihan', 'metodePelatihan', 'pelaksanaanPelatihan'));
    }


    public function usulan()
        {
            $nip = auth()->user()->nip;
            // Fetch all pelatihan data
            $pelatihan = Pelatihan2Usulan::with('user')
            ->where('nip_pengusul', $nip)
            ->latest()
            ->paginate(9);


            // Return the view with pelatihan data
            return view('pelatihan.usulan.index', compact('pelatihan'));
         }   

        public function createUsulan()
        {
            // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
            $pegawai = User::all();
            $namaPelatihan = ref_namapelatihan::where('status', 'diterima')->get();
            $jenisPelatihan = ref_jenispelatihans::all();
            $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();
            $metodePelatihan = ref_metodepelatihans::all();

            // Return the view with jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
            return view('pelatihan.usulan.create', compact('pegawai', 'namaPelatihan', 'jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
        }

         public function storeUsulan(Request $request)
        {
            $data['nip'] = Auth::user()->nip;
            

           // dd(auth()->user());

            //$nip = auth()->user()->nip; // ambil dari user yang login

            // Validate the request data
            $request->validate([
                //'nip' => 'required|exists:users,nip',
                
                'nama_pelatihan' => 'required|string|max:255',
                'pelaksanaan_pelatihan' => 'required|string|max:255',
                'metode_pelatihan' => 'required|string|max:255',
                'jenis_pelatihan' => 'required|string|max:255',
                'penyelenggara_pelatihan' => 'required|string|max:255',
                'tempat_pelatihan' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'estimasi_biaya' => 'required|numeric',
                'file_penawaran' => 'nullable|file|mimes:pdf|max:8192',
                'keterangan' => 'nullable|string|max:255',
            ]);

            //$data = $request->all();

            $data = $request->except('nip'); // jangan ambil nip dari request

            // $user = auth()->user();
            // dd($user);
            
            //Ambil nip dari user login
            $data['nip'] = auth()->user()->nip;

            if ($request->hasFile('file_penawaran')) {
                $data['file_penawaran'] = $request->file('file_penawaran')->store('uploads/penawaran', 'public');
            }

            Pelatihan2Usulan::create($data);

            // Redirect to the pelatihan index with success message
            return redirect()->route('pelatihan.usulan.index')->with('success', 'Usulan pelatihan berhasil ditambahkan.');
        }

    


    /**
     * Pencarian berdasarkan tanggal mulai.
     */
    public function searchByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $pelatihan = PelatihanList::whereDate('tanggal_mulai', $request->date)->get();

        return view('user.pelatihan.index', compact('pelatihan'));
    }
}
