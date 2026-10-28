@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-t border-slate-200 bg-white">
        <div class="text-xs text-slate-500">
            Menampilkan <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span> &ndash; <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-slate-900">{{ $paginator->total() }}</span> produk
        </div>

        <nav class="flex items-center gap-1.5" role="navigation" aria-label="Navigasi Halaman">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 rounded-xl border border-slate-200 bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed text-xs" aria-disabled="true">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="15 18 9 12 15 6"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 flex items-center justify-center transition-all shadow-sm text-xs" rel="prev" title="Halaman Sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="15 18 9 12 15 6"/></svg>
                </a>
            @endif

            {{-- Angka Halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 flex items-center justify-center text-slate-400 text-xs font-bold">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 rounded-xl bg-gradient-to-r from-[#064E3B] to-[#047857] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-emerald-950/20" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 font-semibold text-xs flex items-center justify-center transition-all shadow-sm">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 flex items-center justify-center transition-all shadow-sm text-xs" rel="next" title="Halaman Berikutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="9 18 15 12 9 6"/></svg>
                </a>
            @else
                <span class="w-9 h-9 rounded-xl border border-slate-200 bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed text-xs" aria-disabled="true">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="9 18 15 12 9 6"/></svg>
                </span>
            @endif
        </nav>
    </div>
@endif
