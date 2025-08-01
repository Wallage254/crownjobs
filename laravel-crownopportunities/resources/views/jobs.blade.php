@extends('layout')

@section('title', 'UK Jobs - CrownOpportunities')
@section('description', 'Browse visa-sponsored UK job opportunities. Filter by category, location, and salary. Apply directly to employers seeking international talent.')

@section('content')
<div x-data="jobsPage()" class="bg-gray-50 min-h-screen">
    <!-- Search Header -->
    <section class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Find Your Perfect Job</h1>
                <p class="text-xl text-gray-600">Discover visa-sponsored opportunities across the UK</p>
            </div>
            
            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" x-model="filters.search" @input="searchJobs" 
                               placeholder="Search jobs, companies, locations..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue text-lg">
                    </div>
                    <button @click="searchJobs" 
                            class="bg-crown-blue text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                        Search Jobs
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Jobs</h3>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select x-model="filters.category" @change="searchJobs" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Location Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" x-model="filters.location" @input="searchJobs" 
                               placeholder="Enter city or region" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                    </div>
                    
                    <!-- Job Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                        <select x-model="filters.job_type" @change="searchJobs" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            <option value="">All Types</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                    
                    <!-- Salary Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Salary Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" x-model="filters.min_salary" @input="searchJobs" 
                                   placeholder="Min" 
                                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            <input type="number" x-model="filters.max_salary" @input="searchJobs" 
                                   placeholder="Max" 
                                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                        </div>
                    </div>
                    
                    <!-- Visa Sponsorship -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" x-model="filters.visa_sponsored" @change="searchJobs" 
                                   class="rounded border-gray-300 text-crown-blue focus:ring-crown-blue">
                            <span class="ml-2 text-sm text-gray-700">Visa Sponsored Only</span>
                        </label>
                    </div>
                    
                    <!-- Clear Filters -->
                    <button @click="clearFilters" 
                            class="w-full text-center text-crown-blue hover:text-blue-800 text-sm font-medium">
                        Clear All Filters
                    </button>
                </div>
            </div>
            
            <!-- Jobs List -->
            <div class="lg:w-3/4">
                <!-- Results Info -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">
                            <span x-show="!loading">Showing <span x-text="jobs.length"></span> jobs</span>
                            <span x-show="loading">Loading jobs...</span>
                        </p>
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-600">Sort by:</label>
                            <select x-model="sortBy" @change="searchJobs" 
                                    class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-crown-blue focus:border-crown-blue">
                                <option value="newest">Newest First</option>
                                <option value="salary_high">Highest Salary</option>
                                <option value="salary_low">Lowest Salary</option>
                                <option value="company">Company A-Z</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-crown-blue mx-auto"></div>
                    <p class="text-gray-600 mt-4">Loading jobs...</p>
                </div>
                
                <!-- Jobs Grid -->
                <div x-show="!loading" class="grid gap-6">
                    <template x-for="job in jobs" :key="job.id">
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2" x-text="job.title"></h3>
                                    <p class="text-crown-blue font-medium text-lg" x-text="job.company"></p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span x-show="job.is_urgent" class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                        Urgent
                                    </span>
                                    <span x-show="job.visa_sponsored" class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                        Visa Sponsored
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="job.location"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="job.job_type"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h4c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="job.category"></span>
                                </div>
                                <div class="flex items-center" x-show="job.salary_min && job.salary_max">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="`£${job.salary_min?.toLocaleString()} - £${job.salary_max?.toLocaleString()}`"></span>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 mb-4 line-clamp-3" x-text="job.description.substring(0, 150) + '...'"></p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500" x-text="new Date(job.created_at).toLocaleDateString()"></span>
                                <a :href="`/jobs/${job.id}`" 
                                   class="bg-crown-blue text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-800 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- No Results -->
                <div x-show="!loading && jobs.length === 0" class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No jobs found</h3>
                    <p class="text-gray-600 mb-4">Try adjusting your search criteria or clear the filters</p>
                    <button @click="clearFilters" 
                            class="bg-crown-blue text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-800 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function jobsPage() {
    return {
        jobs: [],
        loading: true,
        filters: {
            search: '',
            category: '',
            location: '',
            job_type: '',
            min_salary: '',
            max_salary: '',
            visa_sponsored: false
        },
        sortBy: 'newest',
        
        init() {
            this.searchJobs();
        },
        
        async searchJobs() {
            this.loading = true;
            
            try {
                const params = new URLSearchParams();
                
                // Add non-empty filters to params
                Object.keys(this.filters).forEach(key => {
                    const value = this.filters[key];
                    if (value !== '' && value !== false) {
                        params.append(key, value);
                    }
                });
                
                const response = await fetch(`/api/jobs?${params.toString()}`);
                const data = await response.json();
                
                // Sort jobs based on sortBy
                this.jobs = this.sortJobs(data);
            } catch (error) {
                console.error('Error fetching jobs:', error);
                this.jobs = [];
            } finally {
                this.loading = false;
            }
        },
        
        sortJobs(jobs) {
            switch (this.sortBy) {
                case 'salary_high':
                    return jobs.sort((a, b) => (b.salary_max || 0) - (a.salary_max || 0));
                case 'salary_low':
                    return jobs.sort((a, b) => (a.salary_min || 0) - (b.salary_min || 0));
                case 'company':
                    return jobs.sort((a, b) => a.company.localeCompare(b.company));
                case 'newest':
                default:
                    return jobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }
        },
        
        clearFilters() {
            this.filters = {
                search: '',
                category: '',
                location: '',
                job_type: '',
                min_salary: '',
                max_salary: '',
                visa_sponsored: false
            };
            this.searchJobs();
        }
    }
}
</script>
@endpush