@props(['active', 'icon' => null, 'label'])

@php
$isActive = $active ?? false;
@endphp

<div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" class="mb-2">
    <button @click="open = !open" 
        class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ $isActive ? 'bg-slate-100 text-slate-800' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
        <div class="flex items-center gap-3">
            @if($icon)
                <div class="{{ $isActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }} transition-colors">
                    {{ $slot }} <!-- Icon Slot -->
                </div>
            @endif
            <span class="tracking-wide">{{ $label }}</span>
        </div>
        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-blue-600' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mt-1 ml-4 pl-4 border-l-2 border-slate-100 space-y-1">
         {{ $children }}
    </div>
</div>