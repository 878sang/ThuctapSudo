@props(['stars' => 5, 'max' => 5])
<div {{ $attributes->merge(['class' => 'flex gap-0.5']) }}>
    @for($i = 1; $i <= $max; $i++)
        @if($i <= $stars)
            <i class="fa-solid fa-star text-[#F29F05]"></i>
        @else
            <i class="fa-solid fa-star text-[#E4E4E4]"></i>
        @endif
    @endfor
</div>
