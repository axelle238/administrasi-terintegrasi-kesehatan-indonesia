<div class="space-y-6 animate-fade-in">
    <!-- Header Controls -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <h2 class="text-lg font-black text-slate-800">Jadwal {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</h2>
        <div class="flex gap-2">
            <select wire:model.live="bulan" class="rounded-xl border-slate-200 text-sm font-bold">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahun" class="rounded-xl border-slate-200 text-sm font-bold">
                @foreach(range(now()->year, now()->year+1) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Spreadsheet Matrix -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full border-collapse text-xs">
                <thead>
                    <tr>
                        <th class="p-4 bg-slate-50 text-left font-bold text-slate-500 sticky left-0 z-10 w-48 border-b border-slate-100">Pegawai</th>
                        @for($d=1; $d<=$daysInMonth; $d++)
                            @php 
                                $date = \Carbon\Carbon::createFromDate($tahun, $bulan, $d);
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <th class="p-2 border-b border-slate-100 min-w-[40px] text-center {{ $isWeekend ? 'bg-red-50 text-red-500' : 'bg-slate-50 text-slate-500' }}">
                                <span class="block font-black">{{ $d }}</span>
                                <span class="block text-[9px] uppercase">{{ $date->translatedFormat('D') }}</span>
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $pegawai)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 border-b border-slate-50 sticky left-0 bg-white z-10 font-bold text-slate-700 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.05)]">
                            {{ $pegawai->user->name }}
                        </td>
                        @for($d=1; $d<=$daysInMonth; $d++)
                            @php 
                                $dateStr = \Carbon\Carbon::createFromDate($tahun, $bulan, $d)->format('Y-m-d');
                                $key = $pegawai->id . '-' . $dateStr;
                                $jadwal = $jadwalMap[$key][0] ?? null;
                                $shift = $jadwal ? $shifts->find($jadwal->shift_id) : null;
                            @endphp
                            <td class="p-1 border-b border-slate-50 text-center border-l border-dashed border-slate-100">
                                <button wire:click="openModal('{{ $dateStr }}', {{ $pegawai->id }})" 
                                    class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-[10px] transition-all hover:scale-110 shadow-sm"
                                    style="background-color: {{ $shift->color ?? '#f1f5f9' }}; color: {{ $shift ? 'white' : '#94a3b8' }}">
                                    {{ $shift ? substr($shift->nama_shift, 0, 1) : '-' }}
                                </button>
                            </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Input Shift -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-[2rem] p-6 w-full max-w-sm shadow-2xl animate-fade-in-up">
            <h3 class="font-black text-slate-800 text-lg mb-4">Set Jadwal</h3>
            <p class="text-sm text-slate-500 mb-6">Pilih shift untuk tanggal <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span></p>
            
            <div class="grid grid-cols-2 gap-3 mb-6">
                <button wire:click="$set('inputShiftId', null)" class="p-3 rounded-xl border-2 {{ is_null($inputShiftId) ? 'border-slate-800 bg-slate-50 text-slate-800' : 'border-slate-100 text-slate-400' }} font-bold text-sm transition-all">
                    Libur / Off
                </button>
                @foreach($shifts as $s)
                    <button wire:click="$set('inputShiftId', {{ $s->id }})" class="p-3 rounded-xl border-2 font-bold text-sm transition-all"
                        style="{{ $inputShiftId == $s->id ? 'border-color:'.$s->color.'; background-color:'.$s->color.'10; color:'.$s->color : 'border-color:#f1f5f9; color:#64748b' }}">
                        {{ $s->nama_shift }}
                        <span class="block text-[10px] font-mono mt-1 opacity-70">{{ \Carbon\Carbon::parse($s->jam_masuk)->format('H:i') }}</span>
                    </button>
                @endforeach
            </div>

            <div class="flex justify-end gap-3">
                <button wire:click="$set('isOpen', false)" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl">Batal</button>
                <button wire:click="saveJadwal" class="px-6 py-2 bg-slate-800 text-white font-bold text-xs rounded-xl shadow-lg hover:bg-slate-700">Simpan</button>
            </div>
        </div>
    </div>
    @endif
</div>