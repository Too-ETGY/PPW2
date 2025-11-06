<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\JobVacancy as Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jobs.index', [
            'jobs' => Job::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048',
           'job_type' => 'required|string|max:255',
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
            'job_type' => $request->job_type,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);

        return view('jobs.edit', [
            'job' => $job,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'job_type' => 'required|string|max:255',
        ]);

        $job = Job::findOrFail($id);

        // Handle logo upload: remove old file if a new one is provided
        if ($request->hasFile('logo')) {
            // delete old logo if exists
            if ($job->logo && Storage::disk('public')->exists($job->logo)) {
                Storage::disk('public')->delete($job->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $job->logo = $logoPath;
        }

        $job->title = $request->title;
        $job->description = $request->description;
        $job->location = $request->location;
        $job->company = $request->company;
        $job->salary = $request->salary;
        $job->job_type = $request->job_type;

        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        // delete logo file if exists
        if ($job->logo && Storage::disk('public')->exists($job->logo)) {
            Storage::disk('public')->delete($job->logo);
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
