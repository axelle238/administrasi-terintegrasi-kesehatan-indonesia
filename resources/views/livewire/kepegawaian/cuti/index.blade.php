<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Quick Stats (Untuk Pegawai) -->
    @if(!$isAdmin)
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}!</h3>
            <p class="text-indigo-100 text-sm">Kelola waktu istirahat Anda dengan bijak.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest">Sisa Cuti Tahunan</p>
            <h2 class="text-4xl font-black">{{ \App\Models\Pegawai::where('user_id', Auth::id())->value('sisa_cuti') ?? 0 }} <span class="text-lg font-medium">Hari</span></h2>
        </div>
    </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-gray-600 font-bold text-lg">
            Riwayat Pengajuan
            @if($isAdmin)
                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full font-bold ml-2">Mode Admin (Approval)</span>
            @endif
        </div>
        <button wire:click="create" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 w-full md:w-auto shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 font-bold text-sm flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan Cuti Baru
        </button>
    </div>

    {{-- Inline Form Section --}}
    @if($isOpen)
        <div class="bg-white overflow-hidden shadow-xl rounded-[2rem] border border-indigo-100 p-8 animate-fade-in relative">
            <button wire:click="$set('isOpen', false)" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="border-b border-gray-100 pb-6 mb-6">
                <h3 class="text-xl font-black text-slate-800">Form Pengajuan Cuti</h3>
                <p class="mt-1 text-sm text-slate-500">Isi detail rencana cuti Anda. Pastikan saldo cuti mencukupi.</p>
            </div>
            
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="jenis_cuti" value="Jenis Cuti" />
                        <select wire:model="jenis_cuti" id="jenis_cuti" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4">
                            <option value="Cuti Tahunan">Cuti Tahunan (Potong Kuota)</option>
                            <option value="Sakit">Sakit (Lampirkan Surat Dokter)</option>
                            <option value="Izin">Izin (Potong Gaji/Unpaid)</option>
                            <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                        </select>
                        @error('jenis_cuti') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                        <x-text-input type="date" wire:model.live="tanggal_mulai" id="tanggal_mulai" class="w-full mt-1 rounded-xl py-3 px-4" />
                        @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <x-input-label for="tanggal_selesai" value="Tanggal Selesai" />
                        <x-text-input type="date" wire:model.live="tanggal_selesai" id="tanggal_selesai" class="w-full mt-1 rounded-xl py-3 px-4" />
                        @error('tanggal_selesai') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Durasi Kalkulasi -->
                    <div class="col-span-1 md:col-span-2 bg-indigo-50 p-4 rounded-xl flex items-center justify-between border border-indigo-100">
                        <span class="text-sm font-bold text-indigo-700">Total Durasi Pengajuan:</span>
                        <span class="text-2xl font-black text-indigo-900">{{ $durasi_hari }} <span class="text-sm font-medium">Hari</span></span>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="keterangan" value="Keterangan / Alasan" />
                        <textarea wire:model="keterangan" id="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4" placeholder="Jelaskan alasan pengajuan cuti..."></textarea>
                        @error('keterangan') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="file_bukti" value="Upload Bukti (Opsional / Surat Dokter)" />
                        <input type="file" wire:model="file_bukti" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-xs file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100 mt-2" />
                        @error('file_bukti') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-3 pt-6 border-t border-gray-100">
                    <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition flex items-center gap-2">
                        <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span wire:loading.remove>Kirim Pengajuan</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase font-black text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tanggal Pengajuan</th>
                        @if($isAdmin) <th class="px-6 py-4">Nama Pegawai</th> @endif
                        <th class="px-6 py-4">Jenis & Keterangan</th>
                        <th class="px-6 py-4 text-center">Periode</th>
                        <th class="px-6 py-4 text-center">Durasi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($cutis as $cuti)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600 font-medium">
                                {{ $cuti->created_at->translatedFormat('d M Y') }}
                            </td>
                            @if($isAdmin)
                            <td class="px-6 py-4 font-bold text-slate-800">
                                {{ $cuti->user->name }}
                            </td>
                            @endif
                            <td class="px-6 py-4">
                                <p class="font-bold text-indigo-600">{{ $cuti->jenis_cuti }}</p>
                                <p class="text-xs text-slate-500 truncate max-w-xs">{{ $cuti->keterangan }}</p>
                                @if($cuti->file_bukti)
                                    <a href="{{ Storage::url($cuti->file_bukti) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        Lihat Bukti
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600 text-xs">
                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center font-black text-slate-800">
                                {{ $cuti->durasi_hari }} Hari
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusClass = match($cuti->status) {
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                        'Disetujui' => 'bg-emerald-100 text-emerald-700',
                                        'Ditolak' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-black uppercase tracking-widest rounded-full {{ $statusClass }}">
                                    {{ $cuti->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($cuti->status == 'Pending')
                                    @if($isAdmin)
                                        <div class="flex justify-end gap-2">
                                            <button wire:click="approve({{ $cuti->id }})" wire:confirm="Setujui pengajuan ini?" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition" title="Setujui">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                            <button wire:click="reject({{ $cuti->id }})" wire:confirm="Tolak pengajuan ini?" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 transition" title="Tolak">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    @elseif($cuti->user_id == Auth::id())
                                        <button wire:click="cancel({{ $cuti->id }})" wire:confirm="Batalkan pengajuan ini?" class="text-rose-500 hover:text-rose-700 font-bold text-xs uppercase tracking-wider hover:underline">
                                            Batalkan
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isAdmin ? 8 : 7 }}" class="px-6 py-12 text-center text-gray-400 italic">
                                Belum ada riwayat pengajuan cuti.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $cutis->links() }}
        </div>
    </div>
</div>