<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy as Job;


class JobApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
    * @OA\Get(
    * path="/api/jobs",
    * summary="Get all job listings",
    * tags={"Jobs"},
    * security={{"bearerAuth":{}}},
    * @OA\Response(
    *   response=200,
    *   description="List of jobs",
    *   @OA\JsonContent(
    *       type="array",
    *       @OA\Items(
    *           @OA\Property(property="id", type="integer"),
    *           @OA\Property(property="title", type="string"),
    *           @OA\Property(property="location", type="string"),
    *           @OA\Property(property="company", type="string"),
    *       )
    *   )
    * )
    * )
    */
    public function index(Request $req)
    {
        $q = Job::query();
        
        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title','like',"%$kw%" )
                ->orWhere('company','like', "%$kw%")
                ->orWhere('location','like', "%$kw%");
           });
        }

        // filter by company (exact or partial)
        if ($req->filled('company')) {
            $q->where('company', 'like', "%{$req->company}%");
        }

        // filter by location (exact or partial)
        if ($req->filled('location')) {
            $q->where('location', 'like', "%{$req->location}%");
        }
        
        // $jobs = $q->orderBy('created_at','desc')->paginate($req->get('per_page', 10));

        // pagination
        $perPage = $req->get('per_page', 10);

        $jobs = $q->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($req->query());
        return response()->json($jobs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        // cek role admin
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
        ]);

        $job = Job::create($data);
        return response()->json(['message'=>'Created','job'=>$job], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $job = Job::findOrFail($job->id);
        return response()->json($job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Job $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' =>'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'location' => 'sometimes|required',
            'company' => 'sometimes|required',
            'salary' => 'nullable|integer',
        ]);
        
        $job->update($data);
        return response()->json(['message'=>'Updated','job'=>$job]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, Job $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' =>'Forbidden' ], 403);
        }
        $job->delete();
        return response()->json(['message'=>'Deleted']);
    }

    public function publicIndex(Request $request)
    {
        $query = Job::query();

        // Filter optional
        if ($request->has('company')) {
            $query->where('company', 'LIKE', '%' . $request->company . '%');
        }

        if ($request->has('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $jobs = $query->paginate($perPage);

        return response()->json([
            "message" => "Public job list",
            "data" => $jobs
        ]);
    }

}
