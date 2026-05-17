<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MilaLaundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primaryBlue: '#011C45',
                        primaryBlueHover: '#022a66'
                    }
                }
            }
        }
    </script>
</head>
<body class="h-screen w-screen font-sans overflow-hidden flex flex-col items-center justify-center relative">
    
    <!-- Latar Belakang Gambar -->
    <div class="absolute inset-0 z-0">
        <!-- Menggunakan gambar dari unsplash bertema laundry/baju -->
        <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?q=80&w=2070&auto=format&fit=crop" alt="Laundry Background" class="w-full h-full object-cover">
        <!-- Efek Blur/Gelap -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    </div>

    <!-- Kotak Kaca Transparan -->
    <div class="relative z-10 w-full max-w-[400px] bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-8 flex flex-col items-center">
            <img src="{{ asset('image/ic_log.png') }}" alt="Logo" class="w-16 h-auto object-contain mb-3 drop-shadow-xl opacity-90">
            <h1 class="font-outfit text-white text-3xl font-bold tracking-widest uppercase mb-1 drop-shadow-md">Mila Laundry</h1>
            <p class="text-gray-200 text-sm font-medium tracking-wide drop-shadow-sm">Bersih, Wangi, Rapi</p>
            <div class="w-full h-px bg-white/20 mt-6"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            @if ($errors->any())
                <div class="bg-red-500/80 backdrop-blur text-white p-3 rounded-lg mb-4 text-sm font-medium border border-red-400/50">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Username/Email -->
            <div>
                <label for="email" class="block mb-1.5 text-sm font-medium text-white drop-shadow-sm">Email:</label>
                <input id="email" type="email" class="w-full px-4 py-2.5 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-colors" name="email" value="{{ old('email') }}" placeholder="masukkan email" required autofocus>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1.5 text-sm font-medium text-white drop-shadow-sm">Kata Sandi:</label>
                <div class="relative">
                    <input id="password" type="password" class="w-full px-4 py-2.5 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-colors pr-12 tracking-widest" name="password" placeholder="••••••••" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/70 hover:text-white transition-colors focus:outline-none">
                        <svg class="w-5 h-5" id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 mt-4 bg-primaryBlue/90 hover:bg-primaryBlue text-white rounded-lg font-outfit text-sm font-bold tracking-wider uppercase transition-colors shadow-lg border border-primaryBlue/50">
                Masuk
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="relative z-10 mt-8 text-center">
        <p class="text-white/70 text-sm font-medium tracking-wide">© 2026 Mila Laundry TA</p>
    </div>

<script>
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePasswordBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle><line x1="1" y1="1" x2="23" y2="23" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>';
        } else {
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    });
</script>
</body>
</html>
