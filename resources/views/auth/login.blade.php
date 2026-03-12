<x-guest-layout>
    <div class="min-h-[80vh] flex flex-col items-center justify-center">
        <div class="mb-8 text-center animate-in fade-in zoom-in duration-700">
            <a href="/" class="inline-block text-6xl mb-4 hover:scale-110 transition-transform">🌸</a>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
            <p class="text-slate-500 font-medium">The freshest blooms are waiting for you.</p>
        </div>

        <div class="w-full sm:max-w-md card-glass border-none shadow-2xl">
            
            <x-auth-session-status class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-xl border border-rose-100 text-sm font-bold" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                    <input id="email" 
                           class="input-field" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required autofocus 
                           placeholder="your@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-rose-500" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-rose-500 hover:text-rose-600 transition" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    
                    <input id="password" 
                           class="input-field"
                           type="password"
                           name="password"
                           required 
                           placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-rose-500" />
                </div>

                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="rounded-lg border-rose-200 text-rose-500 focus:ring-rose-500/20 w-5 h-5 transition cursor-pointer" name="remember">
                        <span class="ms-3 text-sm font-medium text-slate-600 group-hover:text-slate-900 transition">{{ __('Keep me signed in') }}</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-premium w-full text-lg shadow-rose-500/20">
                        {{ __('Sign In') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-rose-100/50 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    New to PureBlooms? 
                    <a href="{{ route('register') }}" class="text-rose-600 font-bold hover:underline">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>