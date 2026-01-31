<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Quick Actions Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Pengaturan Sistem Pusat</h2>
            <p class="text-sm text-slate-500">Kelola konfigurasi global aplikasi, tampilan, dan integrasi dari satu tempat.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button wire:click="clearCache" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                <svg wire:loading.remove target="clearCache" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                <svg wire:loading target="clearCache" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Bersihkan Cache
            </button>
            <button wire:click="backupNow" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                <svg wire:loading.remove target="backupNow" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
                <svg wire:loading target="backupNow" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Backup Manual
            </button>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-2">
            @foreach($schema as $key => $group)
                <button wire:click="switchTab('{{ $key }}')" wire:key="tab-btn-{{ $key }}"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left transition-all duration-300 {{ $activeTab === $key ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-transparent hover:border-slate-200' }}">
                    
                    <!-- Icon Switcher based on Key -->
                    @if($group['icon'] == 'office-building')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    @elseif($group['icon'] == 'desktop-computer')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    @elseif($group['icon'] == 'clock')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($group['icon'] == 'share')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                    @elseif($group['icon'] == 'currency-dollar')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($group['icon'] == 'document-text')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    @elseif($group['icon'] == 'shield-check')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    @elseif($group['icon'] == 'bell')
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    @else
                        <svg class="w-5 h-5 {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                    @endif
                    
                    <span class="font-bold text-sm">{{ $group['label'] }}</span>
                </button>
            @endforeach
        </div>

        <!-- Form Content -->
        <div class="lg:col-span-3 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
            @if(isset($schema[$activeTab]))
                <div class="mb-8 border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-black text-slate-800">{{ $schema[$activeTab]['label'] }}</h3>
                    <p class="text-sm text-slate-400 mt-1">Sesuaikan konfigurasi di bawah ini sesuai kebutuhan instansi.</p>
                </div>

                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($schema[$activeTab]['fields'] as $fieldKey => $config)
                            <div class="col-span-1 {{ in_array($config['type'], ['textarea', 'section_title']) ? 'md:col-span-2' : '' }}" wire:key="field-{{ $fieldKey }}">
                                <label for="{{ $fieldKey }}" class="block text-sm font-bold text-slate-700 mb-2">
                                    {{ $config['label'] }}
                                </label>
                                
                                @if($config['type'] === 'text')
                                    <input type="text" id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800 placeholder-slate-400">
                                
                                @elseif($config['type'] === 'number')
                                    <input type="number" id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800">
                                
                                @elseif($config['type'] === 'email')
                                    <input type="email" id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800">
                                
                                @elseif($config['type'] === 'password')
                                    <input type="password" id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800">

                                @elseif($config['type'] === 'time')
                                    <input type="time" id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800">

                                @elseif($config['type'] === 'textarea')
                                    <textarea id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" rows="3"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800"></textarea>

                                @elseif($config['type'] === 'select')
                                    <div class="relative">
                                        <select id="{{ $fieldKey }}" wire:model="form.{{ $fieldKey }}" 
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-800 appearance-none">
                                            @foreach($config['options'] as $val => $label)
                                                <option value="{{ $val }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                @endif

                                @if(isset($config['help']))
                                    <p class="mt-2 text-xs text-slate-400">{{ $config['help'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                        <div wire:loading wire:target="save" class="text-sm text-slate-400">Menyimpan...</div>
                        <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>