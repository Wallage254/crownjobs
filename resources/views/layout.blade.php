<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CrownOpportunities - UK Jobs for African Professionals')</title>
    <meta name="description" content="@yield('description', 'Find visa-sponsored UK job opportunities in construction, healthcare, hospitality, and skilled trades. Connect African professionals with UK employers.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crown-gold': '#D4AF37',
                        'crown-blue': '#1E3A8A',
                        'crown-gray': '#64748B',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Form Handler -->
    <script src="/js/forms.js"></script>
    
    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1E3A8A 0%, #D4AF37 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #1E3A8A 0%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="{ mobileMenuOpen: false }" class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-gradient">👑 CrownOpportunities</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="/" class="text-gray-900 hover:text-crown-blue px-3 py-2 text-sm font-medium">Home</a>
                        <a href="/jobs" class="text-gray-900 hover:text-crown-blue px-3 py-2 text-sm font-medium">Jobs</a>
                        <a href="#testimonials" class="text-gray-900 hover:text-crown-blue px-3 py-2 text-sm font-medium">Success Stories</a>
                        <a href="#contact" class="text-gray-900 hover:text-crown-blue px-3 py-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:text-crown-blue">Home</a>
                    <a href="/jobs" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:text-crown-blue">Jobs</a>
                    <a href="#testimonials" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:text-crown-blue">Success Stories</a>
                    <a href="#contact" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:text-crown-blue">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl font-bold text-crown-gold">👑 CrownOpportunities</span>
                    </div>
                    <p class="text-gray-300 mb-4">Connecting African professionals with UK job opportunities. Find visa-sponsored positions in construction, healthcare, hospitality, and skilled trades.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/jobs" class="text-gray-300 hover:text-crown-gold">Find Jobs</a></li>
                        <li><a href="#testimonials" class="text-gray-300 hover:text-crown-gold">Success Stories</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-crown-gold">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-crown-gold">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-crown-gold">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-crown-gold">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} CrownOpportunities. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>