@props(['model', 'value' => null, 'label'])
<div @click="{{ $value ? "$model = '$value'" : "$model = !$model" }}" class="flex items-center gap-2.5 cursor-pointer select-none">
    <div class="w-5 h-5 bg-6 rounded-full p-[2px] flex items-center justify-center shrink-0">
        <div class="bg-white rounded-full w-full h-full flex items-center justify-center">
            <div x-show="{{ $value ? "$model === '$value'" : $model }}" class="w-2.5 h-2.5 bg-6 rounded-full"></div>
        </div>
    </div>
    <span class="text-sm font-bold text-3">{{ $label }}</span>
</div>
