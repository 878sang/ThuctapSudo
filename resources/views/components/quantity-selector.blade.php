@props(['qty' => 1])
<div class="inline-flex items-center border border-gray-200 rounded-[5px] overflow-hidden bg-[#F2F2F2]/80 animate-fade-in" x-data="{ qty: {{ $qty }} }">
    <button @click="if(qty > 1) qty--" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors font-bold text-sm cursor-pointer select-none">-</button>
    <input type="text" x-model="qty" class="w-8 text-center text-sm font-bold border-none focus:outline-none focus:ring-0 p-0 bg-white h-7">
    <button @click="qty++" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors font-bold text-sm cursor-pointer select-none">+</button>
</div>
