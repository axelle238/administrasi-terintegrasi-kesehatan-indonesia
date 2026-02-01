<div class="space-y-6 animate-fade-in">
    <!-- Header Tools -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Payroll Periode</h2>
            <div class="flex gap-2 mt-2">
                <select wire:model.live="bulanFilter" class="rounded-xl border-slate-200 text-sm font-bold">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
                <select wire:model.live="tahunFilter" class="rounded-xl border-slate-200 text-sm font-bold">
                    @foreach(range(2024, 2030) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <button wire:click="generatePayroll" wire:confirm="Generate slip gaji untuk seluruh pegawai aktif?" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            Generate Payroll
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold border border-emerald-100">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                <tr>
                    <th class="p-6">Pegawai</th>
                    <th class="p-6 text-right">Gaji Pokok</th>
                    <th class="p-6 text-right">Tunjangan</th>
                    <th class="p-6 text-right">Potongan</th>
                    <th class="p-6 text-right">Take Home Pay</th>
                    <th class="p-6 text-center">Status</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($gajis as $gaji)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-6 font-bold text-slate-800">{{ $gaji->user->name }}</td>
                    <td class="p-6 text-right font-mono text-slate-600">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="p-6 text-right font-mono text-emerald-600">+ {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</td>
                    <td class="p-6 text-right font-mono text-red-600">- {{ number_format($gaji->total_potongan, 0, ',', '.') }}</td>
                    <td class="p-6 text-right font-mono font-black text-slate-800 text-lg">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                    <td class="p-6 text-center">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $gaji->status == 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $gaji->status }}
                        </span>
                    </td>
                    <td class="p-6 text-right">
                        <button class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase">Detail</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-12 text-center text-slate-400 italic">Belum ada data gaji bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>