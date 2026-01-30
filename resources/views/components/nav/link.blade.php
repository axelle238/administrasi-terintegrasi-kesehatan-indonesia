@props(['href', 'active', 'icon'])

<a href="{{ $href }}" 
   class="flex items-center gap-3 px-4 py-3 mb-2 text-sm font-bold rounded-xl transition-all duration-200 group {{ $active ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
    <div class="{{ $active ? 'text-white' : 'text-slate-400 group-hover:text-blue-500' }}">
        {{ $slot }}
    </div>
    <span class="tracking-wide">{{ $icon }}</span> <!-- Menggunakan $icon sebagai label karena konsistensi props lama -->
</a>