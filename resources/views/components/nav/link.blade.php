@props(['href', 'active', 'icon' => null])

<a href="{{ $href }}" 
   class="flex items-center gap-3 px-4 py-3 mb-2 text-sm font-bold rounded-xl transition-all duration-200 group {{ $active ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
    <div class="{{ $active ? 'text-white' : 'text-slate-400 group-hover:text-blue-500' }}">
        @if($icon instanceof \Illuminate\View\ComponentSlot)
            {{ $icon }}
        @elseif($icon)
            {{-- If passed as string (e.g. icon name), we can't render it directly as SVG unless we use another component. 
                 But based on usage <x-slot:icon>, $icon will be a Slot. 
                 If user passed icon="some-string" and no slot, it would be a string. 
                 For safety, we prefer the slot if available. --}}
             {{ $icon }}
        @endif
    </div>
    <span class="tracking-wide">{{ $slot }}</span>
</a>