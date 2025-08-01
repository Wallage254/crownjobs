<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Job::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('company', 'ILIKE', "%{$search}%")
                  ->orWhere('location', 'ILIKE', "%{$search}%")
                  ->orWhere('description', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->get('category') !== 'all') {
            $query->where('category', $request->get('category'));
        }

        // Filter by location
        if ($request->has('location') && $request->get('location') !== 'all') {
            $query->where('location', 'ILIKE', "%{$request->get('location')}%");
        }

        // Filter by visa sponsorship
        if ($request->has('visa_sponsored')) {
            $query->where('visa_sponsored', $request->boolean('visa_sponsored'));
        }

        // Filter by job type
        if ($request->has('job_type') && $request->get('job_type') !== 'all') {
            $query->where('job_type', $request->get('job_type'));
        }

        // Filter by salary range
        if ($request->has('min_salary')) {
            $query->where('salary_max', '>=', $request->get('min_salary'));
        }

        if ($request->has('max_salary')) {
            $query->where('salary_min', '<=', $request->get('max_salary'));
        }

        // Order by urgency and creation date
        $jobs = $query->orderBy('is_urgent', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return response()->json($jobs);
    }

    public function show(string $id): JsonResponse
    {
        $job = Job::with('applications')->findOrFail($id);
        return response()->json($job);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|min:0',
            'job_type' => 'required|string|max:255',
            'is_urgent' => 'boolean',
            'visa_sponsored' => 'boolean',
            'company_logo' => 'nullable|string',
            'workplace_images' => 'nullable|array',
        ]);

        $job = Job::create($validated);
        return response()->json($job, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $job = Job::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'company' => 'string|max:255',
            'category' => 'string|max:255',
            'location' => 'string|max:255',
            'description' => 'string',
            'requirements' => 'string',
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|min:0',
            'job_type' => 'string|max:255',
            'is_urgent' => 'boolean',
            'visa_sponsored' => 'boolean',
            'company_logo' => 'nullable|string',
            'workplace_images' => 'nullable|array',
        ]);

        $job->update($validated);
        return response()->json($job);
    }

    public function destroy(string $id): JsonResponse
    {
        $job = Job::findOrFail($id);
        $job->delete();
        
        return response()->json(['message' => 'Job deleted successfully']);
    }
}
