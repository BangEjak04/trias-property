<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trias Property - {{ __('welcome.title') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('TriasPropertySquareLogo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS (Vite or Fallback CDN) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                navy: '#242931',
                                gold: '#C2A370',
                                goldHover: '#ad8f5c',
                            }
                        },
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                            serif: ['Playfair Display', 'serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top, #242931 0%, #15181e 100%);
        }

        .serif-font {
            font-family: 'Playfair Display', serif;
        }

        .blueprint-grid {
            background-size: 32px 32px;
            background-image:
                linear-gradient(to right, rgba(194, 163, 112, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(194, 163, 112, 0.04) 1px, transparent 1px);
        }

        .custom-card-shadow {
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.6),
                0 0 0 1.5px rgba(194, 163, 112, 0.25);
        }
    </style>
</head>

<body class="blueprint-grid text-slate-100 min-h-screen flex flex-col justify-between p-4 sm:p-6 antialiased">

    <!-- Top Bar: Navigation & Lang Switcher -->
    <header class="w-full max-w-lg mx-auto flex justify-between items-center py-2 z-10">
        <!-- Language Switcher -->
        <div
            class="flex items-center space-x-1 bg-[#242931]/90 border border-slate-700 p-1 rounded-full text-xs font-semibold">
            <a href="{{ route('set-locale', 'id') }}"
                class="px-3 py-1 rounded-full transition {{ app()->getLocale() == 'id' ? 'bg-[#C2A370] text-[#242931]' : 'text-slate-400 hover:text-slate-200' }}">
                ID
            </a>
            <a href="{{ route('set-locale', 'en') }}"
                class="px-3 py-1 rounded-full transition {{ app()->getLocale() == 'en' ? 'bg-[#C2A370] text-[#242931]' : 'text-slate-400 hover:text-slate-200' }}">
                EN
            </a>
        </div>

        <!-- Auth Navigation -->
        @if (Route::has('filament.app.auth.login'))
            <nav>
                @auth
                    <a href="{{ url('/app') }}"
                        class="inline-flex items-center space-x-1 bg-[#C2A370] hover:bg-[#ad8f5c] text-[#242931] font-bold px-4 py-1.5 rounded-full text-xs transition duration-200 shadow-md shadow-[#C2A370]/20">
                        <span>{{ __('welcome.dashboard') }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('filament.app.auth.login') }}"
                        class="inline-flex items-center space-x-1 bg-[#242931] border border-[#C2A370]/30 hover:border-[#C2A370] text-slate-200 hover:text-white px-4 py-1.5 rounded-full text-xs transition duration-200">
                        <svg class="w-3.5 h-3.5 text-[#C2A370] mr-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span>{{ __('welcome.login') }}</span>
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Container -->
    <main class="w-full max-w-md mx-auto flex-1 flex flex-col justify-center py-8">
        <div
            class="bg-[#242931]/95 border-2 border-[#C2A370]/60 rounded-3xl p-6 sm:p-8 text-center custom-card-shadow relative overflow-hidden">
            <!-- Decorative Accent line at top -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#C2A370] via-[#dfcdb0] to-[#C2A370]">
            </div>

            <!-- Profile Area -->
            <div class="flex flex-col items-center mt-2 mb-6">
                <!-- Circular Logo Container -->
                <div
                    class="relative w-24 h-24 bg-white rounded-full p-2.5 flex items-center justify-center border-4 border-[#C2A370] shadow-xl mb-4 transform hover:scale-105 transition duration-300">
                    <img class="max-h-full max-w-full object-contain" src="{{ asset('LightLogo.png') }}"
                        alt="Trias Property Logo">
                </div>

                <!-- Badge -->
                <div
                    class="inline-flex items-center space-x-1.5 bg-[#C2A370]/10 border border-[#C2A370]/30 px-3 py-1 rounded-full text-xs text-[#C2A370] font-bold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5 text-[#C2A370]" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2H7a1 1 0 100-2h.01zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __('welcome.official_portal') }}</span>
                </div>

                <!-- Title -->
                <h1 class="serif-font text-3xl font-bold text-[#C2A370] tracking-wider">
                    TRIAS PROPERTY
                </h1>

                <!-- Subtitle -->
                <p
                    class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-semibold border-b border-slate-800 pb-3 w-3/4 mx-auto">
                    {{ __('welcome.subtitle') }}
                </p>
            </div>

            <!-- Links Stack -->
            <div class="space-y-4 my-2">
                @forelse ($productKnowledges as $item)
                    <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer"
                        class="group flex items-center justify-between bg-[#242931]/60 hover:bg-[#C2A370] border border-slate-700/80 hover:border-[#C2A370] rounded-xl p-4 text-left transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg hover:shadow-[#C2A370]/10">
                        <div class="flex items-center space-x-3.5">
                            <!-- Property / Document Icon -->
                            <span
                                class="flex-shrink-0 w-10 h-10 bg-[#242931] group-hover:bg-[#242931] rounded-lg flex items-center justify-center border border-[#C2A370]/30 group-hover:border-[#C2A370] transition duration-300">
                                <svg class="w-5.5 h-5.5 text-[#C2A370]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </span>
                            <!-- Link Name -->
                            <span
                                class="text-sm font-semibold text-slate-200 group-hover:text-[#242931] transition duration-300">
                                {{ $item->name }}
                            </span>
                        </div>

                        <!-- Arrow indicator -->
                        <span
                            class="w-6 h-6 rounded-full flex items-center justify-center bg-[#242931] group-hover:bg-[#242931] text-[#C2A370] group-hover:translate-x-1.5 transition-all duration-350 border border-transparent group-hover:border-[#C2A370]/30">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                @empty
                    <div class="py-8 px-4 border border-dashed border-slate-800 rounded-xl">
                        <svg class="w-10 h-10 text-slate-600 mx-auto mb-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <p class="text-xs text-slate-500">
                            {{ __('welcome.no_links') }}
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-lg mx-auto text-center py-4 z-10 border-t border-slate-800/80 mt-auto">
        <!-- Social quick links -->
        <div class="flex justify-center space-x-6 mb-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/#" target="_blank" rel="noopener noreferrer"
                class="text-slate-500 hover:text-[#C2A370] transition duration-200">
                <svg role="img" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <title>WhatsApp</title>
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
            </a>
            <!-- Instagram -->
            <a href="https://instagram.com/#" target="_blank" rel="noopener noreferrer"
                class="text-slate-500 hover:text-[#C2A370] transition duration-200">
                <svg role="img" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <title>Instagram</title>
                    <path
                        d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077" />
                </svg>
            </a>
            <!-- Main Website / Home -->
            <a href="#" class="text-slate-500 hover:text-[#C2A370] transition duration-200">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                        d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
            </a>
        </div>

        <!-- Copyright -->
        <p class="text-xs text-slate-500">
            &copy; {{ date('Y') }} <strong>Trias Property</strong>. {{ __('welcome.footer') }}
        </p>
    </footer>

</body>

</html>
