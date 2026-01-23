@props(['number'])

<div class="flex flex-col items-center cursor-pointer hover:scale-110 transition transform" wire:click="toggleGigi({{ $number }})">
    <div class="w-8 h-8 border border-gray-400 flex items-center justify-center font-bold rounded shadow-sm
        {{ ($odontogram[$number] ?? 'N') == 'N' ? 'bg-white text-gray-800' : '' }}
        {{ ($odontogram[$number] ?? 'N') == 'C' ? 'bg-red-500 text-white border-red-600' : '' }}
        {{ ($odontogram[$number] ?? 'N') == 'M' ? 'bg-gray-800 text-white border-gray-900' : '' }}
        {{ ($odontogram[$number] ?? 'N') == 'F' ? 'bg-blue-500 text-white border-blue-600' : '' }}
    ">
        {{ $number }}
    </div>
    <span class="text-[10px] font-bold mt-1 text-gray-600">
        {{ $odontogram[$number] ?? 'N' }}
    </span>
</div>