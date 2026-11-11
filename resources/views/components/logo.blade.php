@props(['size' => 'default', 'variant' => 'dark'])

@php
    $dimensions = match($size) {
        'sm' => ['icon' => 'w-8 h-8', 'text' => 'text-lg', 'sub' => 'text-[9px]'],
        'lg' => ['icon' => 'w-11 h-11', 'text' => 'text-2xl', 'sub' => 'text-xs'],
        default => ['icon' => 'w-9 h-9', 'text' => 'text-xl', 'sub' => 'text-[10px]'],
    };
    $isLightText = $variant === 'light';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 select-none']) }}>
    {{-- Hook & Strike Emblem --}}
    <div class="{{ $dimensions['icon'] }} relative rounded-xl bg-[#194668] p-1.5 shadow-sm border border-[#102D42]/20 flex items-center justify-center shrink-0 group transition-transform duration-200 group-hover:scale-105">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
            {{-- Hook curve --}}
            <path d="M22 6V20C22 25.5228 17.5228 30 12 30C10.5 30 9.2 29.6 8 29C7.2 28.6 6.8 27.6 7.2 26.8C7.6 26 8.6 25.6 9.4 26C10.2 26.4 11.1 26.6 12 26.6C15.6451 26.6 18.6 23.6451 18.6 20V12L15 15.5L16.2 11.5L22 6Z" fill="#FFFFFF" />
            {{-- Strike Lightning Barb in Warm Brown --}}
            <path d="M22 10L31 16L24 19L33 28L18 34L22 24L16 23L22 10Z" fill="#C5804B" stroke="#102D42" stroke-width="0.8" stroke-linejoin="round"/>
            {{-- Eyelet --}}
            <circle cx="22" cy="7" r="2.5" stroke="#FFFFFF" stroke-width="1.8" fill="#102D42"/>
        </svg>
    </div>

    {{-- Typography Wordmark --}}
    <div class="flex flex-col leading-none">
        <div class="flex items-center tracking-tight font-extrabold font-heading {{ $dimensions['text'] }}">
            <span class="{{ $isLightText ? 'text-white' : 'text-[#102D42]' }}">STRIKE</span>
            <span class="text-[#C5804B] ml-0.5">STORE</span>
        </div>
        <span class="font-sans font-medium tracking-[0.18em] {{ $isLightText ? 'text-[#DCE5EB]' : 'text-[#7A8791]' }} uppercase {{ $dimensions['sub'] }} mt-0.5">
            PREMIUM ANGLER GEAR
        </span>
    </div>
</div>
