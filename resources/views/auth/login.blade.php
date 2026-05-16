<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MilaLaundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS v3 via CDN -->
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
<body class="h-screen w-screen font-sans bg-white overflow-hidden md:overflow-hidden overflow-auto">

<div class="flex flex-col md:flex-row h-full w-full">
    <!-- Left Side: Logo -->
    <div class="flex-none md:flex-1 h-[40vh] md:h-full bg-primaryBlue flex items-center justify-center">
        <!-- Using the image provided by user -->
        <img src="{{ asset('image/ic_logo.png') }}" alt="Mila Laundry Logo" class="max-w-[50%] md:max-w-[60%] max-h-[80%] md:max-h-none h-auto object-contain">
    </div>

    <!-- Right Side: Login Form -->
    <div class="flex-none md:flex-1 h-[60vh] md:h-full flex items-center justify-center bg-white p-[2rem]">
        <div class="w-full max-w-[450px] p-[40px]">
            <div class="text-center mb-[50px]">
                <h2 class="font-outfit text-primaryBlue text-[1.8rem] font-bold leading-[1.5] uppercase">SELAMAT DATANG<br>SILAHKAN MASUK</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-[12px] rounded-[6px] mb-[25px] text-[0.95rem] text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-[25px]">
                    <label for="email" class="block mb-[10px] text-black font-semibold text-[1rem]">Email:</label>
                    <input id="email" type="email" class="w-full p-[14px_16px] border border-[#A0AAB5] rounded-[4px] text-[1rem] text-[#333] transition duration-300 focus:outline-none focus:border-primaryBlue" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-[25px]">
                    <label for="password" class="block mb-[10px] text-black font-semibold text-[1rem]">Kata Sandi:</label>
                    <div class="relative flex items-center">
                        <input id="password" type="password" class="w-full p-[14px_16px] border border-[#A0AAB5] rounded-[4px] text-[1rem] text-[#333] transition duration-300 focus:outline-none focus:border-primaryBlue" name="password" required>
                        <!-- Eye Icon SVG -->
                        <svg class="absolute right-[15px] cursor-pointer text-[#666] w-[22px] h-[22px]" id="togglePassword" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                </div>

                <button type="submit" class="block w-[160px] mx-auto mt-[40px] p-[14px] bg-primaryBlue text-white border-none rounded-[8px] font-outfit text-[1.1rem] font-semibold cursor-pointer transition duration-300 text-center hover:bg-primaryBlueHover">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // toggle the icon (remove line for visibility)
        if (type === 'text') {
            this.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        } else {
            this.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle><line x1="1" y1="1" x2="23" y2="23"></line>';
        }
    });
</script>
</body>
</html>
