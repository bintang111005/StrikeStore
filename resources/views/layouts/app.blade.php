<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StrikeStore') — Toko Perlengkapan Memancing Premium</title>
    <meta name="description" content="@yield('meta_description', 'StrikeStore menjual perlengkapan memancing premium terlengkap: joran, reel, umpan, senar pancing, dan aksesori memancing.')">

    {{-- Favicon SVG with StrikeStore Hook --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'><rect width='40' height='40' rx='10' fill='%23022C22'/><path d='M22 6V20C22 25.5 17.5 30 12 30C10.5 30 9.2 29.6 8 29C7.2 28.6 6.8 27.6 7.2 26.8C7.6 26 8.6 25.6 9.4 26C10.2 26.4 11.1 26.6 12 26.6C15.6 26.6 18.6 23.6 18.6 20V12L15 15.5L16.2 11.5L22 6Z' fill='%23E5E7EB'/><path d='M22 10L31 16L24 19L33 28L18 34L22 24L16 23L22 10Z' fill='%2310B981'/></svg>">

    <!-- Google Fonts: Sora (Heading) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'emerald-deep': '#064E3B',
                            'forest-dark': '#022C22',
                            'emerald-accent': '#10B981',
                            'dark-bg': '#071C17',
                            'metallic-silver': '#C0C0C0',
                            'chrome-silver': '#E5E7EB',
                            'light-gray': '#F8FAFC'
                        },
                        fontFamily: {
                            heading: ['Sora', 'sans-serif'],
                            sans: ['Inter', 'sans-serif']
                        }
                    }
                }
            }
        </script>
    @endif

    @stack('styles')
</head>
<body class="font-sans bg-[#F8FAFC] text-slate-800 antialiased flex flex-col min-h-screen selection:bg-emerald-500 selection:text-white">

    {{-- 1. ANNOUNCEMENT BAR --}}
    <div class="bg-gradient-to-r from-[#022C22] via-[#064E3B] to-[#022C22] text-emerald-100 text-xs py-2 px-4 border-b border-emerald-900/40 select-none">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                <span class="font-medium tracking-wide">
                    <strong>GEAR UP FOR YOUR NEXT BIG CATCH</strong> — Gratis Ongkir ke Seluruh Indonesia min. belanja Rp 500.000!
                </span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-emerald-200 text-xs shrink-0">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    100% Produk Original & Bergaransi
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Kemasan Pipa PVC Khusus Joran
                </span>
            </div>
        </div>
    </div>

    {{-- 2. STICKY NAVBAR --}}
    <header class="sticky top-0 z-40 bg-[#022C22]/95 backdrop-blur-md border-b border-emerald-900/60 shadow-lg shadow-emerald-950/20 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0 focus:outline-none focus:ring-2 focus:ring-emerald-400 rounded-xl p-1" aria-label="StrikeStore Home">
                    <x-logo size="default" />
                </a>

                {{-- Desktop Navigation Links --}}
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'text-emerald-400 bg-emerald-900/40 border border-emerald-500/30' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                        Home
                    </a>
                    <a href="{{ route('catalog.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('catalog.index') && !request('category') ? 'text-emerald-400 bg-emerald-900/40 border border-emerald-500/30' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                        Katalog
                    </a>

                    {{-- Category Dropdown with Clean SVGs --}}
                    <div class="relative group" id="categoryDropdownContainer">
                        <button type="button" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-200 hover:text-white hover:bg-white/5 flex items-center gap-1.5 transition-all">
                            <span>Kategori</span>
                            <svg class="w-4 h-4 text-emerald-400 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 top-full pt-2 w-72 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                            <div class="bg-[#071C17] border border-emerald-700/50 rounded-2xl p-2.5 shadow-2xl shadow-emerald-950/80 backdrop-blur-xl">
                                {{-- 1. Joran --}}
                                <a href="{{ route('catalog.category', 'joran') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-900/40 text-slate-200 hover:text-emerald-300 transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-emerald-950 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-white">Joran Pancing</div>
                                        <div class="text-[11px] text-slate-400">Casting, Jigging & Galatama</div>
                                    </div>
                                </a>
                                {{-- 2. Reel --}}
                                <a href="{{ route('catalog.category', 'reel') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-900/40 text-slate-200 hover:text-emerald-300 transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-emerald-950 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-white">Reel Pancing</div>
                                        <div class="text-[11px] text-slate-400">Spinning & Baitcasting</div>
                                    </div>
                                </a>
                                {{-- 3. Umpan --}}
                                <a href="{{ route('catalog.category', 'umpan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-900/40 text-slate-200 hover:text-emerald-300 transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-emerald-950 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-white">Umpan Pancing</div>
                                        <div class="text-[11px] text-slate-400">Minnow, Metal Jig & Soft Lure</div>
                                    </div>
                                </a>
                                {{-- 4. Senar --}}
                                <a href="{{ route('catalog.category', 'senar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-900/40 text-slate-200 hover:text-emerald-300 transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-emerald-950 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-white">Senar Pancing</div>
                                        <div class="text-[11px] text-slate-400">Braided PE, Fluorocarbon Leader</div>
                                    </div>
                                </a>
                                {{-- 5. Kail & Aksesori --}}
                                <a href="{{ route('catalog.category', 'kail-aksesori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-900/40 text-slate-200 hover:text-emerald-300 transition-colors">
                                    <span class="w-9 h-9 rounded-xl bg-emerald-950 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-white">Kail & Aksesori</div>
                                        <div class="text-[11px] text-slate-400">Mustad Hooks, Swivel, Tackle Box</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('catalog.index', ['sort' => 'popular']) }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-200 hover:text-white hover:bg-white/5 transition-all">
                        Produk Unggulan
                    </a>
                </nav>

                {{-- Search Bar (Desktop) --}}
                <div class="hidden md:flex flex-1 max-w-xs lg:max-w-sm mx-2">
                    <form action="{{ route('catalog.index') }}" method="GET" class="w-full relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari joran, reel, umpan, senar..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#071C17] border border-emerald-800/80 rounded-xl text-sm text-slate-100 placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 transition-all shadow-inner"
                        />
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-400 transition-colors" aria-label="Cari">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Action Icons: Account, Cart, Mobile Search & Menu --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Quick Search Button for Mobile --}}
                    <button 
                        type="button" 
                        onclick="toggleMobileSearch()"
                        class="md:hidden p-2.5 rounded-xl bg-emerald-950/80 text-slate-200 hover:text-white border border-emerald-800/60"
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
                                class="flex items-center gap-2 px-3 py-2 rounded-xl bg-[#071C17] hover:bg-emerald-950/90 text-white border border-emerald-700/80 transition-all text-xs font-semibold cursor-pointer shadow-sm"
                            >
                                <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-[11px] shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:inline max-w-[110px] truncate text-slate-200">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-emerald-400 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 top-full pt-2 w-60 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                                <div class="bg-[#071C17] border border-emerald-700/70 rounded-2xl p-2.5 shadow-2xl backdrop-blur-xl text-xs space-y-1">
                                    <div class="px-3 py-2 border-b border-emerald-900/60">
                                        <p class="font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[11px] text-emerald-400 truncate">{{ Auth::user()->email }}</p>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ Auth::user()->role === 'admin' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                                            {{ Auth::user()->role === 'admin' ? '🛡️ Administrator' : '🎣 Angler Member' }}
                                        </span>
                                    </div>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200 hover:text-white hover:bg-emerald-900/50 transition-colors">
                                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>Kelola Produk (CRUD)</span>
                                        </a>
                                    @endif
                                    <button type="button" onclick="openAccountModal()" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200 hover:text-white hover:bg-emerald-900/50 transition-colors cursor-pointer">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <span>Lacak Resi Pesanan</span>
                                    </button>
                                    <form action="{{ route('logout') }}" method="POST" class="pt-1 border-t border-emerald-900/60">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-red-300 hover:text-white hover:bg-red-950/60 transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            <span>Keluar (Logout)</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a 
                            href="{{ route('login') }}" 
                            class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-[#071C17] hover:bg-emerald-950/80 text-emerald-300 hover:text-white border border-emerald-800/80 hover:border-emerald-500/60 transition-all text-xs font-semibold cursor-pointer shadow-sm"
                            aria-label="Masuk ke Akun"
                        >
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Masuk</span>
                        </a>
                    @endauth

                    {{-- Cart Button with Dynamic Badge --}}
                    <button 
                        type="button" 
                        onclick="openCartDrawer()"
                        class="relative flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white border border-emerald-400/30 shadow-md shadow-emerald-950/40 transition-all active:scale-95 group cursor-pointer"
                        aria-label="Lihat Keranjang Belanja"
                    >
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline font-semibold text-xs tracking-wide">Keranjang</span>
                        <span 
                            id="cartCountBadge" 
                            class="px-2 py-0.5 rounded-full text-xs font-extrabold bg-amber-400 text-slate-950 shadow-sm"
                        >
                            {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                        </span>
                    </button>

                    {{-- Mobile Menu Hamburger --}}
                    <button 
                        type="button" 
                        onclick="toggleMobileMenu()" 
                        class="lg:hidden p-2.5 rounded-xl bg-[#071C17] text-slate-200 hover:text-white border border-emerald-800/80 focus:outline-none"
                        aria-label="Buka menu navigasi"
                    >
                        <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Search Dropdown Form (Toggleable) --}}
            <div id="mobileSearchPanel" class="hidden md:hidden pb-4 pt-1 border-t border-emerald-900/40">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari joran, reel, umpan, senar..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-[#071C17] border border-emerald-700 rounded-xl text-sm text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                    />
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-400" aria-label="Cari">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- MOBILE SLIDE-OVER MENU --}}
    <div id="mobileMenuBackdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="toggleMobileMenu()"></div>
    <div id="mobileMenuPanel" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-[#071C17] border-l border-emerald-800/60 z-50 translate-x-full transition-transform duration-300 flex flex-col justify-between p-6 overflow-y-auto">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-emerald-900/60">
                <x-logo size="sm" />
                <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5" aria-label="Tutup menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="mt-6 flex flex-col gap-2">
                <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl font-semibold text-slate-200 hover:bg-emerald-900/30 hover:text-emerald-400 transition-colors {{ request()->routeIs('home') ? 'bg-emerald-900/40 text-emerald-300 border border-emerald-500/30' : '' }}">
                    Home
                </a>
                <a href="{{ route('catalog.index') }}" class="px-4 py-3 rounded-xl font-semibold text-slate-200 hover:bg-emerald-900/30 hover:text-emerald-400 transition-colors {{ request()->routeIs('catalog.index') && !request('category') ? 'bg-emerald-900/40 text-emerald-300 border border-emerald-500/30' : '' }}">
                    Semua Katalog Produk
                </a>

                <div class="pt-4 pb-2 text-xs font-bold uppercase tracking-wider text-emerald-400/70 px-4">
                    Kategori Perlengkapan
                </div>
                <div class="flex flex-col gap-1 pl-2">
                    <a href="{{ route('catalog.category', 'joran') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-emerald-900/30">
                        <span class="w-6 h-6 rounded-md bg-emerald-950 flex items-center justify-center text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </span>
                        <span>Joran Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'reel') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-emerald-900/30">
                        <span class="w-6 h-6 rounded-md bg-emerald-950 flex items-center justify-center text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        </span>
                        <span>Reel Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'umpan') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-emerald-900/30">
                        <span class="w-6 h-6 rounded-md bg-emerald-950 flex items-center justify-center text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <span>Umpan Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'senar') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-emerald-900/30">
                        <span class="w-6 h-6 rounded-md bg-emerald-950 flex items-center justify-center text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </span>
                        <span>Senar Pancing</span>
                    </a>
                    <a href="{{ route('catalog.category', 'kail-aksesori') }}" class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-emerald-900/30">
                        <span class="w-6 h-6 rounded-md bg-emerald-950 flex items-center justify-center text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </span>
                        <span>Kail & Aksesori</span>
                    </a>
                </div>

                <a href="{{ route('catalog.index', ['sort' => 'popular']) }}" class="mt-4 px-4 py-3 rounded-xl font-semibold text-slate-200 hover:bg-emerald-900/30 hover:text-emerald-400 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span>Produk Terpopuler</span>
                </a>

                @auth
                    <div class="mt-3 p-3 rounded-xl bg-emerald-950/70 border border-emerald-700/60 text-xs">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <div class="overflow-hidden">
                                <p class="font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-emerald-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('products.index') }}" class="block w-full py-2 px-3 rounded-lg bg-amber-500/20 text-amber-300 font-bold text-center mb-1.5 hover:bg-amber-500/30">
                                🛡️ Kelola Produk (Admin)
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-3 rounded-lg bg-red-950/60 border border-red-800/60 text-red-300 font-bold text-center hover:bg-red-900/60 transition-colors">
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="mt-3 px-4 py-3 rounded-xl font-bold text-center text-white bg-gradient-to-r from-emerald-700 to-emerald-600 hover:from-emerald-600 hover:to-emerald-500 shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Masuk / Daftar Akun</span>
                    </a>
                @endauth
            </nav>
        </div>

        <div class="pt-6 border-t border-emerald-900/60 text-xs text-slate-400">
            <p class="font-medium text-slate-300">Konsultasi Alat Pancing:</p>
            <p class="mt-1">WhatsApp CS: <a href="https://wa.me/6281234567890" target="_blank" class="text-emerald-400 font-bold underline">+62 812-3456-7890</a></p>
        </div>
    </div>

    {{-- 3. SLIDE-OVER INTERACTIVE CART DRAWER --}}
    <div id="cartDrawerBackdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeCartDrawer()"></div>
    <div id="cartDrawerPanel" class="fixed top-0 right-0 bottom-0 w-full sm:w-[420px] bg-white z-50 translate-x-full transition-transform duration-300 flex flex-col justify-between shadow-2xl">
        {{-- Drawer Header --}}
        <div class="px-6 py-5 bg-[#022C22] text-white flex items-center justify-between border-b border-emerald-900/40">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-900/60 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-base">Keranjang Belanja</h3>
                    <p class="text-xs text-emerald-300/80" id="cartDrawerCountText">0 item terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeCartDrawer()" class="p-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 cursor-pointer" aria-label="Tutup keranjang">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Free Shipping Dynamic Progress Tracker --}}
        <div class="bg-emerald-50 px-6 py-3 border-b border-emerald-100" id="freeShippingBanner">
            <div class="flex items-center justify-between text-xs text-emerald-900 font-semibold mb-1.5">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    <span id="shippingNoticeText">Beli min. Rp 500.000 untuk Gratis Ongkir!</span>
                </span>
            </div>
            <div class="w-full bg-emerald-200/60 rounded-full h-2 overflow-hidden">
                <div id="shippingProgressBar" class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        {{-- Drawer Items List --}}
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar" id="cartItemsContainer">
            {{-- Dynamically populated --}}
            <div class="py-12 text-center text-slate-400">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-slate-600 font-medium">Keranjang Anda masih kosong</p>
                <p class="text-xs text-slate-400 mt-1">Jelajahi joran, reel, dan umpan terbaik kami.</p>
                <a href="{{ route('catalog.index') }}" onclick="closeCartDrawer()" class="inline-block mt-4 px-5 py-2.5 rounded-xl bg-[#064E3B] text-white text-xs font-bold hover:bg-emerald-600 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        </div>

        {{-- Drawer Footer Summary --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold text-slate-600">Total Subtotal</span>
                <span class="font-heading font-extrabold text-xl text-emerald-900" id="cartDrawerSubtotal">Rp 0</span>
            </div>
            <div class="flex flex-col gap-2.5">
                <button 
                    type="button" 
                    id="cartCheckoutBtn"
                    onclick="proceedToCheckout()"
                    class="w-full py-3.5 px-4 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span>Lanjut ke Pembayaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
                <button 
                    type="button" 
                    onclick="closeCartDrawer()" 
                    class="w-full py-2.5 text-center text-xs font-semibold text-slate-600 hover:text-slate-900 cursor-pointer"
                >
                    ← Lanjut Pilih Produk Lain
                </button>
            </div>
        </div>
    </div>

    {{-- 4. CHECKOUT MODAL SHEET --}}
    <div id="checkoutModalBackdrop" class="fixed inset-0 bg-black/75 backdrop-blur-md z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeCheckoutModal()"></div>
    <div id="checkoutModalPanel" class="fixed inset-x-4 top-1/2 -translate-y-1/2 max-w-lg mx-auto bg-white rounded-3xl shadow-2xl z-50 p-6 sm:p-8 opacity-0 pointer-events-none scale-95 transition-all duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar border border-emerald-900/30">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">Konfirmasi Pemesanan</h3>
                    <p class="text-xs text-slate-500">StrikeStore Fast Order & Pengiriman</p>
                </div>
            </div>
            <button type="button" onclick="closeCheckoutModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer" aria-label="Tutup form checkout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="checkoutForm" onsubmit="submitCheckoutOrder(event)" class="mt-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Angler</label>
                <input type="text" id="custName" required placeholder="Contoh: Bintang Angler" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Aktif</label>
                <input type="tel" id="custPhone" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Pengiriman Lengkap</label>
                <textarea id="custAddress" required rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, kota & kode pos..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ekspedisi Khusus Perlengkapan Pancing</label>
                <select id="custCourier" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                    <option value="J&T Cargo Pipa PVC">J&T Cargo — Packing Pipa PVC Paralon Tebal (Sangat Direkomendasikan untuk Joran)</option>
                    <option value="SiCepat Best">SiCepat BEST / Cargo — Bubble Wrap Tebal & Asuransi Penuh</option>
                    <option value="JNE YES">JNE YES — Kirim Cepat 1 Hari Sampai</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <label class="p-3 border border-emerald-500/50 bg-emerald-50/50 rounded-xl flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="Transfer Bank / VA" checked class="text-emerald-600 focus:ring-emerald-500" />
                        <span class="font-bold text-slate-800">Transfer / VA (BCA, Mandiri, BRI)</span>
                    </label>
                    <label class="p-3 border border-slate-200 bg-white rounded-xl flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="QRIS Instant" class="text-emerald-600 focus:ring-emerald-500" />
                        <span class="font-bold text-slate-800">QRIS Instant All Pay</span>
                    </label>
                </div>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-600">
                <div class="flex justify-between font-bold text-slate-900 text-sm mb-1">
                    <span>Total yang Harus Dibayar:</span>
                    <span id="checkoutModalTotal" class="text-emerald-800 font-extrabold">Rp 0</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">
                    Pesanan Anda akan langsung dibuatkan invoice resmi. Anda akan terhubung ke WhatsApp CS StrikeStore untuk konfirmasi resi pengiriman.
                </p>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-xl shadow-emerald-950/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Konfirmasi Pesanan via WhatsApp CS</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>
    </div>

    {{-- 5. ANGLER CLUB / ACCOUNT MODAL --}}
    <div id="accountModalBackdrop" class="fixed inset-0 bg-black/75 backdrop-blur-md z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeAccountModal()"></div>
    <div id="accountModalPanel" class="fixed inset-x-4 top-1/2 -translate-y-1/2 max-w-md mx-auto bg-white rounded-3xl shadow-2xl z-50 p-6 sm:p-8 opacity-0 pointer-events-none scale-95 transition-all duration-300 border border-emerald-900/30">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-950 text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                <div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900">StrikeStore Angler Club</h3>
                    <p class="text-xs text-slate-500">Akses Eksklusif & Pelacakan Pesanan</p>
                </div>
            </div>
            <button type="button" onclick="closeAccountModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-pointer" aria-label="Tutup modal akun">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="flex border-b border-slate-200 mt-4">
            <button type="button" id="tabBtnLogin" onclick="switchAccountTab('login')" class="flex-1 pb-2.5 text-xs font-bold border-b-2 border-emerald-600 text-emerald-800">
                Masuk / Angler Member
            </button>
            <button type="button" id="tabBtnTrack" onclick="switchAccountTab('track')" class="flex-1 pb-2.5 text-xs font-semibold text-slate-400 border-b-2 border-transparent hover:text-slate-700">
                Lacak Resi Pesanan
            </button>
        </div>

        {{-- Login Tab Content --}}
        <div id="tabContentLogin" class="mt-5 space-y-4">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" required placeholder="bintang@strikestore.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
                <button type="submit" class="w-full py-3 rounded-xl font-heading font-bold text-xs bg-[#064E3B] hover:bg-emerald-700 text-white transition-all shadow-md cursor-pointer">
                    Masuk ke Akun
                </button>
            </form>
            <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                <span>Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-700 font-bold hover:underline">Daftar sekarang</a></span>
                <a href="{{ route('login') }}" class="text-emerald-700 font-bold hover:underline">Halaman Login &rarr;</a>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-xs text-emerald-800 leading-relaxed">
                <strong>🎣 Akun Demo Pengujian:</strong><br>
                Member: <code class="bg-emerald-100 px-1 rounded text-emerald-900 font-bold">bintang@strikestore.id</code> (pass: <code class="bg-emerald-100 px-1 rounded font-bold">password</code>)<br>
                Admin: <code class="bg-emerald-100 px-1 rounded text-emerald-900 font-bold">admin@strikestore.id</code> (pass: <code class="bg-emerald-100 px-1 rounded font-bold">password</code>)
            </div>
        </div>

        {{-- Track Tab Content --}}
        <div id="tabContentTrack" class="mt-5 space-y-4 hidden">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">ID Pesanan atau Nomor Resi</label>
                <input type="text" id="trackOrderId" placeholder="Contoh: STRIKE-89021 atau No. WhatsApp" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
            </div>
            <button type="button" onclick="simulateTrackOrder()" class="w-full py-3 rounded-xl font-heading font-bold text-xs bg-slate-900 hover:bg-emerald-700 text-white transition-all shadow-md cursor-pointer">
                Cek Status Pengiriman
            </button>
            <div id="trackResultBox" class="hidden p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 space-y-1">
                <div class="font-bold text-emerald-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Paket Sedang Dalam Pengiriman
                </div>
                <p class="text-slate-500 text-[11px]">Kurir: J&T Cargo (Pipa PVC Paralon)</p>
                <p class="text-slate-500 text-[11px]">Estimasi tiba: 1-2 hari kerja.</p>
            </div>
        </div>
    </div>

    {{-- MAIN PAGE CONTENT --}}
    <main class="flex-1">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="p-4 rounded-2xl bg-emerald-950/90 border border-emerald-500/50 text-emerald-200 text-sm flex items-center justify-between shadow-xl">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-800 text-emerald-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="p-4 rounded-2xl bg-red-950/90 border border-red-500/50 text-red-200 text-sm flex items-center justify-between shadow-xl">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-red-800 text-red-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    {{-- 6. FOOTER --}}
    <footer class="bg-gradient-to-b from-[#022C22] via-[#071C17] to-[#01140F] text-slate-300 pt-16 pb-8 border-t border-emerald-900/60 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-12 border-b border-emerald-900/50">
                
                {{-- Column 1: Brand Info --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="inline-block mb-4" aria-label="StrikeStore Home">
                        <x-logo size="default" />
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-sm mt-2">
                        <strong>StrikeStore</strong> adalah destinasi e-commerce perlengkapan memancing premium terpercaya. Kami menyediakan joran, reel, umpan, senar, dan aksesori memancing kelas turnamen dari brand dunia terkemuka.
                    </p>
                    
                    <div class="flex items-center gap-3 mt-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Komunitas:</span>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-emerald-950/80 border border-emerald-800/60 flex items-center justify-center text-slate-300 hover:text-emerald-300 hover:border-emerald-400 transition-colors" title="Instagram StrikeStore">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-emerald-950/80 border border-emerald-800/60 flex items-center justify-center text-slate-300 hover:text-emerald-300 hover:border-emerald-400 transition-colors" title="YouTube StrikeStore">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-emerald-950/80 border border-emerald-800/60 flex items-center justify-center text-slate-300 hover:text-emerald-300 hover:border-emerald-400 transition-colors" title="Facebook StrikeStore">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Kategori Belanja --}}
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 text-emerald-400">
                        Kategori Belanja
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalog.category', 'joran') }}" class="hover:text-emerald-300 transition-colors">Joran Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'reel') }}" class="hover:text-emerald-300 transition-colors">Reel Pancing</a></li>
                        <li><a href="{{ route('catalog.category', 'umpan') }}" class="hover:text-emerald-300 transition-colors">Umpan Pancing (Lures)</a></li>
                        <li><a href="{{ route('catalog.category', 'senar') }}" class="hover:text-emerald-300 transition-colors">Senar Pancing (PE & Leader)</a></li>
                        <li><a href="{{ route('catalog.category', 'kail-aksesori') }}" class="hover:text-emerald-300 transition-colors">Kail & Aksesori</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-300 transition-colors font-semibold text-emerald-400">Semua Produk →</a></li>
                    </ul>
                </div>

                {{-- Column 3: Bantuan & Panduan --}}
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 text-emerald-400">
                        Bantuan Pelanggan
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-300 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-300 transition-colors">Garansi & Retur</a></li>
                        <li><button type="button" onclick="openAccountModal(); switchAccountTab('track');" class="hover:text-emerald-300 transition-colors text-left cursor-pointer">Cek Status Pengiriman</button></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-300 transition-colors">Panduan Memilih Joran & Reel</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-emerald-300 transition-colors text-xs text-slate-500">Katalog Manajemen Internal</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak & Store --}}
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 text-emerald-400">
                        Hubungi Angler Support
                    </h4>
                    <ul class="space-y-3 text-xs leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Samudra Strike No. 88, Dermaga Marina, Jakarta Utara</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>WhatsApp: <strong class="text-white">+62 812-3456-7890</strong></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>support@strikestore.id</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Senin – Sabtu: 08:00 – 21:00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Legal & Payments --}}
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>© {{ date('Y') }} StrikeStore. Hak cipta dilindungi undang-undang. Built for true anglers.</p>
                <div class="flex items-center gap-3 text-slate-400 flex-wrap justify-center">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Metode Pembayaran Aman:</span>
                    <span class="px-2.5 py-1 rounded-md bg-[#071C17] border border-emerald-900/80 text-[10px] font-bold text-slate-200">BCA</span>
                    <span class="px-2.5 py-1 rounded-md bg-[#071C17] border border-emerald-900/80 text-[10px] font-bold text-slate-200">Mandiri</span>
                    <span class="px-2.5 py-1 rounded-md bg-[#071C17] border border-emerald-900/80 text-[10px] font-bold text-slate-200">BRI</span>
                    <span class="px-2.5 py-1 rounded-md bg-[#071C17] border border-emerald-900/80 text-[10px] font-bold text-emerald-400">QRIS</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- TOAST NOTIFICATION CONTAINER --}}
    <div id="toastNotification" class="fixed top-24 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#064E3B] text-white border border-emerald-400/40 shadow-2xl shadow-emerald-950/60 translate-x-[150%] transition-transform duration-300 max-w-sm pointer-events-none">
        <div class="w-8 h-8 rounded-xl bg-emerald-500/30 flex items-center justify-center shrink-0 text-emerald-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="flex-1 text-xs">
            <div class="font-bold text-white text-sm" id="toastTitle">Berhasil Ditambahkan</div>
            <div class="text-emerald-100" id="toastMessage">Produk telah masuk ke keranjang belanja Anda.</div>
        </div>
    </div>

    {{-- GLOBAL CART, MODALS & UI SCRIPTS --}}
    <script>
        // CSRF Token header for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentCartData = { items: [], count: 0, subtotal: 0 };

        // Toggle Mobile Menu
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

        // Toggle Mobile Search
        function toggleMobileSearch() {
            const searchPanel = document.getElementById('mobileSearchPanel');
            searchPanel.classList.toggle('hidden');
        }

        // Open Cart Drawer
        function openCartDrawer() {
            const panel = document.getElementById('cartDrawerPanel');
            const backdrop = document.getElementById('cartDrawerBackdrop');
            panel.classList.remove('translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            fetchCart();
        }

        // Close Cart Drawer
        function closeCartDrawer() {
            const panel = document.getElementById('cartDrawerPanel');
            const backdrop = document.getElementById('cartDrawerBackdrop');
            panel.classList.add('translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }

        // Account Modal
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
                btnLogin.classList.add('border-emerald-600', 'text-emerald-800');
                btnLogin.classList.remove('border-transparent', 'text-slate-400');
                btnTrack.classList.remove('border-emerald-600', 'text-emerald-800');
                btnTrack.classList.add('border-transparent', 'text-slate-400');
                contentLogin.classList.remove('hidden');
                contentTrack.classList.add('hidden');
            } else {
                btnTrack.classList.add('border-emerald-600', 'text-emerald-800');
                btnTrack.classList.remove('border-transparent', 'text-slate-400');
                btnLogin.classList.remove('border-emerald-600', 'text-emerald-800');
                btnLogin.classList.add('border-transparent', 'text-slate-400');
                contentTrack.classList.remove('hidden');
                contentLogin.classList.add('hidden');
            }
        }

        function simulateLogin() {
            showToast('Selamat Datang Angler! 🎣', 'Anda berhasil masuk ke StrikeStore Angler Club.');
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

        // Checkout Modal Functions
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

            showToast('Pesanan Diproses! 🎣', 'Membuka WhatsApp CS StrikeStore untuk konfirmasi...');
            closeCheckoutModal();

            setTimeout(() => {
                window.open(`https://wa.me/6281234567890?text=${waMessage}`, '_blank');
            }, 600);
        }

        // Show Toast Notification
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

        // Add to Cart Function
        function addToCart(productId, qty = 1, btn = null, variant = null) {
            let originalContent = '';
            if (btn) {
                originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<svg class="w-5 h-5 animate-spin mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
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
                    showToast('Berhasil Ditambahkan! 🎣', data.message);
                    openCartDrawer();
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

        // Fetch Cart Contents & Render Drawer
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

        // Render Cart HTML inside Drawer
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

            // Free shipping calculation (threshold Rp 500.000)
            const freeThreshold = 500000;
            const progress = Math.min(100, (data.subtotal / freeThreshold) * 100);
            if (shippingBar) shippingBar.style.width = `${progress}%`;
            if (shippingNotice) {
                if (data.subtotal >= freeThreshold) {
                    shippingNotice.innerHTML = `<span class="text-emerald-700 font-bold">🎉 Selamat! Gratis Ongkir Aktif</span>`;
                } else {
                    const diff = freeThreshold - data.subtotal;
                    shippingNotice.innerHTML = `Tambah <strong class="text-emerald-700">Rp ${diff.toLocaleString('id-ID')}</strong> lagi untuk Gratis Ongkir!`;
                }
            }

            if (!data.items || data.items.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-slate-400">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-slate-600 font-medium">Keranjang Anda masih kosong</p>
                        <p class="text-xs text-slate-400 mt-1">Jelajahi joran, reel, dan umpan terbaik kami.</p>
                        <a href="{{ route('catalog.index') }}" onclick="closeCartDrawer()" class="inline-block mt-4 px-5 py-2.5 rounded-xl bg-[#064E3B] text-white text-xs font-bold hover:bg-emerald-600 transition-colors">
                            Mulai Belanja
                        </a>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-4">';
            data.items.forEach(item => {
                const itemTotal = (item.price * item.quantity).toLocaleString('id-ID');
                const variantBadge = item.variant ? `<div class="inline-block text-[10px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-md mt-1">Varian: ${item.variant}</div>` : '';

                html += `
                    <div class="flex gap-3.5 p-3 rounded-2xl bg-slate-50 border border-slate-200/90 items-center justify-between">
                        <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-xl bg-white shrink-0 border border-slate-200" />
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate">${item.name}</h4>
                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">SKU: ${item.sku || '-'}</p>
                            ${variantBadge}
                            <p class="text-xs font-extrabold text-emerald-900 mt-1">Rp ${itemTotal}</p>
                            
                            <div class="flex items-center gap-2 mt-2">
                                <div class="inline-flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden text-xs">
                                    <button onclick="updateItemQuantity(${item.id}, ${item.quantity - 1})" class="px-2 py-0.5 hover:bg-slate-100 font-bold text-slate-600 cursor-pointer">-</button>
                                    <span class="px-2.5 py-0.5 font-bold text-slate-900">${item.quantity}</span>
                                    <button onclick="updateItemQuantity(${item.id}, ${item.quantity + 1})" class="px-2 py-0.5 hover:bg-slate-100 font-bold text-slate-600 cursor-pointer">+</button>
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

        // Update quantity
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

        // Remove item
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

        // Proceed to Checkout
        function proceedToCheckout() {
            openCheckoutModal();
        }
    </script>

    @stack('scripts')
</body>
</html>
