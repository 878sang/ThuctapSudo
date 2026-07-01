<button class="cursor-pointer " type="{{ $type ?? 'button' }}">
    <a href=" {{ $href }}" class="{{ $class ?? 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white' }} inline-flex items-center justify-center gap-2 px-5 py-2.5  hover:from-indigo-700 hover:to-violet-700 font-semibold rounded-xl text-sm shadow-lg shadow-indigo-150 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>{{ $slot }}</span>
    </a>
</button>