@props(['size' => 'default', 'variant' => 'light'])

@php
    $dimensions = match($size) {
        'sm' => ['icon' => 'w-7 h-7', 'text' => 'text-lg', 'sub' => 'text-[9px]'],
        'lg' => ['icon' => 'w-11 h-11', 'text' => 'text-2xl', 'sub' => 'text-xs'],
        default => ['icon' => 'w-9 h-9', 'text' => 'text-xl', 'sub' => 'text-[10px]'],
    };
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 select-none']) }}>
    {{-- Hook & Strike Emblem --}}
    <div class="{{ $dimensions['icon'] }} relative rounded-xl bg-gradient-to-br from-[#064E3B] via-[#022C22] to-[#071C17] p-1.5 shadow-md shadow-emerald-950/50 border border-emerald-500/30 flex items-center justify-center shrink-0 group">
        <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-emerald-500/10 to-transparent pointer-events-none"></div>
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow">
            {{-- Stylized metallic hook with lightning barb strike --}}
            <defs>
                <linearGradient id="silverSheen" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#FFFFFF"/>
                    <stop offset="50%" stop-color="#E5E7EB"/>
                    <stop offset="100%" stop-color="#9CA3AF"/>
                </linearGradient>
                <linearGradient id="emeraldStrike" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#34D399"/>
                    <stop offset="100%" stop-color="#10B981"/>
                </linearGradient>
            </defs>
            {{-- Hook curve --}}
            <path d="M22 6V20C22 25.5228 17.5228 30 12 30C10.5 30 9.2 29.6 8 29C7.2 28.6 6.8 27.6 7.2 26.8C7.6 26 8.6 25.6 9.4 26C10.2 26.4 11.1 26.6 12 26.6C15.6451 26.6 18.6 23.6451 18.6 20V12L15 15.5L16.2 11.5L22 6Z" fill="url(#silverSheen)" />
            {{-- Strike Lightning Barb --}}
            <path d="M22 10L31 16L24 19L33 28L18 34L22 24L16 23L22 10Z" fill="url(#emeraldStrike)" stroke="#064E3B" stroke-width="0.8" stroke-linejoin="round"/>
            {{-- Metallic Line Eyelet --}}
            <circle cx="22" cy="7" r="2.5" stroke="url(#silverSheen)" stroke-width="1.8" fill="#022C22"/>
        </svg>
    </div>

    {{-- Typography Wordmark --}}
    <div class="flex flex-col leading-none">
        <div class="flex items-center tracking-tight font-extrabold font-heading {{ $dimensions['text'] }}">
            <span class="text-white">STRIKE</span>
            <span class="bg-gradient-to-r from-emerald-400 via-emerald-300 to-teal-200 bg-clip-text text-transparent ml-0.5">STORE</span>
        </div>
        <span class="font-sans font-semibold tracking-[0.2em] text-emerald-400/80 uppercase {{ $dimensions['sub'] }} mt-0.5">
            PREMIUM ANGLER GEAR
        </span>
    </div>
</div>
