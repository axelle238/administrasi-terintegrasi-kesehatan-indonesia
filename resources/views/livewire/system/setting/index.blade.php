<div x-data="{ activeTab: 'umum' }" class="flex flex-col lg:flex-row gap-6">
    
    <!-- Sidebar Navigasi -->
    <div class="w-full lg:w-64 flex-shrink-0 space-y-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-2">
            @foreach($schema as $key => $group)
                <button 
                    @click="activeTab = '{{ $key }}'"
                    :class="activeTab === '{{ $key }}' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="w-full flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all duration-200 text-left"
                >
                    <!-- Icon based on config -->
                    @if($group['icon'] == 'office-building')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    @elseif($group['icon'] == 'desktop-computer')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    @elseif($group['icon'] == 'clock')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($group['icon'] == 'share')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                    @elseif($group['icon'] == 'currency-dollar')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($group['icon'] == 'document-text')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    @endif
                    
                    <span>{{ $group['label'] }}</span>
                </button>
            @endforeach
        </div>
        
        <div class="px-4 py-2 text-xs text-slate-400 text-center">
            Pengaturan sistem mempengaruhi seluruh operasional aplikasi.
        </div>
    </div>

    <!-- Form Content -->
    <div class="flex-1">
        <form wire:submit="save">
            @foreach($schema as $key => $group)
                <div x-show="activeTab === '{{ $key }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-800">{{ $group['label'] }}</h3>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $key }}</span>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            @foreach($group['fields'] as $fieldKey => $field)
                                <div class="grid grid-cols-1 gap-2">
                                    <label for="{{ $fieldKey }}" class="text-sm font-semibold text-slate-700">
                                        {{ $field['label'] }}
                                    </label>
                                    
                                    @if($field['type'] === 'textarea')
                                        <textarea 
                                            wire:model="form.{{ $fieldKey }}" 
                                            id="{{ $fieldKey }}" 
                                            rows="3"
                                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm"
                                        ></textarea>
                                    @elseif($field['type'] === 'time')
                                         <input 
                                            wire:model="form.{{ $fieldKey }}" 
                                            type="time" 
                                            id="{{ $fieldKey }}" 
                                            class="block w-full md:w-48 rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm font-mono"
                                        >
                                    @elseif($field['type'] === 'password')
                                        <input 
                                            wire:model="form.{{ $fieldKey }}" 
                                            type="password" 
                                            id="{{ $fieldKey }}" 
                                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm"
                                            placeholder="••••••••"
                                        >
                                    @else
                                        <input 
                                            wire:model="form.{{ $fieldKey }}" 
                                            type="{{ $field['type'] }}" 
                                            id="{{ $fieldKey }}" 
                                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm"
                                        >
                                    @endif

                                    @if(isset($field['help']))
                                        <p class="text-xs text-slate-500">{{ $field['help'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <svg wire:loading class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    </div>
</div>