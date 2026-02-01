<div class="space-y-6 animate-fade-in" x-data>
    
    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-[2rem] shadow-sm border border-slate-100 sticky top-20 z-30">
        <div class="flex items-center gap-4">
            <button wire:click="previousMonth" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <div class="text-center">
                <h2 class="text-lg font-black text-slate-800">{{ $currentDate->translatedFormat('F Y') }}</h2>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Periode Dinas</p>
            </div>
            <button wire:click="nextMonth" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="filterPoli" class="w-full md:w-64 rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                <option value="">Semua Unit / Poli</option>
                @foreach($polis as $poli)
                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Roster Grid -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden relative">
        <div class="overflow-x-auto custom-scrollbar pb-4">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr>
                        <th class="sticky left-0 z-20 bg-white p-4 text-left border-b border-r border-slate-100 min-w-[200px] shadow-[4px_0_10px_-5px_rgba(0,0,0,0.05)]">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Personil Medis</span>
                        </th>
                        @for($i = 1; $i <= $daysInMonth; $i++)
                            @php 
                                $date = \Carbon\Carbon::createFromDate($tahun, $bulan, $i);
                                $isWeekend = $date->isWeekend();
                                $isToday = $date->isToday();
                            @endphp
                            <th class="p-2 border-b border-slate-100 text-center min-w-[50px] {{ $isWeekend ? 'bg-slate-50' : 'bg-white' }} {{ $isToday ? 'bg-emerald-50' : '' }}">
                                <span class="block text-[10px] font-bold uppercase {{ $isWeekend ? 'text-rose-400' : 'text-slate-400' }}">{{ $date->translatedFormat('D') }}</span>
                                <span class="block text-lg font-black {{ $isToday ? 'text-emerald-600' : 'text-slate-700' }}">{{ $i }}</span>
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $pegawai)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="sticky left-0 z-10 bg-white group-hover:bg-slate-50 p-3 border-b border-r border-slate-100 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.05)]">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 overflow-hidden">
                                    {{ substr($pegawai->user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 text-xs truncate max-w-[120px]">{{ $pegawai->user->name }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase font-bold truncate">{{ $pegawai->poli->nama_poli ?? 'Umum' }}</p>
                                </div>
                            </div>
                        </td>
                        @for($i = 1; $i <= $daysInMonth; $i++)
                            @php 
                                $dateStr = \Carbon\Carbon::createFromDate($tahun, $bulan, $i)->format('Y-m-d');
                                $jadwal = $jadwalMap[$pegawai->id . '-' . $dateStr][0] ?? null;
                                $bgColor = 'bg-white';
                                $textColor = 'text-slate-300';
                                $label = '-';

                                if ($jadwal) {
                                    if ($jadwal->status_kehadiran != 'Hadir') {
                                        $bgColor = 'bg-rose-100';
                                        $textColor = 'text-rose-600';
                                        $label = substr($jadwal->status_kehadiran, 0, 1); // C, I, S
                                    } elseif ($jadwal->shift) {
                                        $bgColor = 'bg-emerald-100';
                                        $textColor = 'text-emerald-700';
                                        $label = substr($jadwal->shift->nama_shift, 0, 1); // P, S, M
                                    }
                                }
                            @endphp
                            <td class="p-1 border-b border-slate-100 text-center cursor-pointer hover:bg-slate-100 transition-colors" 
                                wire:click="editCell({{ $pegawai->id }}, '{{ $dateStr }}')">
                                <div class="w-8 h-8 mx-auto rounded-lg flex items-center justify-center text-xs font-black {{ $bgColor }} {{ $textColor }}">
                                    {{ $label }}
                                </div>
                            </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Floating Editor Panel -->
    @if($isEditorOpen)
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] p-6 lg:px-12 animate-fade-in-up">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8 items-start lg:items-center">
            
            <!-- Info -->
            <div class="flex items-center gap-4 min-w-[250px]">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-xl font-black text-slate-400">
                    {{ \Carbon\Carbon::parse($selectedDate)->format('d') }}
                </div>
                <div>
                    <h4 class="font-black text-slate-800">{{ $selectedPegawai->user->name ?? '-' }}</h4>
                    <p class="text-xs text-slate-500 font-bold uppercase">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <!-- Form -->
            <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4 w-full">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Status</label>
                    <select wire:model="status_kehadiran" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        <option value="Hadir">Hadir (Dinas)</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Libur">Libur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Shift Jaga</label>
                    <select wire:model="shift_id" class="w-full rounded-xl border-slate-200 text-sm font-bold" {{ $status_kehadiran != 'Hadir' ? 'disabled' : '' }}>
                        <option value="">-- Pilih Shift --</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->nama_shift }} ({{ \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i') }}-{{ \Carbon\Carbon::parse($shift->jam_keluar)->format('H:i') }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Kuota Online</label>
                    <input wire:model="kuota_online" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Kuota Offline</label>
                    <input wire:model="kuota_offline" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
                @if($selectedJadwal)
                <button wire:click="delete" class="p-3 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus Jadwal">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
                @endif
                <button wire:click="closeEditor" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50">Batal</button>
                <button wire:click="save" class="px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700 transition-colors">Simpan</button>
            </div>
        </div>
    </div>
    @endif
</div>
