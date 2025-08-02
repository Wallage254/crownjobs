<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(): JsonResponse
    {
        $applications = Application::with('job')->orderBy('created_at', 'desc')->get();
        return response()->json($applications);
    }

    public function show(string $id): JsonResponse
    {
        $application = Application::with('job')->findOrFail($id);
        return response()->json($application);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_id' => 'required|uuid|exists:jobs,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'current_location' => 'required|string|max:255',
            'cover_letter' => 'nullable|string',
            'experience' => 'nullable|string',
            'previous_role' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('uploads', 'public');
            $validated['profile_photo'] = $photoPath;
        }

        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('uploads', 'public');
            $validated['cv_file'] = $cvPath;
        }

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'pending';
        }

        $application = Application::create($validated);
        return response()->json($application->load('job'), 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $application = Application::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'in:pending,reviewing,shortlisted,rejected,hired',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|max:255',
            'phone' => 'string|max:255',
            'current_location' => 'string|max:255',
            'cover_letter' => 'nullable|string',
            'experience' => 'nullable|string',
            'previous_role' => 'nullable|string|max:255',
        ]);

        $application->update($validated);
        return response()->json($application->load('job'));
    }

    public function destroy(string $id): JsonResponse
    {
        $application = Application::findOrFail($id);
        
        // Delete associated files
        if ($application->profile_photo) {
            Storage::disk('public')->delete($application->profile_photo);
        }
        if ($application->cv_file) {
            Storage::disk('public')->delete($application->cv_file);
        }
        
        $application->delete();
        return response()->json(['message' => 'Application deleted successfully']);
    }
}
