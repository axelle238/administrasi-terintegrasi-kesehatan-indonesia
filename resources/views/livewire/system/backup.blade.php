<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-slate-100">
        <div class="p-8 bg-white border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-800">Database Backups</h3>
                <p class="text-sm text-slate-500">Kelola cadangan data sistem secara berkala untuk keamanan.</p>
            </div>
            <button wire:click="createBackup" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30">
                <svg wire:loading.remove class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Buat Backup Baru
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama File</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Ukuran</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-8 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($backups as $backup)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="p-2 bg-slate-100 rounded-lg mr-3 text-slate-500">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                                    </div>
                                    <span class="text-sm font-bold text-slate-800">{{ $backup['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-slate-600">
                                {{ $backup['size'] }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-slate-600">
                                {{ $backup['date'] }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="download('{{ $backup['path'] }}')" class="text-indigo-600 hover:text-indigo-900 font-bold mr-4 hover:underline">Download</button>
                                <button wire:click="delete('{{ $backup['path'] }}')" wire:confirm="Yakin ingin menghapus backup ini?" class="text-red-600 hover:text-red-900 font-bold hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">Belum ada file backup tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
