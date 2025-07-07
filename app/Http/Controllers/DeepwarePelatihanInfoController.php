<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan1Info;
use Illuminate\Http\Request;

class DeepwarePelatihanInfoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch all pelatihan info data
        $pelatihans = Pelatihan1Info::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('info_pelatihan', 'like', "%{$search}%")
                    ->orWhere('link_pelatihan', 'like', "%{$search}%");
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        // If the request is an AJAX request, return a partial view
        if ($request->ajax()) {
            return view('dashboard.pelatihan.info.index', compact('pelatihans'))->render();
        }

        // Return the view with pelatihan info data
        return view('dashboard.pelatihan.info.index', compact('pelatihans'));
    }

    public function show($id)
    {
        // Fetch the pelatihan info by ID
        $pelatihan = Pelatihan1Info::findOrFail($id);

        // Return the view with the pelatihan info data
        return view('dashboard.pelatihan.info.show', compact('pelatihan'));
    }

    public function create()
    {
        // Return the view to create a new pelatihan info
        return view('dashboard.pelatihan.info.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'info_pelatihan' => 'required|string|max:255',
            'link_pelatihan' => 'required|url',
        ]);

        // Handle the image upload if provided
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('uploads/pelatihan', 'public');
            $validated['gambar'] = $path;
        }

        // Create a new pelatihan info record
        Pelatihan1Info::create($validated);

        // Redirect back with a success message
        return redirect()->route('dashboard.pelatihan.info')->with('success', 'Pelatihan info created successfully.');
    }

    public function edit($id)
    {
        // Fetch the pelatihan info by ID
        $pelatihan = Pelatihan1Info::findOrFail($id);

        // Return the view to edit the pelatihan info
        return view('dashboard.pelatihan.info.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'info_pelatihan' => 'required|string|max:255',
            'link_pelatihan' => 'required|url',
        ]);

        // Fetch the pelatihan info by ID
        $pelatihan = Pelatihan1Info::findOrFail($id);

        // Handle the image upload if provided
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('uploads/pelatihan', 'public');
            $validated['gambar'] = $path;
        }

        // Update the pelatihan info record
        $pelatihan->update($validated);

        // Redirect back with a success message
        return redirect()->route('dashboard.pelatihan.info')->with('success', 'Pelatihan info updated successfully.');
    }

    public function destroy($id)
    {
        // Fetch the pelatihan info by ID
        $pelatihan = Pelatihan1Info::findOrFail($id);

        // Delete gambar
        if ($pelatihan->gambar && \Storage::disk('public')->exists($pelatihan->gambar)) {
            \Storage::disk('public')->delete($pelatihan->gambar);
        }

        // Delete the pelatihan info record
        $pelatihan->delete();

        // Redirect back with a success message
        return redirect()->route('dashboard.pelatihan.info')->with('success', 'Pelatihan info deleted successfully.');
    }
}
