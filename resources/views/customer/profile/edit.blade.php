<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                ✏️ Edit Profile
            </h2>
            <a href="{{ route('customer.profile.show') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">
                ← Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                    <p class="font-bold mb-2">❌ Validation Errors</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Edit Profile Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 px-6 py-5">
                    <h3 class="text-2xl font-bold text-white">Update Your Information</h3>
                    <p class="text-rose-100 mt-1">Keep your profile up to date</p>
                </div>

                <form action="{{ route('customer.profile.update') }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition @error('name') border-red-500 @enderror"
                                   placeholder="Enter your full name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email address">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition @error('phone') border-red-500 @enderror"
                                   placeholder="Enter your phone number (optional)">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('customer.profile.show') }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">
                                💾 Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-1">Quick Tips:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Email must be unique across all accounts</li>
                            <li>• Phone number is optional but recommended for order updates</li>
                            <li>• To change your password, use the "Change Password" link in your profile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>