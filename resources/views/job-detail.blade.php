@extends('layout')

@section('title', $job->title . ' at ' . $job->company . ' - CrownOpportunities')
@section('description', 'Apply for ' . $job->title . ' at ' . $job->company . ' in ' . $job->location . '. ' . Str::limit($job->description, 150))

@section('content')
<div x-data="jobDetailPage()" class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="/jobs" class="inline-flex items-center text-crown-blue hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Jobs
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Job Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <!-- Job Header -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                                <p class="text-xl text-crown-blue font-semibold">{{ $job->company }}</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                @if($job->is_urgent)
                                    <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full font-medium">Urgent Hiring</span>
                                @endif
                                @if($job->visa_sponsored)
                                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">Visa Sponsored</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $job->location }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $job->job_type }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h4c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $job->category }}</span>
                            </div>
                        </div>
                        
                        @if($job->salary_min && $job->salary_max)
                        <div class="mt-4">
                            <div class="text-2xl font-bold text-crown-gold">
                                £{{ number_format($job->salary_min) }} - £{{ number_format($job->salary_max) }} per year
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Job Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                    
                    <!-- Requirements -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Requirements</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                    
                    <!-- Company Images -->
                    @if($job->workplace_images && count($job->workplace_images) > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Workplace Images</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($job->workplace_images as $image)
                                <img src="{{ Storage::url($image) }}" alt="Workplace" class="rounded-lg shadow-md w-full h-48 object-cover">
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Posted Date -->
                    <div class="text-sm text-gray-500 border-t border-gray-200 pt-4">
                        Posted on {{ $job->created_at->format('F j, Y') }}
                        @if($job->updated_at != $job->created_at)
                            • Updated {{ $job->updated_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Application Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Apply for this Position</h2>
                    
                    <form @submit.prevent="submitApplication" enctype="multipart/form-data">
                        <div class="space-y-4">
                            <!-- Personal Information -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                    <input type="text" x-model="form.first_name" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                    <input type="text" x-model="form.last_name" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" x-model="form.email" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                <input type="tel" x-model="form.phone" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Location *</label>
                                <input type="text" x-model="form.current_location" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            
                            <!-- Experience Information -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Previous Role</label>
                                <input type="text" x-model="form.previous_role" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Experience</label>
                                <textarea x-model="form.experience" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"
                                          placeholder="Brief description of your relevant experience"></textarea>
                            </div>
                            
                            <!-- File Uploads -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                                <input type="file" @change="handleFileUpload($event, 'profile_photo')" 
                                       accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CV/Resume *</label>
                                <input type="file" @change="handleFileUpload($event, 'cv_file')" 
                                       accept=".pdf,.doc,.docx" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX up to 10MB</p>
                            </div>
                            
                            <!-- Cover Letter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter</label>
                                <textarea x-model="form.cover_letter" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"
                                          placeholder="Why are you interested in this position?"></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" :disabled="loading" 
                                    class="w-full bg-crown-blue text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-800 transition-colors disabled:opacity-50">
                                <span x-show="!loading">Submit Application</span>
                                <span x-show="loading">Submitting...</span>
                            </button>
                            
                            <!-- Success/Error Messages -->
                            <div x-show="success" class="p-4 bg-green-100 text-green-700 rounded-lg">
                                Application submitted successfully! We'll be in touch soon.
                            </div>
                            
                            <div x-show="error" class="p-4 bg-red-100 text-red-700 rounded-lg" x-text="errorMessage">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function jobDetailPage() {
    return {
        form: {
            job_id: '{{ $job->id }}',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            current_location: '',
            previous_role: '',
            experience: '',
            cover_letter: ''
        },
        files: {
            profile_photo: null,
            cv_file: null
        },
        loading: false,
        success: false,
        error: false,
        errorMessage: '',
        
        handleFileUpload(event, fieldName) {
            const file = event.target.files[0];
            if (file) {
                this.files[fieldName] = file;
            }
        },
        
        async submitApplication() {
            this.loading = true;
            this.success = false;
            this.error = false;
            
            try {
                const formData = new FormData();
                
                // Add form fields
                Object.keys(this.form).forEach(key => {
                    if (this.form[key]) {
                        formData.append(key, this.form[key]);
                    }
                });
                
                // Add files
                Object.keys(this.files).forEach(key => {
                    if (this.files[key]) {
                        formData.append(key, this.files[key]);
                    }
                });
                
                const response = await fetch('/api/applications', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });
                
                if (response.ok) {
                    this.success = true;
                    // Reset form
                    this.form = {
                        job_id: '{{ $job->id }}',
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        current_location: '',
                        previous_role: '',
                        experience: '',
                        cover_letter: ''
                    };
                    this.files = {
                        profile_photo: null,
                        cv_file: null
                    };
                    // Reset file inputs
                    document.querySelectorAll('input[type="file"]').forEach(input => {
                        input.value = '';
                    });
                } else {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to submit application');
                }
            } catch (error) {
                this.error = true;
                this.errorMessage = error.message || 'Failed to submit application. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush