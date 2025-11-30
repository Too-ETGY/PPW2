<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy as Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // $apps = Application::with(['user','job'])
        //     ->latest()
        //     ->paginate($req->get('per_page', 10));
            
        $perPage = $req->get('per_page', 10);

        $apps = Application::with(['user','job'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($req->query());
        return response()->json($apps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req, Job $job)
    {
        // Job Seeker apply (upload CV optional via API multipart)
        $req->validate([
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $cvPath = $req->file('cv')->store('cvs', 'public');
        $app = Application::create([
            'user_id' => $req->user()->id,
            'job_id' => $job->id,
            'cv' => $cvPath,
            'status' => 'Pending'
        ]);
        return response()->json(['message' => 'Application submitted', 'application' => $app], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Application $application)
    {
        // hanya admin
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // validation
        $data = $req->validate([
            'status' => 'required|in:Accepted,Rejected'
        ]);

        // update
        $application->status = $data['status'];
        $application->save();

        return response()->json([
            'message' => 'Application status updated',
            'application' => $application
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
