@props(['qty' => 1, 'name' => 'quantity', 'autoUpdate' => false, 'max' => 0])
<div {{ $attributes->merge(['class' => 'inline-flex items-center border border-gray-200 rounded-[5px] overflow-hidden bg-[#F2F2F2]/80']) }}
    x-data="{ qty: {{ $qty }}, max: {{ (int)$max }} }"
    x-init="$watch('qty', value => { 
         let currentVal = Number(value);
         let maxVal = Number(max);
         if (maxVal > 0 && currentVal > maxVal) {
             qty = maxVal;
             if (window.showToast) {
                 window.showToast('Số lượng vượt quá số lượng trong kho', 'error');
             } else {
                 alert('Số lượng vượt quá số lượng trong kho');
             }
         }
         if (!qty || Number(qty) < 1) qty = 1;
         if ({{ $autoUpdate ? 'true' : 'false' }}) { $dispatch('change', { qty: qty }) } 
     })">
    <button type="button" @click="if(Number(qty) > 1) qty--" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors font-bold text-sm cursor-pointer select-none">-</button>
    <input type="text" name="{{ $name }}" x-model.number="qty" class="w-8 text-center text-sm font-bold border-none focus:outline-none focus:ring-0 p-0 bg-white h-7">
    <button type="button" @click="let currentVal = Number(qty); let maxVal = Number(max); if(maxVal > 0 && currentVal >= maxVal) { qty = maxVal; if (window.showToast) { window.showToast('Số lượng vượt quá số lượng trong kho', 'error'); } else { alert('Số lượng vượt quá số lượng trong kho'); } } else { qty++ }" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors font-bold text-sm cursor-pointer select-none">+</button>
</div>