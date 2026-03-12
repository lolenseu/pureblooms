<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureBlooms - Login QR Code</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    
    <!-- Main QR Code Card -->
    <div class="max-w-lg w-full">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="text-5xl">🌸</span>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">
                PureBlooms
            </h1>
            <p class="text-lg text-gray-600">
                Flower Shop
            </p>
        </div>

        <!-- QR Code Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            
            <!-- Icon -->
            <div class="w-20 h-20 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                <span class="text-4xl">🔐</span>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Scan to Login
            </h2>
            <p class="text-gray-500 mb-8">
                Access your PureBlooms account
            </p>

            <!-- QR Code -->
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-6 rounded-2xl inline-block mb-8">
                <div class="bg-white p-4 rounded-2xl shadow-xl border-4 border-rose-100">
                    {!! $qrCode !!}
                </div>
            </div>

            <!-- Login URL -->
            <div class="p-4 bg-rose-50 rounded-xl mb-6">
                <p class="text-xs text-gray-500 mb-2">Login Link:</p>
                <a href="{{ $loginUrl }}" target="_blank" 
                   class="text-sm text-rose-600 font-semibold hover:text-rose-700 break-all">
                    {{ $loginUrl }}
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ $loginUrl }}" target="_blank" 
                   class="block w-full px-6 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
                    🔗 Open Login Page
                </a>
                <button onclick="copyToClipboard('{{ $loginUrl }}')" 
                        class="block w-full px-6 py-4 bg-white border-2 border-rose-200 text-rose-600 font-bold rounded-xl hover:bg-rose-50 transition">
                    📋 Copy Link
                </button>
            </div>

            <!-- Instructions -->
            <div class="mt-8 pt-8 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 mb-4">📱 How to Use:</h3>
                <div class="space-y-3 text-left">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-rose-600">1</span>
                        </div>
                        <p class="text-sm text-gray-600">Open your phone's camera app</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-rose-600">2</span>
                        </div>
                        <p class="text-sm text-gray-600">Point camera at the QR code</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-rose-600">3</span>
                        </div>
                        <p class="text-sm text-gray-600">Tap the notification to open PureBlooms login</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} PureBlooms Flower Shop
            </p>
        </div>

    </div>

    <!-- Copy Toast Notification -->
    <div id="copyToast" class="fixed bottom-6 right-6 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        ✅ Link copied to clipboard!
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.remove('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            });
        }
    </script>
</body>
</html>