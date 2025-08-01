<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Testimonial;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $recentJobs = Job::orderBy('created_at', 'desc')
                         ->where('visa_sponsored', true)
                         ->limit(6)
                         ->get();
        
        $testimonials = Testimonial::where('is_active', true)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(6)
                                  ->get();
        
        $categories = Category::where('is_active', true)
                             ->orderBy('name')
                             ->get();

        return view('home', compact('recentJobs', 'testimonials', 'categories'));
    }

    public function jobs(Request $request): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('jobs', compact('categories'));
    }

    public function jobDetail(string $id): View
    {
        $job = Job::findOrFail($id);
        return view('job-detail', compact('job'));
    }

    public function admin(): View
    {
        return view('admin');
    }
}
