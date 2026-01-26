<div wire:poll.30s>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <!-- Total -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pegawai</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalPegawai }}</p>
                </div>
            </div>
        </div>

        <!-- Dokter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="bg-green-100 p-2 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Dokter</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalDokter }}</p>
                </div>
            </div>
        </div>

        <!-- Perawat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Perawat</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalPerawat }}</p>
                </div>
            </div>
        </div>

        <!-- EWS STR -->
        <div class="bg-red-50 rounded-xl shadow-sm border border-red-100 p-4 cursor-pointer hover:bg-red-100 transition" wire:click="$set('filterStatus', 'ews_str')">
            <div class="flex items-center gap-3">
                <div class="bg-white p-2 rounded-lg text-red-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-red-400 uppercase">STR Expired</p>
                    <p class="text-xl font-bold text-red-600">{{ $ewsStr }}</p>
                </div>
            </div>
        </div>

        <!-- EWS SIP -->
        <div class="bg-red-50 rounded-xl shadow-sm border border-red-100 p-4 cursor-pointer hover:bg-red-100 transition" wire:click="$set('filterStatus', 'ews_sip')">
            <div class="flex items-center gap-3">
                <div class="bg-white p-2 rounded-lg text-red-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-red-400 uppercase">SIP Expired</p>
                    <p class="text-xl font-bold text-red-600">{{ $ewsSip }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar & Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                
                <!-- Search & Filter -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="relative">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Pegawai..." class="w-full sm:w-64 pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-all text-sm">
                        <div class="absolute top-0 left-0 pt-2.5 pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                    
                    <select wire:model.live="filterRole" class="rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option value="">Semua Profesi</option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="apoteker">Apoteker</option>
                        <option value="bidan">Bidan</option>
                        <option value="admin">Administrasi</option>
                    </select>

                    <select wire:model.live="filterStatus" class="rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option value="">Status Normal</option>
                        <option value="ews_str">⚠ STR Kedaluwarsa</option>
                        <option value="ews_sip">⚠ SIP Kedaluwarsa</option>
                    </select>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2">
                    <button wire:click="syncBpjs" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-xl font-bold text-xs hover:bg-green-100 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Sync BPJS
                    </button>
                    
                    <a href="{{ route('pegawai.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Pegawai
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas Pegawai</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jabatan & Izin</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($pegawais as $pegawai)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($pegawai->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $pegawai->user->name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $pegawai->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $pegawai->user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $pegawai->no_telepon }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $pegawai->jabatan }}</div>
                                <div class="flex gap-1 mt-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ ucfirst($pegawai->user->role) }}
                                    </span>
                                    
                                    <!-- Indikator STR/SIP -->
                                    @php 
                                        $strExp = $pegawai->masa_berlaku_str ? \Carbon\Carbon::parse($pegawai->masa_berlaku_str) : null;
                                        $sipExp = $pegawai->masa_berlaku_sip ? \Carbon\Carbon::parse($pegawai->masa_berlaku_sip) : null;
                                        $isStrWarning = $strExp && $strExp->diffInMonths(now()) <= 3;
                                        $isSipWarning = $sipExp && $sipExp->diffInMonths(now()) <= 3;
                                    @endphp

                                    @if($isStrWarning)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-600 border border-red-100" title="STR Segera Habis">⚠ STR</span>
                                    @endif
                                    @if($isSipWarning)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-600 border border-red-100" title="SIP Segera Habis">⚠ SIP</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                    {{ $pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'Tetap' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $pegawai->status_kepegawaian }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">Edit</a>
                                    <button wire:click="delete({{ $pegawai->id }})" wire:confirm="Hapus pegawai ini?" class="text-red-600 hover:text-red-900 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                Tidak ada data pegawai ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pegawais->links() }}
        </div>
    </div>
</div>