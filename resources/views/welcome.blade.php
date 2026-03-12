<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureBlooms - Fresh Floral Artistry</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-mesh {
            background-color: #f43f5e;
            background-image: 
                radial-gradient(at 0% 0%, hsla(340,100%,76%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="selection:bg-rose-200">
    <div class="min-h-screen hero-mesh relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,...')"></div>

        <div class="container mx-auto px-6 py-8 relative z-10">
            <nav class="flex justify-between items-center mb-16 px-6 py-4 card-glass !rounded-full border-none shadow-none bg-white/10">
                <div class="flex items-center gap-3">
                    <span class="text-3xl filter drop-shadow-md">🌸</span>
                    <h1 class="text-2xl font-black text-white tracking-tighter uppercase">PureBlooms</h1>
                </div>
                <div class="hidden md:flex gap-4">
                    <a href="{{ route('login') }}" class="text-white font-medium hover:text-rose-200 transition px-4 py-2">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-rose-600 px-6 py-2 rounded-full font-bold hover:shadow-xl transition">Join Us</a>
                </div>
            </nav>

            <div class="flex flex-col lg:flex-row items-center justify-between mt-12 gap-12">
                <div class="lg:w-1/2 text-white">
                    <span class="inline-block px-4 py-1 rounded-full bg-white/20 text-sm font-semibold mb-6 backdrop-blur-sm">✨ 2026 Collection Now Live</span>
                    <h2 class="text-6xl lg:text-8xl font-black mb-8 leading-[0.9] tracking-tighter">
                        Artistry in <br><span class="text-rose-300 italic">Every Bloom.</span>
                    </h2>
                    <p class="text-xl text-rose-50 mb-10 max-w-lg leading-relaxed opacity-90">
                        Experience the scent of luxury. Hand-crafted bouquets delivered from the field to your door in under 3 hours.
                    </p>
                    <div class="flex flex-wrap gap-5">
                        <a href="{{ route('register') }}" class="btn-premium">
                            Start Shopping 🌺
                        </a>
                        <a href="#features" class="px-8 py-4 rounded-2xl border-2 border-white/30 text-white font-bold hover:bg-white/10 transition">
                            The Process
                        </a>
                    </div>
                </div>

                <div class="lg:w-5/12">
                    <div class="card-glass relative group rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="text-[10rem] text-center group-hover:scale-110 transition-transform duration-700">💐</div>
                        <div class="mt-6 text-center text-slate-800">
                            <h3 class="text-2xl font-bold italic">"The Midnight Rose"</h3>
                            <p class="text-sm text-slate-500">Our Best Seller of 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-12 border-b border-rose-50">
        <div class="container mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div><p class="text-3xl font-black text-rose-600">50k+</p> <p class="text-sm text-slate-500 uppercase tracking-widest">Happy Hearts</p></div>
            <div><p class="text-3xl font-black text-rose-600">100%</p> <p class="text-sm text-slate-500 uppercase tracking-widest">Organic</p></div>
            <div><p class="text-3xl font-black text-rose-600">3hr</p> <p class="text-sm text-slate-500 uppercase tracking-widest">Fast Delivery</p></div>
            <div><p class="text-3xl font-black text-rose-600">4.9/5</p> <p class="text-sm text-slate-500 uppercase tracking-widest">Rating</p></div>
        </div>
    </div>
</body>
</html>