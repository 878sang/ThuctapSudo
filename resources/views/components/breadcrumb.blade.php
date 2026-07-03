@props(['items' => []])

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <!-- Home item -->
        <li class="inline-flex items-center">
            <a href="/" class="inline-flex items-center text-xs sm:text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors duration-150">
                <svg class="w-4.5 h-4.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Trang chủ
            </a>
        </li>
        
        <!-- Loop items -->
        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-slate-350 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    @if(isset($item['url']) && !$loop->last)
                        <a href="{{ $item['url'] }}" class="ml-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors duration-150">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="ml-1.5 text-xs sm:text-sm font-semibold text-slate-700">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
