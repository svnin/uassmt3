<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy as Job;
use App\Imports\JobsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class JobController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Pagination
        $jobs = Job::when($search, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('company', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('jobs.index', compact('jobs', 'search'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function adminIndex()
    {
        return "Halaman Admin - Kelola Lowongan Kerja";
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'required|numeric',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'required|numeric',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $job = Job::findOrFail($id);

        $logoPath = $job->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($job->logo) {
                \Storage::disk('public')->delete($job->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diupdate');
    }

    public function destroy($id)
    {
        $job = job::findOrFail($id);
        // Hapus logo jika ada
        if ($job->logo) {
            \Storage::disk('public')->delete($job->logo);
        }
        
        $job->delete();
        
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new JobsImport, $request->file('file'));
        return back()->with('success', 'Data lowongan berhasil diimport');
    }
}