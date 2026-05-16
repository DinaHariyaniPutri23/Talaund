<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MilaLaundry') - Premium Laundry Service</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
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
                        primaryBlue: '#1A365D',
                        primaryBlueHover: '#2B6CB0',
                        accentBlue: '#3182CE',
                        bgMain: '#F8FAFC',
                        textDark: '#0F172A',
                        textGray: '#475569',
                        textLight: '#94A3B8'
                    },
                    boxShadow: {
                        card: '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01)',
                        hover: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-bgMain text-textDark min-h-screen overflow-x-hidden flex flex-col relative leading-relaxed">
    <!-- Background Shapes -->
    <div class="absolute rounded-full blur-[80px] -z-10 opacity-[0.08] w-[500px] h-[500px] bg-primaryBlue -top-[150px] -left-[150px]"></div>
    <div class="absolute rounded-full blur-[80px] -z-10 opacity-[0.08] w-[400px] h-[400px] bg-accentBlue -bottom-[100px] -right-[100px]"></div>

    @yield('content')
</body>
</html>
