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
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Jobs</h2>
                    <button @click="showJobForm = true; editingJob = null" 
                            class="bg-crown-blue text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                        Add Job
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span x-show="job.salary_min && job.salary_max" x-text="`£${job.salary_min?.toLocaleString()} - £${job.salary_max?.toLocaleString()}`"></span>
                                        <span x-show="!job.salary_min || !job.salary_max" class="text-gray-400">Not specified</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="job.visa_sponsored ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                                              class="px-2 py-1 text-xs rounded-full" x-text="job.visa_sponsored ? 'Yes' : 'No'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="editJob(job)" class="text-crown-blue hover:text-blue-800 mr-3">Edit</button>
                                        <button @click="deleteJob(job.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Job Form Modal -->
            <div x-show="showJobForm" x-transition class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
                    <h3 class="text-lg font-semibold mb-4" x-text="editingJob ? 'Edit Job' : 'Add Job'"></h3>
                    <form @submit.prevent="saveJob">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                                <input type="text" x-model="jobForm.title" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                                <input type="text" x-model="jobForm.company" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <input type="text" x-model="jobForm.category" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <input type="text" x-model="jobForm.location" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Min Salary (£)</label>
                                <input type="number" x-model="jobForm.salary_min" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Max Salary (£)</label>
                                <input type="number" x-model="jobForm.salary_max" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                                <select x-model="jobForm.job_type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Temporary">Temporary</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea x-model="jobForm.description" rows="4" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                            <textarea x-model="jobForm.requirements" rows="4" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"></textarea>
                        </div>
                        <div class="flex items-center space-x-6 mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" x-model="jobForm.is_urgent" 
                                       class="rounded border-gray-300 text-crown-blue focus:ring-crown-blue">
                                <span class="ml-2 text-sm text-gray-700">Urgent Hiring</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" x-model="jobForm.visa_sponsored" 
                                       class="rounded border-gray-300 text-crown-blue focus:ring-crown-blue">
                                <span class="ml-2 text-sm text-gray-700">Visa Sponsored</span>
                            </label>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showJobForm = false" 
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-crown-blue text-white rounded-lg hover:bg-blue-800">
                                Save Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Applications Tab -->
        <div x-show="activeTab === 'applications'" class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Job Applications</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="application in applications" :key="application.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <span x-text="application.first_name + ' ' + application.last_name"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span x-text="application.job?.title || 'N/A'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="application.email"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select @change="updateApplicationStatus(application.id, $event.target.value)" 
                                                :value="application.status"
                                                class="text-xs rounded-full px-2 py-1 border-0 bg-gray-100">
                                            <option value="pending">Pending</option>
                                            <option value="reviewing">Reviewing</option>
                                            <option value="shortlisted">Shortlisted</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="hired">Hired</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span x-text="new Date(application.created_at).toLocaleDateString()"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="viewApplication(application)" class="text-crown-blue hover:text-blue-800 mr-3">View</button>
                                        <button @click="deleteApplication(application.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Messages Tab -->
        <div x-show="activeTab === 'messages'" class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Contact Messages</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="message in messages" :key="message.id">
                                <tr :class="message.is_read ? 'bg-gray-50' : 'bg-white'">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <span x-text="message.first_name + ' ' + message.last_name"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="message.email"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500" x-text="message.subject"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span x-text="new Date(message.created_at).toLocaleDateString()"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="message.is_read ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'" 
                                              class="px-2 py-1 text-xs rounded-full" x-text="message.is_read ? 'Read' : 'Unread'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="viewMessage(message)" class="text-crown-blue hover:text-blue-800 mr-3">View</button>
                                        <button @click="markAsRead(message.id)" x-show="!message.is_read" class="text-green-600 hover:text-green-800 mr-3">Mark Read</button>
                                        <button @click="deleteMessage(message.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Testimonials Tab -->
        <div x-show="activeTab === 'testimonials'" class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Testimonials</h2>
                    <button @click="showTestimonialForm = true; editingTestimonial = null" 
                            class="bg-crown-blue text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                        Add Testimonial
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="testimonial in testimonials" :key="testimonial.id">
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <img :src="testimonial.photo_url || '/default-avatar.png'" 
                                     :alt="testimonial.name" 
                                     class="w-12 h-12 rounded-full mr-3 object-cover">
                                <div>
                                    <h3 class="font-semibold" x-text="testimonial.name"></h3>
                                    <p class="text-sm text-gray-600" x-text="testimonial.job_title"></p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-sm mb-3" x-text="testimonial.content"></p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <template x-for="i in 5" :key="i">
                                        <svg :class="i <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300'" 
                                             class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </template>
                                </div>
                                <div class="flex space-x-2">
                                    <button @click="editTestimonial(testimonial)" class="text-crown-blue hover:text-blue-800 text-sm">Edit</button>
                                    <button @click="deleteTestimonial(testimonial.id)" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Testimonial Form Modal -->
            <div x-show="showTestimonialForm" x-transition class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-screen overflow-y-auto">
                    <h3 class="text-lg font-semibold mb-4" x-text="editingTestimonial ? 'Edit Testimonial' : 'Add Testimonial'"></h3>
                    <form @submit.prevent="saveTestimonial">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" x-model="testimonialForm.name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                            <input type="text" x-model="testimonialForm.job_title" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea x-model="testimonialForm.content" rows="4" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <select x-model="testimonialForm.rating" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-crown-blue focus:border-crown-blue">
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" x-model="testimonialForm.is_featured" 
                                       class="rounded border-gray-300 text-crown-blue focus:ring-crown-blue">
                                <span class="ml-2 text-sm text-gray-700">Featured Testimonial</span>
                            </label>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showTestimonialForm = false" 
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-crown-blue text-white rounded-lg hover:bg-blue-800">
                                Save Testimonial
                            </button>
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
        showTestimonialForm: false,
        editingTestimonial: null,
        testimonialForm: {
            name: '',
            job_title: '',
            content: '',
            rating: 5,
            is_featured: false
        },
        showJobForm: false,
        editingJob: null,
        jobForm: {
            title: '',
            company: '',
            category: '',
            location: '',
            description: '',
            requirements: '',
            salary_min: '',
            salary_max: '',
            job_type: 'Full-time',
            is_urgent: false,
            visa_sponsored: false
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
                    const response = await this.apiRequest(`/api/categories/${id}`, {
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
        
        // Job management
        editJob(job) {
            this.editingJob = job;
            this.jobForm = { ...job };
            this.showJobForm = true;
        },
        
        async saveJob() {
            try {
                const url = this.editingJob ? `/api/jobs/${this.editingJob.id}` : '/api/jobs';
                const method = this.editingJob ? 'PUT' : 'POST';
                
                const response = await this.apiRequest(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.jobForm)
                });
                
                if (response.ok) {
                    this.showJobForm = false;
                    this.loadJobs();
                    this.jobForm = {
                        title: '', company: '', category: '', location: '',
                        description: '', requirements: '', salary_min: '',
                        salary_max: '', job_type: 'Full-time', is_urgent: false,
                        visa_sponsored: false
                    };
                    this.editingJob = null;
                }
            } catch (error) {
                console.error('Error saving job:', error);
            }
        },
        
        async deleteJob(jobId) {
            if (confirm('Are you sure you want to delete this job?')) {
                try {
                    const response = await this.apiRequest(`/api/jobs/${jobId}`, {
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
        
        // Application management
        async updateApplicationStatus(applicationId, newStatus) {
            try {
                const response = await this.apiRequest(`/api/applications/${applicationId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                
                if (response.ok) {
                    this.loadApplications();
                }
            } catch (error) {
                console.error('Error updating application status:', error);
            }
        },
        
        viewApplication(application) {
            const details = `Application Details:

Name: ${application.first_name} ${application.last_name}
Email: ${application.email}
Phone: ${application.phone || 'Not provided'}
Location: ${application.current_location || 'Not provided'}
Experience: ${application.experience || 'Not provided'}
Cover Letter: ${application.cover_letter || 'Not provided'}
Status: ${application.status || 'pending'}

Applied: ${new Date(application.created_at).toLocaleDateString()}`;
            
            alert(details);
        },
        
        async deleteApplication(applicationId) {
            if (confirm('Are you sure you want to delete this application?')) {
                try {
                    const response = await this.apiRequest(`/api/applications/${applicationId}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        this.loadApplications();
                    }
                } catch (error) {
                    console.error('Error deleting application:', error);
                }
            }
        },
        
        // Message management
        viewMessage(message) {
            const messageContent = `Message from ${message.first_name} ${message.last_name}

Subject: ${message.subject}
Email: ${message.email}
Phone: ${message.phone || 'Not provided'}

Message:
${message.message}

Received: ${new Date(message.created_at).toLocaleDateString()}`;
            
            alert(messageContent);
            if (!message.is_read) {
                this.markAsRead(message.id);
            }
        },
        
        async markAsRead(messageId) {
            try {
                const response = await this.apiRequest(`/api/messages/${messageId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ is_read: true })
                });
                
                if (response.ok) {
                    this.loadMessages();
                }
            } catch (error) {
                console.error('Error marking message as read:', error);
            }
        },
        
        async deleteMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                try {
                    const response = await this.apiRequest(`/api/messages/${messageId}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        this.loadMessages();
                    }
                } catch (error) {
                    console.error('Error deleting message:', error);
                }
            }
        },
        
        // Testimonial management
        editTestimonial(testimonial) {
            this.editingTestimonial = testimonial;
            this.testimonialForm = { ...testimonial };
            this.showTestimonialForm = true;
        },
        
        async saveTestimonial() {
            try {
                const url = this.editingTestimonial ? `/api/testimonials/${this.editingTestimonial.id}` : '/api/testimonials';
                const method = this.editingTestimonial ? 'PUT' : 'POST';
                
                const response = await this.apiRequest(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.testimonialForm)
                });
                
                if (response.ok) {
                    this.showTestimonialForm = false;
                    this.loadTestimonials();
                    this.testimonialForm = {
                        name: '', job_title: '', content: '',
                        rating: 5, is_featured: false
                    };
                    this.editingTestimonial = null;
                }
            } catch (error) {
                console.error('Error saving testimonial:', error);
            }
        },
        
        async deleteTestimonial(testimonialId) {
            if (confirm('Are you sure you want to delete this testimonial?')) {
                try {
                    const response = await this.apiRequest(`/api/testimonials/${testimonialId}`, {
                        method: 'DELETE'
                    });
                    
                    if (response.ok) {
                        this.loadTestimonials();
                    }
                } catch (error) {
                    console.error('Error deleting testimonial:', error);
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