@props(['items' => []])

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <a href="/" class="inline-flex text-7 text-xs sm:text-sm ">
                Trang chủ
            </a>
        </li>
        @foreach($items as $item)
        <li>
            <div class="flex items-center">
                <svg width="29" height="15" viewBox="0 0 29 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 7.16347H26.5889M21.0158 1L27.1793 7.16347L21.0158 13.3269" stroke="#A1A7AA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @if(isset($item['url']) && !$loop->last)
                <a href="{{ $item['url'] }}" class="ml-1.5 text-sm text-3">
                    {{ $item['label'] }}
                </a>
                @else
                <span class="ml-1.5 text-sm text-3 ">
                    {{ $item['label'] }}
                </span>
                @endif
            </div>
        </li>
        @endforeach
    </ol>
</nav>