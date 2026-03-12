<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                ✏️ Edit User
            </h2>
            <a href="{{ route('admin.users.show', $user->id) }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">
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

            <!-- Edit User Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 px-6 py-5">
                    <h3 class="text-2xl font-bold text-white">Edit Customer Information</h3>
                    <p class="text-rose-100 mt-1">Update the user's details and account settings</p>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8" id="editUserForm">
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
                                   placeholder="Enter customer's full name">
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
                                   placeholder="Enter email address">
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
                                   placeholder="Enter phone number (optional)">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Account Status
                            </label>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="text-gray-700">✅ Active</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" 
                                           name="is_active" 
                                           value="0" 
                                           {{ old('is_active', $user->is_active) ? '' : 'checked' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                    <span class="text-gray-700">❌ Inactive</span>
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Inactive users cannot login to the system</p>
                        </div>

                        <!-- ✅ Password Section with Strength Meter -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">🔐 Change Password</h4>
                            <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>

                            <!-- New Password with Requirements -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    New Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition @error('password') border-red-500 @enderror"
                                       placeholder="Enter new password (min. 8 characters)"
                                       autocomplete="new-password">
                                
                                <!-- Password Requirements Box -->
                                <div class="mt-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">🔐 Password Requirements:</p>
                                    <ul class="text-xs space-y-1">
                                        <li id="req-length" class="text-gray-500">❌ At least 8 characters</li>
                                        <li id="req-lower" class="text-gray-500">❌ One lowercase letter (a-z)</li>
                                        <li id="req-upper" class="text-gray-500">❌ One uppercase letter (A-Z)</li>
                                        <li id="req-number" class="text-gray-500">❌ One number (0-9)</li>
                                        <li id="req-special" class="text-gray-500">❌ One special character (@$!%*?&)</li>
                                    </ul>
                                    <!-- Strength Meter -->
                                    <div class="mt-3">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-gray-600">Strength:</span>
                                            <span id="strength-text" class="font-semibold">Not entered</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div id="strength-bar" class="bg-gray-400 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirm New Password
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition"
                                       placeholder="Re-enter new password"
                                       autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.users.show', $user->id) }}" 
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
                            <li>• Email must be unique across all users</li>
                            <li>• Password must be at least 8 characters with uppercase, lowercase, number & special char</li>
                            <li>• Inactive users will be logged out automatically</li>
                            <li>• All changes are logged for security</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Password Strength JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pwd = document.getElementById('password');
        if (!pwd) return;
        
        pwd.addEventListener('input', function() {
            const val = this.value;
            
            // Check requirements
            updateReq('req-length', val.length >= 8);
            updateReq('req-lower', /[a-z]/.test(val));
            updateReq('req-upper', /[A-Z]/.test(val));
            updateReq('req-number', /[0-9]/.test(val));
            updateReq('req-special', /[@$!%*?&]/.test(val));
            
            // Update strength meter
            let score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[a-z]/.test(val)) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[@$!%*?&]/.test(val)) score++;
            
            const pct = Math.min((score/5)*100, 100);
            const bar = document.getElementById('strength-bar');
            const txt = document.getElementById('strength-text');
            
            if (bar) {
                bar.style.width = pct + '%';
                
                if (pct <= 20) { 
                    bar.className = 'bg-red-500 h-2 rounded-full transition-all duration-300'; 
                    txt.textContent = 'Weak'; 
                    txt.className = 'font-semibold text-red-600'; 
                }
                else if (pct <= 40) { 
                    bar.className = 'bg-orange-500 h-2 rounded-full transition-all duration-300'; 
                    txt.textContent = 'Fair'; 
                    txt.className = 'font-semibold text-orange-600'; 
                }
                else if (pct <= 60) { 
                    bar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-300'; 
                    txt.textContent = 'Good'; 
                    txt.className = 'font-semibold text-yellow-600'; 
                }
                else if (pct <= 80) { 
                    bar.className = 'bg-blue-500 h-2 rounded-full transition-all duration-300'; 
                    txt.textContent = 'Strong'; 
                    txt.className = 'font-semibold text-blue-600'; 
                }
                else { 
                    bar.className = 'bg-emerald-500 h-2 rounded-full transition-all duration-300'; 
                    txt.textContent = 'Very Strong'; 
                    txt.className = 'font-semibold text-emerald-600'; 
                }
            }
        });
        
        function updateReq(id, met) {
            const el = document.getElementById(id);
            if (el) {
                // Keep the emoji + text format
                const text = el.textContent.substring(3); // Remove existing emoji
                el.textContent = (met ? '✅ ' : '❌ ') + text;
                el.className = met ? 'text-emerald-600 font-medium' : 'text-gray-500';
            }
        }
    });
    </script>
</x-app-layout>