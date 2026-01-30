@props(['href', 'active'])

<a href="{{ $href }}" 
   class="flex items-center px-4 py-2.5 text-xs font-bold rounded-lg transition-all duration-200 {{ $active ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
    <span class="w-1.5 h-1.5 rounded-full mr-3 {{ $active ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
    {{ $slot }}
</a>