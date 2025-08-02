@extends('layout')

@section('title', 'Admin Panel - CrownOpportunities')

@section('content')
<div x-data="adminPanel()" x-init="checkAuth()" class="bg-gray-50 min-h-screen">
    <!-- Login Required Message -->
    <div x-show="!isAuthenticated" class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Admin Access Required</h1>
            <p class="text-gray-600 mb-6">Please log in to access the admin panel.</p>
            <a href="/admin/login" class="bg-crown-blue text-white px-6 py-3 rounded-lg hover:bg-blue-800">Go to Login</a>
        </div>
    </div>
    
    <!-- Admin Panel Content -->
    <div x-show="isAuthenticated" class="relative">
        <!-- Header with Logout -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-crown-blue">CrownOpportunities Admin</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, <span x-text="adminUser?.username || 'Admin'"></span></span>
                    <button @click="logout()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Panel</h1>
            <p class="text-gray-600">Manage jobs, applications, testimonials, and categories</p>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'jobs'" 
                        :class="activeTab === 'jobs' ? 'border-crown-blue text-crown-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Jobs
                </button>
                <button @click="activeTab = 'applications'" 
                        :class="activeTab === 'applications' ? 'border-crown-blue text-crown-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Applications
                </button>
                <button @click="activeTab = 'categories'" 
                        :class="activeTab === 'categories' ? 'border-crown-blue text-crown-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Categories
                </button>
                <button @click="activeTab = 'testimonials'" 
                        :class="activeTab === 'testimonials' ? 'border-crown-blue text-crown-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Testimonials
                </button>
                <button @click="activeTab = 'messages'" 
                        :class="activeTab === 'messages' ? 'border-crown-blue text-crown-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Messages
                </button>
            </nav>
        </div>

        <!-- Categories Tab -->
        <div x-show="activeTab === 'categories'" class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Categories</h2>
                    <button @click="showCategoryForm = true; editingCategory = null" 
                            class="bg-crown-blue text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                        Add Category
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="category in categories" :key="category.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="category.name"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500" x-text="category.description || 'No description'"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="category.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                                              class="px-2 py-1 text-xs rounded-full" x-text="category.is_active ? 'Active' : 'Inactive'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="editCategory(category)" class="text-crown-blue hover:text-blue-800 mr-3">Edit</button>
                                        <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Category Form Modal -->
            <div x-show="showCategoryForm" x-transition class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold mb-4" x-text="editingCategory ? 'Edit Category' : 'Add Category'"></h3>
                    <form @submit.prevent="saveCategory">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" x-model="categoryForm.name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea x-model="categoryForm.description" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" x-model="categoryForm.is_active" 
                                       class="rounded border-gray-300 text-crown-blue focus:ring-crown-blue">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showCategoryForm = false" 
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-crown-blue text-white rounded-lg hover:bg-blue-800">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Jobs Tab -->
        <div x-show="activeTab === 'jobs'" class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Jobs</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visa Sponsored</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="job in jobs" :key="job.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="job.title"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="job.company"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="job.location"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="job.visa_sponsored ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                                              class="px-2 py-1 text-xs rounded-full" x-text="job.visa_sponsored ? 'Yes' : 'No'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="deleteJob(job.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Other tabs content... -->
        <div x-show="activeTab === 'applications'" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Applications</h2>
            <p class="text-gray-600">Application management functionality would be implemented here.</p>
        </div>

        <div x-show="activeTab === 'testimonials'" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Testimonials</h2>
            <p class="text-gray-600">Testimonial management functionality would be implemented here.</p>
        </div>

        <div x-show="activeTab === 'messages'" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Messages</h2>
            <p class="text-gray-600">Message management functionality would be implemented here.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function adminPanel() {
    return {
        activeTab: 'categories',
        isAuthenticated: false,
        adminUser: null,
        categories: [],
        jobs: [],
        applications: [],
        testimonials: [],
        messages: [],
        showCategoryForm: false,
        editingCategory: null,
        categoryForm: {
            name: '',
            description: '',
            is_active: true
        },
        
        init() {
            // Removed - this will be called by checkAuth() if authenticated
        },
        
        // Authentication methods
        checkAuth() {
            const token = localStorage.getItem('admin_token');
            const user = localStorage.getItem('admin_user');
            
            if (token && user) {
                this.isAuthenticated = true;
                this.adminUser = JSON.parse(user);
                this.loadInitialData();
            } else {
                this.isAuthenticated = false;
            }
        },
        
        logout() {
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            this.isAuthenticated = false;
            window.location.href = '/admin/login';
        },
        
        loadInitialData() {
            this.loadCategories();
            this.loadJobs();
            this.loadApplications();
            this.loadTestimonials();
            this.loadMessages();
        },
        
        async apiRequest(url, options = {}) {
            const token = localStorage.getItem('admin_token');
            return fetch(url, {
                ...options,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    ...options.headers
                }
            });
        },
        
        async loadCategories() {
            try {
                const response = await this.apiRequest('/api/categories');
                this.categories = await response.json();
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        },
        
        async loadJobs() {
            try {
                const response = await this.apiRequest('/api/jobs');
                this.jobs = await response.json();
            } catch (error) {
                console.error('Error loading jobs:', error);
            }
        },
        
        async loadApplications() {
            try {
                const response = await this.apiRequest('/api/applications');
                this.applications = await response.json();
            } catch (error) {
                console.error('Error loading applications:', error);
            }
        },
        
        async loadTestimonials() {
            try {
                const response = await this.apiRequest('/api/testimonials');
                this.testimonials = await response.json();
            } catch (error) {
                console.error('Error loading testimonials:', error);
            }
        },
        
        async loadMessages() {
            try {
                const response = await this.apiRequest('/api/messages');
                this.messages = await response.json();
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        },
        
        editCategory(category) {
            this.editingCategory = category;
            this.categoryForm = {
                name: category.name,
                description: category.description || '',
                is_active: category.is_active
            };
            this.showCategoryForm = true;
        },
        
        async saveCategory() {
            try {
                const url = this.editingCategory ? `/api/categories/${this.editingCategory.id}` : '/api/categories';
                const method = this.editingCategory ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(this.categoryForm)
                });
                
                if (response.ok) {
                    this.showCategoryForm = false;
                    this.loadCategories();
                    this.categoryForm = { name: '', description: '', is_active: true };
                    this.editingCategory = null;
                }
            } catch (error) {
                console.error('Error saving category:', error);
            }
        },
        
        async deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                try {
                    const response = await fetch(`/api/categories/${id}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        this.loadCategories();
                    }
                } catch (error) {
                    console.error('Error deleting category:', error);
                }
            }
        },
        
        async deleteJob(id) {
            if (confirm('Are you sure you want to delete this job?')) {
                try {
                    const response = await fetch(`/api/jobs/${id}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        this.loadJobs();
                    }
                } catch (error) {
                    console.error('Error deleting job:', error);
                }
            }
        },
        
        // Authentication methods
        checkAuth() {
            const token = localStorage.getItem('admin_token');
            const user = localStorage.getItem('admin_user');
            
            if (token && user) {
                this.isAuthenticated = true;
                this.adminUser = JSON.parse(user);
                this.loadInitialData();
            } else {
                this.isAuthenticated = false;
            }
        },
        
        logout() {
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            this.isAuthenticated = false;
            window.location.href = '/admin/login';
        },
        
        loadInitialData() {
            this.loadJobs();
            this.loadApplications();
            this.loadCategories();
            this.loadTestimonials();
            this.loadMessages();
        },
        
        async apiRequest(url, options = {}) {
            const token = localStorage.getItem('admin_token');
            return fetch(url, {
                ...options,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    ...options.headers
                }
            });
        }
    }
}
</script>
@endpush