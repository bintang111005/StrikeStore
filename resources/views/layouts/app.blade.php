<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StrikeStore') — Toko Perlengkapan Memancing Premium</title>
    <meta name="description" content="@yield('meta_description', 'StrikeStore menjual perlengkapan memancing premium terlengkap: joran, reel, umpan, senar pancing, dan aksesori memancing.')">

    {{-- Favicon SVG with StrikeStore Hook in Navy & Warm Brown --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'><rect width='40' height='40' rx='10' fill='%23194668'/><path d='M22 6V20C22 25.5 17.5 30 12 30C10.5 30 9.2 29.6 8 29C7.2 28.6 6.8 27.6 7.2 26.8C7.6 26 8.6 25.6 9.4 26C10.2 26.4 11.1 26.6 12 26.6C15.6 26.6 18.6 23.6 18.6 20V12L15 15.5L16.2 11.5L22 6Z' fill='%23FFFFFF'/><path d='M22 10L31 16L24 19L33 28L18 34L22 24L16 23L22 10Z' fill='%23C5804B'/></svg>">

    <!-- Google Fonts: Plus Jakarta Sans (Heading) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'navy-primary': '#194668',
                            'navy-dark': '#102D42',
                            'warm-brown': '#C5804B',
                            'soft-blue': '#DCE5EB',
                            'light-bg': '#F5F7F9',
                            'emerald-deep': '#194668',
                            'forest-dark': '#102D42',
                            'emerald-accent': '#C5804B',
                            'dark-bg': '#102D42',
                            'light-gray': '#F5F7F9'
                        },
                        fontFamily: {
                            heading: ['Plus Jakarta Sans', 'sans-serif'],
                            sans: ['Inter', 'sans-serif']
                        }
                    }
                }
            }
        </script>
    @endif

    @stack('styles')
</head>
<body class="font-sans bg-[#FFFFFF] text-[#202B35] antialiased flex flex-col min-h-screen selection:bg-[#194668] selection:text-white">

    {{-- CLEAN & MINIMAL STICKY NAVBAR --}}
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#E8EDF1] transition-all">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0 focus:outline-none rounded-xl p-1" aria-label="StrikeStore Home">
                    <x-logo size="default" variant="dark" />
                </a>

                {{-- Desktop Navigation Links (Inter Medium 500) --}}
                <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-full text-sm font-sans font-medium transition-all {{ request()->routeIs('home') ? 'text-[#194668] bg-[#F5F7F9] font-semibold' : 'text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]/70' }}">
                        Home
                    </a>
                    <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-full text-sm font-sans font-medium transition-all {{ request()->routeIs('catalog.index') && !request('category') ? 'text-[#194668] bg-[#F5F7F9] font-semibold' : 'text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]/70' }}">
                        Katalog
                    </a>

                    {{-- Category Dropdown --}}
                    <div class="relative group" id="categoryDropdownContainer">
                        <button type="button" class="px-4 py-2 rounded-full text-sm font-sans font-medium text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]/70 flex items-center gap-1.5 transition-all cursor-pointer">
                            <span>Kategori</span>
                            <svg class="w-4 h-4 text-[#7A8791] transition-transform duration-200 group-hover:rotate-180 group-hover:text-[#194668]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 top-full pt-2 w-72 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                            <div class="bg-white border border-[#E8EDF1] rounded-[18px] p-2.5 shadow-[0_20px_40px_-15px_rgba(16,45,66,0.14)]">
                                {{-- 1. Joran --}}
                                <a href="{{ route('catalog.category', 'joran') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-[#F5F7F9] border border-[#DCE5EB] flex items-center justify-center text-[#194668] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-heading font-semibold text-[#202B35]">Joran Pancing</div>
                                        <div class="text-[11px] text-[#7A8791]">Casting, Jigging & Galatama</div>
                                    </div>
                                </a>
                                {{-- 2. Reel --}}
                                <a href="{{ route('catalog.category', 'reel') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-[#F5F7F9] border border-[#DCE5EB] flex items-center justify-center text-[#194668] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-heading font-semibold text-[#202B35]">Reel Pancing</div>
                                        <div class="text-[11px] text-[#7A8791]">Spinning & Baitcasting</div>
                                    </div>
                                </a>
                                {{-- 3. Umpan --}}
                                <a href="{{ route('catalog.category', 'umpan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-[#F5F7F9] border border-[#DCE5EB] flex items-center justify-center text-[#194668] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-heading font-semibold text-[#202B35]">Umpan Pancing</div>
                                        <div class="text-[11px] text-[#7A8791]">Minnow, Metal Jig & Soft Lure</div>
                                    </div>
                                </a>
                                {{-- 4. Senar --}}
                                <a href="{{ route('catalog.category', 'senar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-[#F5F7F9] border border-[#DCE5EB] flex items-center justify-center text-[#194668] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-heading font-semibold text-[#202B35]">Senar Pancing</div>
                                        <div class="text-[11px] text-[#7A8791]">Braided PE & Fluorocarbon</div>
                                    </div>
                                </a>
                                {{-- 5. Kail & Aksesori --}}
                                <a href="{{ route('catalog.category', 'kail-aksesori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-[#F5F7F9] border border-[#DCE5EB] flex items-center justify-center text-[#194668] shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-heading font-semibold text-[#202B35]">Kail & Aksesori</div>
                                        <div class="text-[11px] text-[#7A8791]">Mustad Hooks, Swivel, Tackle Box</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('catalog.index', ['sort' => 'popular']) }}" class="px-4 py-2 rounded-full text-sm font-sans font-medium text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]/70 transition-all">
                        Produk Unggulan
                    </a>
                    <a href="{{ route('cart.page') }}" class="px-4 py-2 rounded-full text-sm font-sans font-medium transition-all {{ request()->routeIs('cart.page') || request()->routeIs('checkout.*') ? 'text-[#194668] bg-[#F5F7F9] font-semibold' : 'text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]/70' }}">
                        Keranjang & Checkout
                    </a>
                </nav>

                {{-- Search Bar (Desktop) --}}
                <div class="hidden md:flex flex-1 max-w-xs lg:max-w-sm mx-2">
                    <form action="{{ route('catalog.index') }}" method="GET" class="w-full relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari joran, reel, umpan..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#F5F7F9] border border-[#E8EDF1] rounded-full text-sm text-[#202B35] placeholder-[#7A8791] focus:outline-none focus:border-[#194668] focus:bg-white transition-all"
                        />
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#7A8791] hover:text-[#194668] transition-colors" aria-label="Cari">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Action Icons: Account, Mobile Search & Menu --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Quick Search Button for Mobile --}}
                    <button 
                        type="button" 
                        onclick="toggleMobileSearch()"
                        class="md:hidden p-2.5 rounded-xl bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] border border-[#E8EDF1]"
                        aria-label="Buka pencarian"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>

                    {{-- Account / Auth Dynamic Component --}}
                    @auth
                        <div class="relative group">
                            <button 
                                type="button" 
                                class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-[#F5F7F9] hover:bg-[#DCE5EB]/60 text-[#202B35] border border-[#E8EDF1] transition-all text-xs font-semibold cursor-pointer"
                            >
                                <span class="w-6 h-6 rounded-full bg-[#194668] text-white flex items-center justify-center font-bold text-[11px]">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:inline max-w-[110px] truncate text-[#202B35]">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-[#7A8791] transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 top-full pt-2 w-60 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                                <div class="bg-white border border-[#E8EDF1] rounded-[18px] p-2.5 shadow-[0_20px_40px_-15px_rgba(16,45,66,0.15)] text-xs space-y-1">
                                    <div class="px-3 py-2 border-b border-[#E8EDF1]">
                                        <p class="font-bold text-[#202B35] truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[11px] text-[#7A8791] truncate">{{ Auth::user()->email }}</p>
                                        <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ Auth::user()->role === 'admin' ? 'bg-[#C5804B]/15 text-[#C5804B]' : 'bg-[#F5F7F9] text-[#194668]' }}">
                                            {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Angler Member' }}
                                        </span>
                                    </div>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9] transition-colors">
                                            <svg class="w-4 h-4 text-[#C5804B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>Kelola Produk (CRUD)</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('orders.my') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9] transition-colors">
                                        <svg class="w-4 h-4 text-[#194668]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <span>Pesanan & Pembayaran Saya</span>
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="pt-1 border-t border-[#E8EDF1]">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            <span>Keluar (Logout)</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a 
                            href="{{ route('login') }}" 
                            class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#194668] hover:bg-[#102D42] text-white transition-all text-xs font-sans font-semibold cursor-pointer shadow-xs"
                            aria-label="Masuk ke Akun"
                        >
                            <span>Masuk</span>
                        </a>
                    @endauth

                    {{-- Mobile Menu Hamburger --}}
                    <button 
                        type="button" 
                        onclick="toggleMobileMenu()" 
                        class="lg:hidden p-2.5 rounded-xl bg-[#F5F7F9] text-[#202B35] hover:text-[#194668] border border-[#E8EDF1] focus:outline-none"
                        aria-label="Buka menu navigasi"
                    >
                        <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Search Dropdown Form (Toggleable) --}}
            <div id="mobileSearchPanel" class="hidden md:hidden pb-4 pt-1 border-t border-[#E8EDF1]">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari joran, reel, umpan, senar..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-[#F5F7F9] border border-[#E8EDF1] rounded-full text-sm text-[#202B35] placeholder-[#7A8791] focus:outline-none focus:border-[#194668] focus:bg-white"
                    />
                    <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#7A8791] hover:text-[#194668]" aria-label="Cari">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- MOBILE SLIDE-OVER MENU --}}
    <div id="mobileMenuBackdrop" class="fixed inset-0 bg-[#102D42]/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="toggleMobileMenu()"></div>
    <div id="mobileMenuPanel" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-white border-l border-[#E8EDF1] z-50 translate-x-full transition-transform duration-300 flex flex-col justify-between p-6 overflow-y-auto">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-[#E8EDF1]">
                <x-logo size="sm" variant="dark" />
                <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-[#7A8791] hover:text-[#202B35] hover:bg-[#F5F7F9]" aria-label="Tutup menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="mt-6 flex flex-col gap-1.5">
                <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl font-medium text-[#202B35] hover:bg-[#F5F7F9] hover:text-[#194668] transition-colors {{ request()->routeIs('home') ? 'bg-[#F5F7F9] text-[#194668] font-semibold' : '' }}">
                    Home
                </a>
                <a href="{{ route('catalog.index') }}" class="px-4 py-3 rounded-xl font-medium text-[#202B35] hover:bg-[#F5F7F9] hover:text-[#194668] transition-colors {{ request()->routeIs('catalog.index') && !request('category') ? 'bg-[#F5F7F9] text-[#194668] font-semibold' : '' }}">
                    Semua Katalog Produk
                </a>
                <a href="{{ route('cart.page') }}" class="px-4 py-3 rounded-xl font-medium text-[#202B35] hover:bg-[#F5F7F9] hover:text-[#194668] transition-colors {{ request()->routeIs('cart.page') ? 'bg-[#F5F7F9] text-[#194668] font-semibold' : '' }}">
                    Keranjang & Checkout
                </a>

                <div class="pt-4 pb-2 text-xs font-bold uppercase tracking-wider text-[#7A8791] px-4">
                    Kategori Perlengkapan
                </div>
                <div class="flex flex-col gap-1 pl-2">
                    <a href="{{ route('catalog.category', 'joran') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]">
                        <span>Joran Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'reel') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]">
                        <span>Reel Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'umpan') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]">
                        <span>Umpan Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'senar') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]">
                        <span>Senar Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'kail-aksesori') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-[#202B35] hover:text-[#194668] hover:bg-[#F5F7F9]">
                        <span>Kail & Aksesori</span>
                    </a>
                </div>

                @auth
                    <div class="mt-4 p-3.5 rounded-2xl bg-[#F5F7F9] border border-[#E8EDF1] text-xs">
                        <div class="flex items-center gap-2.5 mb-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#194668] text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <div class="overflow-hidden">
                                <p class="font-bold text-[#202B35] truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-[#7A8791] truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('products.index') }}" class="block w-full py-2 px-3 rounded-lg bg-[#C5804B]/15 text-[#C5804B] font-bold text-center mb-1.5">
                                Kelola Produk (Admin)
                            </a>
                        @endif
                        <a href="{{ route('orders.my') }}" class="block w-full py-2 px-3 rounded-lg bg-white border border-[#E8EDF1] text-[#194668] font-bold text-center mb-1.5">
                            Pesanan & Pembayaran Saya
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-3 rounded-lg bg-rose-50 text-rose-600 font-bold text-center hover:bg-rose-100 transition-colors">
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="mt-4 px-4 py-3 rounded-xl font-semibold text-center text-white bg-[#194668] hover:bg-[#102D42] shadow-xs flex items-center justify-center gap-2">
                        <span>Masuk / Daftar Akun</span>
                    </a>
                @endauth
            </nav>
        </div>

        <div class="pt-6 border-t border-[#E8EDF1] text-xs text-[#7A8791]">
            <p class="font-medium text-[#202B35]">Konsultasi Alat Pancing:</p>
            <p class="mt-1">WhatsApp Admin: <a href="https://wa.me/6285263785531" target="_blank" class="text-[#194668] font-bold underline">0852-6378-5531</a></p>
        </div>
    </div>

    {{-- 3. SLIDE-OVER INTERACTIVE CART DRAWER --}}
    <div id="cartDrawerBackdrop" class="fixed inset-0 bg-[#102D42]/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeCartDrawer()"></div>
    <div id="cartDrawerPanel" class="fixed top-0 right-0 bottom-0 w-full sm:w-[420px] bg-white z-50 translate-x-full transition-transform duration-300 flex flex-col justify-between shadow-2xl">
        {{-- Drawer Header --}}
        <div class="px-6 py-5 bg-[#194668] text-white flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-base">Keranjang Belanja</h3>
                    <p class="text-xs text-[#DCE5EB]" id="cartDrawerCountText">0 item terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeCartDrawer()" class="p-2 rounded-lg text-[#DCE5EB] hover:text-white hover:bg-white/10 cursor-pointer" aria-label="Tutup keranjang">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Free Shipping Dynamic Progress Tracker --}}
        <div class="bg-[#F5F7F9] px-6 py-3 border-b border-[#E8EDF1]" id="freeShippingBanner">
            <div class="flex items-center justify-between text-xs text-[#202B35] font-semibold mb-1.5">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#194668]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    <span id="shippingNoticeText">Beli min. Rp 500.000 untuk Gratis Ongkir!</span>
                </span>
            </div>
            <div class="w-full bg-[#DCE5EB] rounded-full h-2 overflow-hidden">
                <div id="shippingProgressBar" class="bg-[#194668] h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        {{-- Drawer Items List --}}
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar" id="cartItemsContainer">
            <div class="py-12 text-center text-[#7A8791]">
                <p class="text-[#202B35] font-medium">Keranjang Anda masih kosong</p>
                <p class="text-xs text-[#7A8791] mt-1">Jelajahi joran, reel, dan umpan terbaik kami.</p>
                <a href="{{ route('catalog.index') }}" onclick="closeCartDrawer()" class="inline-block mt-4 px-5 py-2.5 rounded-xl bg-[#194668] text-white text-xs font-semibold hover:bg-[#102D42] transition-colors">
                    Mulai Belanja
                </a>
            </div>
        </div>

        {{-- Drawer Footer Summary --}}
        <div class="p-6 bg-[#F5F7F9] border-t border-[#E8EDF1]">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold text-[#7A8791]">Total Subtotal</span>
                <span class="font-sans font-bold text-xl text-[#194668]" id="cartDrawerSubtotal">Rp 0</span>
            </div>
            <div class="flex flex-col gap-2.5">
                <a 
                    href="{{ route('checkout.index') }}"
                    id="cartCheckoutBtn"
                    class="w-full py-3.5 px-4 rounded-xl font-sans font-semibold text-sm bg-[#194668] hover:bg-[#102D42] text-white shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span>Checkout & Isi Data Pemesanan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a 
                    href="{{ route('cart.page') }}"
                    class="w-full py-2.5 px-4 rounded-xl font-sans font-semibold text-xs bg-white border border-[#E8EDF1] hover:border-[#194668] text-[#202B35] hover:text-[#194668] text-center transition-all"
                >
                    Lihat Halaman Keranjang & Pilih Produk
                </a>
            </div>
        </div>
    </div>

    {{-- 4. CHECKOUT MODAL SHEET --}}
    <div id="checkoutModalBackdrop" class="fixed inset-0 bg-[#102D42]/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeCheckoutModal()"></div>
    <div id="checkoutModalPanel" class="fixed inset-x-4 top-1/2 -translate-y-1/2 max-w-lg mx-auto bg-white rounded-[20px] shadow-2xl z-50 p-6 sm:p-8 opacity-0 pointer-events-none scale-95 transition-all duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar border border-[#E8EDF1]">
        <div class="flex items-center justify-between pb-4 border-b border-[#E8EDF1]">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-[#F5F7F9] text-[#194668] flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <div>
                    <h3 class="font-heading font-bold text-lg text-[#202B35]">Konfirmasi Pemesanan</h3>
                    <p class="text-xs text-[#7A8791]">StrikeStore Fast Order & Pengiriman</p>
                </div>
            </div>
            <button type="button" onclick="closeCheckoutModal()" class="p-2 rounded-xl text-[#7A8791] hover:text-[#202B35] hover:bg-[#F5F7F9] cursor-pointer" aria-label="Tutup form checkout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="checkoutForm" onsubmit="submitCheckoutOrder(event)" class="mt-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1.5">Nama Lengkap Angler</label>
                <input type="text" id="custName" required placeholder="Contoh: Bintang Angler" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]" />
            </div>

            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1.5">Nomor WhatsApp Aktif</label>
                <input type="tel" id="custPhone" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]" />
            </div>

            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1.5">Alamat Pengiriman Lengkap</label>
                <textarea id="custAddress" required rows="2" placeholder="Nama jalan, nomor rumah, kecamatan, kota & kode pos..." class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1.5">Ekspedisi Khusus Perlengkapan Pancing</label>
                <select id="custCourier" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668] cursor-pointer">
                    <option value="J&T Cargo Pipa PVC">J&T Cargo — Packing Pipa PVC Paralon Tebal</option>
                    <option value="SiCepat Best">SiCepat BEST / Cargo — Bubble Wrap Tebal & Asuransi Penuh</option>
                    <option value="JNE YES">JNE YES — Kirim Cepat 1 Hari Sampai</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1.5">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <label class="p-3 border border-[#194668] bg-[#F5F7F9] rounded-xl flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="Transfer Bank / VA" checked class="text-[#194668]" />
                        <span class="font-semibold text-[#202B35]">Transfer / VA</span>
                    </label>
                    <label class="p-3 border border-[#E8EDF1] bg-white rounded-xl flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="QRIS Instant" class="text-[#194668]" />
                        <span class="font-semibold text-[#202B35]">QRIS Instant</span>
                    </label>
                </div>
            </div>

            <div class="p-4 bg-[#F5F7F9] rounded-2xl border border-[#E8EDF1] text-xs text-[#7A8791]">
                <div class="flex justify-between font-bold text-[#202B35] text-sm mb-1">
                    <span>Total yang Harus Dibayar:</span>
                    <span id="checkoutModalTotal" class="text-[#194668] font-bold">Rp 0</span>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-sans font-semibold text-sm bg-[#194668] hover:bg-[#102D42] text-white transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Konfirmasi Pesanan via WhatsApp CS</span>
            </button>
        </form>
    </div>

    {{-- 5. ANGLER CLUB / ACCOUNT MODAL --}}
    <div id="accountModalBackdrop" class="fixed inset-0 bg-[#102D42]/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeAccountModal()"></div>
    <div id="accountModalPanel" class="fixed inset-x-4 top-1/2 -translate-y-1/2 max-w-md mx-auto bg-white rounded-[20px] shadow-2xl z-50 p-6 sm:p-8 opacity-0 pointer-events-none scale-95 transition-all duration-300 border border-[#E8EDF1]">
        <div class="flex items-center justify-between pb-4 border-b border-[#E8EDF1]">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-[#194668] text-white flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                <div>
                    <h3 class="font-heading font-bold text-base text-[#202B35]">StrikeStore Angler Club</h3>
                    <p class="text-xs text-[#7A8791]">Akses Eksklusif & Pelacakan Pesanan</p>
                </div>
            </div>
            <button type="button" onclick="closeAccountModal()" class="p-2 rounded-xl text-[#7A8791] hover:text-[#202B35] hover:bg-[#F5F7F9] cursor-pointer" aria-label="Tutup modal akun">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="flex border-b border-[#E8EDF1] mt-4">
            <button type="button" id="tabBtnLogin" onclick="switchAccountTab('login')" class="flex-1 pb-2.5 text-xs font-bold border-b-2 border-[#194668] text-[#194668]">
                Masuk / Angler Member
            </button>
            <button type="button" id="tabBtnTrack" onclick="switchAccountTab('track')" class="flex-1 pb-2.5 text-xs font-semibold text-[#7A8791] border-b-2 border-transparent hover:text-[#202B35]">
                Lacak Resi Pesanan
            </button>
        </div>

        {{-- Login Tab Content --}}
        <div id="tabContentLogin" class="mt-5 space-y-4">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" required placeholder="bintang@strikestore.id" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]" />
                </div>
                <button type="submit" class="w-full py-3 rounded-xl font-sans font-semibold text-xs bg-[#194668] hover:bg-[#102D42] text-white transition-all cursor-pointer">
                    Masuk ke Akun
                </button>
            </form>
        </div>

        {{-- Track Tab Content --}}
        <div id="tabContentTrack" class="mt-5 space-y-4 hidden">
            <div>
                <label class="block text-xs font-bold text-[#202B35] uppercase tracking-wider mb-1">ID Pesanan atau Nomor Resi</label>
                <input type="text" id="trackOrderId" placeholder="Contoh: INV-20261110-ABCD" class="w-full px-4 py-2.5 rounded-xl border border-[#E8EDF1] text-sm focus:outline-none focus:border-[#194668]" />
            </div>
            <button type="button" onclick="simulateTrackOrder()" class="w-full py-3 rounded-xl font-sans font-semibold text-xs bg-[#194668] hover:bg-[#102D42] text-white transition-all cursor-pointer">
                Cek Status Pengiriman
            </button>
            <div id="trackResultBox" class="hidden p-3.5 bg-[#F5F7F9] rounded-xl border border-[#E8EDF1] text-xs text-[#202B35] space-y-1">
                <div class="font-bold text-[#194668]">Paket Sedang Dalam Pengiriman</div>
                <p class="text-[#7A8791] text-[11px]">Kurir: J&T Cargo (Pipa PVC Paralon)</p>
            </div>
        </div>
    </div>

    {{-- MAIN PAGE CONTENT --}}
    <main class="flex-1">
        @if (session('success'))
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="p-4 rounded-2xl bg-[#F5F7F9] border border-[#DCE5EB] text-[#194668] text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-[#194668] text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    {{-- 6. CLEAN MINIMALIST FOOTER --}}
    <footer class="bg-[#F5F7F9] text-[#7A8791] pt-16 pb-10 border-t border-[#E8EDF1] mt-20">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-12 border-b border-[#E8EDF1]">
                
                {{-- Column 1: Brand Info --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="inline-block mb-4" aria-label="StrikeStore Home">
                        <x-logo size="default" variant="dark" />
                    </a>
                    <p class="text-sm text-[#7A8791] leading-relaxed max-w-sm mt-2">
                        <strong class="text-[#202B35]">StrikeStore</strong> adalah destinasi e-commerce perlengkapan memancing premium. Menyediakan joran, reel, umpan, senar, dan aksesori pancing berkualitas dengan pengiriman aman ke seluruh Indonesia.
                    </p>
                </div>

                {{-- Column 2: Kategori Belanja --}}
                <div>
                    <h4 class="font-heading font-bold text-[#202B35] text-sm mb-4">
                        Kategori Produk
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalog.category', 'joran') }}" class="hover:text-[#194668] transition-colors">Joran Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'reel') }}" class="hover:text-[#194668] transition-colors">Reel Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'umpan') }}" class="hover:text-[#194668] transition-colors">Umpan Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'senar') }}" class="hover:text-[#194668] transition-colors">Senar Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'kail-aksesori') }}" class="hover:text-[#194668] transition-colors">Kail & Aksesori</a></li>
                    </ul>
                </div>

                {{-- Column 3: Navigasi Cepat --}}
                <div>
                    <h4 class="font-heading font-bold text-[#202B35] text-sm mb-4">
                        Layanan Pelanggan
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-[#194668] transition-colors">Katalog Lengkap</a></li>
                        <li><a href="{{ route('cart.page') }}" class="hover:text-[#194668] transition-colors">Keranjang Belanja</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-[#194668] transition-colors">Checkout Pesanan</a></li>
                        @auth
                            <li><a href="{{ route('orders.my') }}" class="hover:text-[#194668] transition-colors">Riwayat Pembayaran</a></li>
                        @endauth
                        <li><a href="{{ route('products.index') }}" class="hover:text-[#194668] transition-colors text-xs">Manajemen Produk</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak & Store --}}
                <div>
                    <h4 class="font-heading font-bold text-[#202B35] text-sm mb-4">
                        Kontak Kami
                    </h4>
                    <ul class="space-y-3 text-xs leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#194668] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Dermaga Marina, Jakarta Utara</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#C5804B] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>WhatsApp Admin: <a href="https://wa.me/6285263785531" target="_blank" class="text-[#194668] font-bold hover:underline">0852-6378-5531</a></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#194668] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>support@strikestore.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Legal & Payments --}}
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#7A8791]">
                <p>© {{ date('Y') }} StrikeStore. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-2 flex-wrap justify-center">
                    <span class="px-2.5 py-1 rounded-md bg-white border border-[#E8EDF1] text-[10px] font-bold text-[#202B35]">BCA</span>
                    <span class="px-2.5 py-1 rounded-md bg-white border border-[#E8EDF1] text-[10px] font-bold text-[#202B35]">Mandiri</span>
                    <span class="px-2.5 py-1 rounded-md bg-white border border-[#E8EDF1] text-[10px] font-bold text-[#202B35]">BRI</span>
                    <span class="px-2.5 py-1 rounded-md bg-[#194668] text-[10px] font-bold text-white">QRIS</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- TOAST NOTIFICATION CONTAINER --}}
    <div id="toastNotification" class="fixed top-24 right-5 z-50 flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-[#102D42] text-white border border-[#194668] shadow-xl translate-x-[150%] transition-transform duration-300 max-w-sm pointer-events-none">
        <div class="w-8 h-8 rounded-xl bg-[#194668] flex items-center justify-center shrink-0 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="flex-1 text-xs">
            <div class="font-bold text-white text-sm" id="toastTitle">Berhasil Ditambahkan</div>
            <div class="text-[#DCE5EB]" id="toastMessage">Produk telah masuk ke keranjang belanja Anda.</div>
        </div>
    </div>

    {{-- GLOBAL CART, MODALS & UI SCRIPTS --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentCartData = { items: [], count: 0, subtotal: 0 };

        function toggleMobileMenu() {
            const panel = document.getElementById('mobileMenuPanel');
            const backdrop = document.getElementById('mobileMenuBackdrop');
            const isOpen = !panel.classList.contains('translate-x-full');

            if (isOpen) {
                panel.classList.add('translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            } else {
                panel.classList.remove('translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            }
        }

        function toggleMobileSearch() {
            const searchPanel = document.getElementById('mobileSearchPanel');
            searchPanel.classList.toggle('hidden');
        }

        function openCartDrawer() {
            const panel = document.getElementById('cartDrawerPanel');
            const backdrop = document.getElementById('cartDrawerBackdrop');
            panel.classList.remove('translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            fetchCart();
        }

        function closeCartDrawer() {
            const panel = document.getElementById('cartDrawerPanel');
            const backdrop = document.getElementById('cartDrawerBackdrop');
            panel.classList.add('translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }

        function openAccountModal() {
            const panel = document.getElementById('accountModalPanel');
            const backdrop = document.getElementById('accountModalBackdrop');
            panel.classList.remove('opacity-0', 'pointer-events-none', 'scale-95');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
        }

        function closeAccountModal() {
            const panel = document.getElementById('accountModalPanel');
            const backdrop = document.getElementById('accountModalBackdrop');
            panel.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }

        function switchAccountTab(tab) {
            const btnLogin = document.getElementById('tabBtnLogin');
            const btnTrack = document.getElementById('tabBtnTrack');
            const contentLogin = document.getElementById('tabContentLogin');
            const contentTrack = document.getElementById('tabContentTrack');

            if (tab === 'login') {
                btnLogin.classList.add('border-[#194668]', 'text-[#194668]');
                btnLogin.classList.remove('border-transparent', 'text-[#7A8791]');
                btnTrack.classList.remove('border-[#194668]', 'text-[#194668]');
                btnTrack.classList.add('border-transparent', 'text-[#7A8791]');
                contentLogin.classList.remove('hidden');
                contentTrack.classList.add('hidden');
            } else {
                btnTrack.classList.add('border-[#194668]', 'text-[#194668]');
                btnTrack.classList.remove('border-transparent', 'text-[#7A8791]');
                btnLogin.classList.remove('border-[#194668]', 'text-[#194668]');
                btnLogin.classList.add('border-transparent', 'text-[#7A8791]');
                contentTrack.classList.remove('hidden');
                contentLogin.classList.add('hidden');
            }
        }

        function simulateLogin() {
            showToast('Selamat Datang Angler!', 'Anda berhasil masuk ke StrikeStore Angler Club.');
            setTimeout(closeAccountModal, 800);
        }

        function simulateTrackOrder() {
            const id = document.getElementById('trackOrderId').value;
            if (!id) {
                alert('Silakan masukkan nomor pesanan atau no. WhatsApp Anda.');
                return;
            }
            document.getElementById('trackResultBox').classList.remove('hidden');
        }

        function openCheckoutModal() {
            if (!currentCartData.items || currentCartData.items.length === 0) {
                showToast('Keranjang Kosong', 'Silakan pilih produk terlebih dahulu sebelum checkout.');
                return;
            }
            closeCartDrawer();
            const panel = document.getElementById('checkoutModalPanel');
            const backdrop = document.getElementById('checkoutModalBackdrop');
            document.getElementById('checkoutModalTotal').textContent = currentCartData.formatted || 'Rp 0';
            panel.classList.remove('opacity-0', 'pointer-events-none', 'scale-95');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
        }

        function closeCheckoutModal() {
            const panel = document.getElementById('checkoutModalPanel');
            const backdrop = document.getElementById('checkoutModalBackdrop');
            panel.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }

        function submitCheckoutOrder(e) {
            e.preventDefault();
            const name = document.getElementById('custName').value;
            const phone = document.getElementById('custPhone').value;
            const address = document.getElementById('custAddress').value;
            const courier = document.getElementById('custCourier').value;
            const payment = document.querySelector('input[name="paymentMethod"]:checked').value;

            let itemsListText = '';
            currentCartData.items.forEach((item, idx) => {
                itemsListText += `%0A${idx+1}. ${encodeURIComponent(item.name)} (x${item.quantity}) - Rp ${(item.price * item.quantity).toLocaleString('id-ID')}`;
                if (item.variant) itemsListText += ` [Varian: ${encodeURIComponent(item.variant)}]`;
            });

            const waMessage = `Halo StrikeStore, saya ingin konfirmasi pesanan perlengkapan memancing:%0A%0A*Nama:* ${encodeURIComponent(name)}%0A*No HP:* ${encodeURIComponent(phone)}%0A*Alamat:* ${encodeURIComponent(address)}%0A*Ekspedisi:* ${encodeURIComponent(courier)}%0A*Pembayaran:* ${encodeURIComponent(payment)}%0A%0A*Daftar Produk:*${itemsListText}%0A%0A*Total Pembayaran:* ${encodeURIComponent(currentCartData.formatted)}%0A%0AMohon nomor invoice & panduan transfernya. Terima kasih!`;

            showToast('Pesanan Diproses!', 'Membuka WhatsApp CS StrikeStore untuk konfirmasi...');
            closeCheckoutModal();

            setTimeout(() => {
                window.open(`https://wa.me/6285263785531?text=${waMessage}`, '_blank');
            }, 600);
        }

        let toastTimeout;
        function showToast(title, message) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            clearTimeout(toastTimeout);
            toast.classList.remove('translate-x-[150%]');

            toastTimeout = setTimeout(() => {
                toast.classList.add('translate-x-[150%]');
            }, 3500);
        }

        function addToCart(productId, qty = 1, btn = null, variant = null) {
            let originalContent = '';
            if (btn) {
                originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<svg class="w-4 h-4 animate-spin mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: qty, variant: variant })
            })
            .then(res => res.json())
            .then(data => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                }

                if (data.success) {
                    const badge = document.getElementById('cartCountBadge');
                    if (badge) {
                        badge.textContent = data.count;
                        badge.classList.add('scale-125');
                        setTimeout(() => badge.classList.remove('scale-125'), 200);
                    }
                    showToast('Berhasil Ditambahkan!', data.message);
                } else {
                    showToast('Pemberitahuan', data.message || 'Gagal menambahkan produk.');
                }
            })
            .catch(err => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                }
                showToast('Error', 'Terjadi kesalahan jaringan.');
            });
        }

        function fetchCart() {
            fetch('{{ route("cart.index") }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                currentCartData = data;
                renderCartDrawer(data);
            });
        }

        function renderCartDrawer(data) {
            const container = document.getElementById('cartItemsContainer');
            const countText = document.getElementById('cartDrawerCountText');
            const subtotalEl = document.getElementById('cartDrawerSubtotal');
            const badge = document.getElementById('cartCountBadge');
            const shippingBar = document.getElementById('shippingProgressBar');
            const shippingNotice = document.getElementById('shippingNoticeText');

            if (badge) badge.textContent = data.count;
            if (countText) countText.textContent = `${data.count} item terpilih`;
            if (subtotalEl) subtotalEl.textContent = data.formatted;

            const freeThreshold = 500000;
            const progress = Math.min(100, (data.subtotal / freeThreshold) * 100);
            if (shippingBar) shippingBar.style.width = `${progress}%`;
            if (shippingNotice) {
                if (data.subtotal >= freeThreshold) {
                    shippingNotice.innerHTML = `<span class="text-[#194668] font-bold">Selamat! Gratis Ongkir Aktif</span>`;
                } else {
                    const diff = freeThreshold - data.subtotal;
                    shippingNotice.innerHTML = `Tambah <strong class="text-[#194668]">Rp ${diff.toLocaleString('id-ID')}</strong> lagi untuk Gratis Ongkir!`;
                }
            }

            if (!data.items || data.items.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-[#7A8791]">
                        <p class="text-[#202B35] font-medium">Keranjang Anda masih kosong</p>
                        <p class="text-xs text-[#7A8791] mt-1">Jelajahi joran, reel, dan umpan terbaik kami.</p>
                        <a href="{{ route('catalog.index') }}" onclick="closeCartDrawer()" class="inline-block mt-4 px-5 py-2.5 rounded-xl bg-[#194668] text-white text-xs font-semibold hover:bg-[#102D42] transition-colors">
                            Mulai Belanja
                        </a>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-4">';
            data.items.forEach(item => {
                const itemTotal = (item.price * item.quantity).toLocaleString('id-ID');
                const variantBadge = item.variant ? `<div class="inline-block text-[10px] font-semibold text-[#194668] bg-[#F5F7F9] border border-[#DCE5EB] px-2 py-0.5 rounded-md mt-1">Varian: ${item.variant}</div>` : '';
                const imgHtml = item.image
                    ? `<img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-xl bg-white shrink-0 border border-[#E8EDF1]" />`
                    : `<div class="w-16 h-16 rounded-xl bg-[#F5F7F9] shrink-0 border border-dashed border-[#E8EDF1] flex items-center justify-center text-[#7A8791] text-[10px]">Tanpa Foto</div>`;

                html += `
                    <div class="flex gap-3.5 p-3 rounded-2xl bg-[#F5F7F9] border border-[#E8EDF1] items-center justify-between">
                        ${imgHtml}
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-[#202B35] truncate">${item.name}</h4>
                            <p class="text-[11px] text-[#7A8791] font-mono mt-0.5">SKU: ${item.sku || '-'}</p>
                            ${variantBadge}
                            <p class="text-xs font-bold text-[#194668] mt-1">Rp ${itemTotal}</p>
                            
                            <div class="flex items-center gap-2 mt-2">
                                <div class="inline-flex items-center border border-[#E8EDF1] rounded-lg bg-white overflow-hidden text-xs">
                                    <button onclick="updateItemQuantity(${item.id}, ${item.quantity - 1})" class="px-2 py-0.5 hover:bg-[#F5F7F9] font-bold text-[#202B35] cursor-pointer">-</button>
                                    <span class="px-2.5 py-0.5 font-bold text-[#202B35]">${item.quantity}</span>
                                    <button onclick="updateItemQuantity(${item.id}, ${item.quantity + 1})" class="px-2 py-0.5 hover:bg-[#F5F7F9] font-bold text-[#202B35] cursor-pointer">+</button>
                                </div>
                                <button onclick="removeCartItem(${item.id})" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-semibold ml-2 cursor-pointer">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function updateItemQuantity(productId, newQty) {
            if (newQty <= 0) {
                removeCartItem(productId);
                return;
            }

            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    fetchCart();
                } else {
                    showToast('Peringatan', data.message || 'Gagal mengubah jumlah.');
                }
            });
        }

        function removeCartItem(productId) {
            fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                showToast('Dihapus', data.message);
                fetchCart();
            });
        }

        function proceedToCheckout() {
            window.location.href = '{{ route("checkout.index") }}';
        }
    </script>

    @stack('scripts')
</body>
</html>
