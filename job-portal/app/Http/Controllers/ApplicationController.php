<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobVacancy as Job;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use App\Imports\JobsImport;
// use App\Mail\JobAppliedMail;
// use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use App\Jobs\SendApplicationMailJob;
use App\Jobs\SendStatusUpdateMailJob;
use App\Notifications\ApplicationStatusUpdatedNotification;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();
        $applications = Application::with('user', 'job')->get();
        return view('applications.index', compact(
            'applications', 'jobs' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);
        $cvPath = $request->file('cv')->store('cvs', 'public');
        
        try{
            $application = Application::create([
                'user_id' => auth()->id(),
                'job_id' => $jobId,
                'cv' => $cvPath,
            ]);

            // Kirim email ke user
            // Mail::to(auth()->user()->email)
            // ->send(new JobAppliedMail($application->job, auth()->user()));
            dispatch(new SendApplicationMailJob($jobId, auth()->user(), $cvPath));

            $admin = User::where('role', 'admin')->first();
            $admin->notify(new NewApplicationNotification($application));

            return back()->with('success', 'Lamaran berhasil dikirim!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim lamaran.');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $application->status = $request->status;
        $application->notes = $request->notes;  // optional field
        $application->save();

        // send email
        dispatch(new SendStatusUpdateMailJob($application->id));

        // in-app notification
        $application->user->notify(
            new ApplicationStatusUpdatedNotification($application)
        );

        return back()->with('success', 'Status aplikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return back()->with('success', 'Aplikasi berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $jobId = $request->query('job_id'); // bisa null

        return Excel::download(new ApplicationsExport($jobId), 'applications.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new JobsImport,$request->file('file'));
        return back()->with('success', 'Data lowongan berhasil diimport');
    }

    public function filter(string $id)
    {
        $selectedJob = Job::findOrFail($id);

        // hanya aplikasi untuk job ini
        $applications = Application::with('user', 'job')
            ->where('job_vacancy_id', $id)
            ->get();

        // untuk dropdown
        $jobs = Job::all();

        return view('applications.filter', compact(
            'applications', 'jobs', 'selectedJob'
        ));
    }
}
