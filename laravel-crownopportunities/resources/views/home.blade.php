@extends('layout')

@section('title', 'CrownOpportunities - UK Jobs for African Professionals')
@section('description', 'Find visa-sponsored UK job opportunities in construction, healthcare, hospitality, and skilled trades. Connect African professionals with UK employers.')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Find Your Dream Job in the UK
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Connecting African professionals with visa-sponsored UK opportunities
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/jobs" class="bg-white text-crown-blue px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Explore Jobs
                </a>
                <a href="#contact" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-crown-blue transition-colors">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Job Categories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Popular Job Categories</h2>
            <p class="text-xl text-gray-600">Discover opportunities across various industries</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                @if($category->gif_url)
                    <img src="{{ $category->gif_url }}" alt="{{ $category->name }}" class="w-16 h-16 mx-auto mb-4">
                @else
                    <div class="w-16 h-16 mx-auto mb-4 bg-crown-gold rounded-full flex items-center justify-center text-white text-2xl">
                        {{ substr($category->name, 0, 1) }}
                    </div>
                @endif
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                @if($category->description)
                    <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Recent Jobs -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Job Opportunities</h2>
            <p class="text-xl text-gray-600">Fresh visa-sponsored positions updated daily</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($recentJobs as $job)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $job->title }}</h3>
                        <p class="text-crown-blue font-medium">{{ $job->company }}</p>
                    </div>
                    @if($job->is_urgent)
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Urgent</span>
                    @endif
                </div>
                
                <div class="flex items-center text-gray-600 text-sm mb-2">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $job->location }}
                </div>
                
                <div class="flex items-center text-gray-600 text-sm mb-4">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $job->job_type }}
                </div>
                
                @if($job->salary_min && $job->salary_max)
                <div class="flex items-center justify-between mb-4">
                    <span class="text-lg font-semibold text-crown-gold">
                        £{{ number_format($job->salary_min) }} - £{{ number_format($job->salary_max) }}
                    </span>
                    @if($job->visa_sponsored)
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Visa Sponsored</span>
                    @endif
                </div>
                @endif
                
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($job->description, 120) }}</p>
                
                <a href="/jobs/{{ $job->id }}" class="block w-full text-center bg-crown-blue text-white py-2 px-4 rounded-lg hover:bg-blue-800 transition-colors">
                    View Details
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="text-center">
            <a href="/jobs" class="bg-crown-gold text-white px-8 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
                View All Jobs
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Success Stories</h2>
            <p class="text-xl text-gray-600">Hear from professionals who found their dream jobs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    @if($testimonial->photo)
                        <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full mr-4">
                    @else
                        <div class="w-12 h-12 rounded-full bg-crown-gold text-white flex items-center justify-center mr-4">
                            {{ substr($testimonial->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $testimonial->country }}</p>
                    </div>
                </div>
                
                <div class="flex items-center mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial->rating)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endif
                    @endfor
                </div>
                
                <p class="text-gray-700">{{ $testimonial->comment }}</p>
                
                @if($testimonial->video_url)
                    <a href="{{ $testimonial->video_url }}" target="_blank" class="inline-flex items-center mt-3 text-crown-blue hover:text-blue-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                        </svg>
                        Watch Video
                    </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Get in Touch</h2>
                <p class="text-xl text-gray-600">Have questions? We're here to help you find the perfect opportunity</p>
            </div>
            
            <form x-data="contactForm()" @submit.prevent="submitForm" class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="first_name" x-model="form.first_name" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="last_name" x-model="form.last_name" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" x-model="form.email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                </div>
                
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" id="subject" x-model="form.subject" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                </div>
                
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" x-model="form.message" required rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"></textarea>
                </div>
                
                <button type="submit" :disabled="loading" 
                        class="w-full bg-crown-blue text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-800 transition-colors disabled:opacity-50">
                    <span x-show="!loading">Send Message</span>
                    <span x-show="loading">Sending...</span>
                </button>
                
                <div x-show="success" class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    Thank you for your message! We'll get back to you soon.
                </div>
                
                <div x-show="error" class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg" x-text="errorMessage">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function contactForm() {
    return {
        form: {
            first_name: '',
            last_name: '',
            email: '',
            subject: '',
            message: ''
        },
        loading: false,
        success: false,
        error: false,
        errorMessage: '',
        
        async submitForm() {
            this.loading = true;
            this.success = false;
            this.error = false;
            
            try {
                const response = await fetch('/api/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.form)
                });
                
                if (response.ok) {
                    this.success = true;
                    this.form = {
                        first_name: '',
                        last_name: '',
                        email: '',
                        subject: '',
                        message: ''
                    };
                } else {
                    throw new Error('Failed to send message');
                }
            } catch (error) {
                this.error = true;
                this.errorMessage = 'Failed to send message. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush