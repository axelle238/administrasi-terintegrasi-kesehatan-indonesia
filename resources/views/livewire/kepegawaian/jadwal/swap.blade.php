<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20" x-data="{ activeTab: 'form' }">
    
    <!-- Tab Nav -->
    <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl">
        <button @click="activeTab = 'form'" :class="activeTab === 'form' ? 'bg-white shadow text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all">
            Ajukan Pertukaran
        </button>
        <button @click="activeTab = 'requests'" :class="activeTab === 'requests' ? 'bg-white shadow text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all flex items-center justify-center gap-2">
            Permintaan Masuk
            @if($incomingRequests->count() > 0)
                <span class="bg-red-500 text-white text-[10px] px-2 rounded-full">{{ $incomingRequests->count() }}</span>
            @endif
        </button>
        <button @click="activeTab = 'history'" :class="activeTab === 'history' ? 'bg-white shadow text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all">
            Riwayat Saya
        </button>
    </div>

    <!-- TAB 1: FORM PENGAJUAN -->
    <div x-show="activeTab === 'form'" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 animate-fade-in">
        <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-2">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
            </div>
            Formulir Tukar Dinas
        </h3>

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Sisi Saya -->
                <div class="space-y-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest">Jadwal Saya</h4>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Tanggal yang Ingin Ditukar</label>
                        <select wire:model="myScheduleId" class="w-full rounded-xl border-slate-200 focus:ring-blue-500">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach($mySchedules as $s)
                                <option value="{{ $s->id }}">{{ \Carbon\Carbon::parse($s->tanggal)->translatedFormat('l, d F Y') }} ({{ $s->shift->nama_shift ?? 'Shift' }})</option>
                            @endforeach
                        </select>
                        @error('myScheduleId') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Sisi Rekan -->
                <div class="space-y-4 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                    <h4 class="text-sm font-bold text-blue-500 uppercase tracking-widest">Target Rekan</h4>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Rekan Kerja</label>
                        <select wire:model.live="targetUserId" class="w-full rounded-xl border-slate-200 focus:ring-blue-500">
                            <option value="">-- Cari Rekan --</option>
                            @foreach($potentialTargets as $t)
                                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->pegawai->jabatan ?? '-' }})</option>
                            @endforeach
                        </select>
                        @error('targetUserId') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    @if($targetUserId)
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Jadwal Rekan</label>
                        <select wire:model="targetScheduleId" class="w-full rounded-xl border-slate-200 focus:ring-blue-500">
                            <option value="">-- Pilih Tanggal Pengganti --</option>
                            @foreach($targetSchedules as $ts)
                                <option value="{{ $ts->id }}">{{ \Carbon\Carbon::parse($ts->tanggal)->translatedFormat('l, d F Y') }} ({{ $ts->shift->nama_shift ?? 'Shift' }})</option>
                            @endforeach
                        </select>
                        @error('targetScheduleId') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Pertukaran</label>
                <textarea wire:model="alasan" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-blue-500" placeholder="Contoh: Ada acara keluarga mendadak..."></textarea>
                @error('alasan') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: INCOMING REQUESTS -->
    <div x-show="activeTab === 'requests'" style="display: none;" class="space-y-4 animate-fade-in">
        @forelse($incomingRequests as $req)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-l-4 border-l-orange-400 border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-orange-100 text-orange-700 text-[10px] font-black px-2 py-1 rounded-lg uppercase">Permintaan Masuk</span>
                    <span class="text-xs text-slate-400 font-bold">{{ $req->created_at->diffForHumans() }}</span>
                </div>
                <h4 class="text-lg font-bold text-slate-800">
                    {{ $req->pemohon->name }} <span class="text-slate-400 font-normal">ingin menukar jadwal.</span>
                </h4>
                <div class="flex items-center gap-4 mt-3 text-sm">
                    <div class="bg-red-50 text-red-600 px-3 py-1 rounded-lg font-bold">
                        <span class="text-[10px] text-red-400 block uppercase">Jadwal Dia</span>
                        {{ \Carbon\Carbon::parse($req->jadwalPemohon->tanggal)->format('d M') }}
                    </div>
                    <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    <div class="bg-green-50 text-green-600 px-3 py-1 rounded-lg font-bold">
                        <span class="text-[10px] text-green-400 block uppercase">Jadwal Anda</span>
                        {{ \Carbon\Carbon::parse($req->jadwalPengganti->tanggal)->format('d M') }}
                    </div>
                </div>
                <p class="text-sm text-slate-500 mt-3 italic">"{{ $req->alasan }}"</p>
            </div>
            <div class="flex gap-2">
                <button wire:click="rejectRequest({{ $req->id }})" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-red-100 hover:text-red-600 transition">Tolak</button>
                <button wire:click="approveRequest({{ $req->id }})" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-md transition">Terima & Lanjut ke Admin</button>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-[2.5rem] border border-slate-100">
            <p class="text-slate-400 font-bold">Tidak ada permintaan masuk saat ini.</p>
        </div>
        @endforelse
    </div>

    <!-- TAB 3: RIWAYAT -->
    <div x-show="activeTab === 'history'" style="display: none;" class="space-y-4 animate-fade-in">
        @forelse($myRequests as $req)
        <div class="bg-white p-4 rounded-2xl border border-slate-100 flex justify-between items-center">
            <div>
                <p class="text-sm font-bold text-slate-800">Tukar dengan {{ $req->pengganti->name }}</p>
                <p class="text-xs text-slate-500">Tanggal: {{ \Carbon\Carbon::parse($req->jadwalPemohon->tanggal)->format('d M') }} &harr; {{ \Carbon\Carbon::parse($req->jadwalPengganti->tanggal)->format('d M') }}</p>
            </div>
            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $req->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : ($req->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                {{ $req->status }}
            </span>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-[2.5rem] border border-slate-100">
            <p class="text-slate-400 font-bold">Belum ada riwayat pengajuan.</p>
        </div>
        @endforelse
    </div>
</div>
