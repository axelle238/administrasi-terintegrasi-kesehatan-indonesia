<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h2 class="text-2xl font-black text-slate-800 mb-2">Tukar Jadwal Jaga</h2>
        <p class="text-slate-500 mb-8">Ajukan pertukaran shift dengan rekan kerja jika berhalangan hadir.</p>

        <!-- Wizard Steps (Only shown for creating new request) -->
        <div class="flex justify-between items-center mb-10 relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -z-10"></div>
            <div class="flex flex-col items-center gap-2 bg-white px-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $step >= 1 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">1</div>
                <span class="text-xs font-bold {{ $step >= 1 ? 'text-indigo-600' : 'text-slate-400' }}">Pilih Jadwalmu</span>
            </div>
            <div class="flex flex-col items-center gap-2 bg-white px-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $step >= 2 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">2</div>
                <span class="text-xs font-bold {{ $step >= 2 ? 'text-indigo-600' : 'text-slate-400' }}">Pilih Rekan</span>
            </div>
            <div class="flex flex-col items-center gap-2 bg-white px-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $step >= 3 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">3</div>
                <span class="text-xs font-bold {{ $step >= 3 ? 'text-indigo-600' : 'text-slate-400' }}">Pilih Target</span>
            </div>
            <div class="flex flex-col items-center gap-2 bg-white px-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $step >= 4 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">4</div>
                <span class="text-xs font-bold {{ $step >= 4 ? 'text-indigo-600' : 'text-slate-400' }}">Konfirmasi</span>
            </div>
        </div>

        <!-- Step 1: Select My Schedule -->
        @if($step == 1)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 animate-fade-in">
            @foreach($jadwalSaya as $j)
            <div wire:click="selectJadwalAsal({{ $j->id }})" class="p-6 border-2 border-dashed border-slate-200 rounded-3xl hover:border-indigo-500 hover:bg-indigo-50 cursor-pointer transition-all group">
                <p class="text-xs font-bold text-slate-400 uppercase mb-2">{{ \Carbon\Carbon::parse($j->tanggal)->format('l, d F Y') }}</p>
                <h3 class="text-xl font-black text-slate-800 group-hover:text-indigo-700">{{ $j->shift->nama_shift }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-1">{{ $j->shift->jam_mulai }} - {{ $j->shift->jam_selesai }}</p>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Step 2: Select Partner -->
        @if($step == 2)
        <div class="space-y-4 animate-fade-in">
            <input type="text" placeholder="Cari nama rekan..." class="w-full rounded-xl border-slate-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($users as $u)
                <div wire:click="selectPengganti({{ $u->id }})" class="flex items-center gap-4 p-4 border border-slate-100 rounded-2xl hover:shadow-md cursor-pointer transition-all">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600">{{ substr($u->name, 0, 1) }}</div>
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $u->name }}</h4>
                        <p class="text-xs text-slate-500">{{ $u->pegawai->jabatan ?? 'Staff' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Step 3: Select Target Schedule -->
        @if($step == 3)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 animate-fade-in">
            @forelse($jadwalTarget as $jt)
            <div wire:click="selectJadwalTujuan({{ $jt->id }})" class="p-6 border-2 border-dashed border-slate-200 rounded-3xl hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer transition-all group">
                <p class="text-xs font-bold text-slate-400 uppercase mb-2">{{ \Carbon\Carbon::parse($jt->tanggal)->format('l, d F Y') }}</p>
                <h3 class="text-xl font-black text-slate-800 group-hover:text-emerald-700">{{ $jt->shift->nama_shift }}</h3>
                <p class="text-sm font-medium text-slate-500 mt-1">{{ $jt->shift->jam_mulai }} - {{ $jt->shift->jam_selesai }}</p>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-slate-400">Rekan ini tidak memiliki jadwal mendatang yang tersedia.</div>
            @endforelse
        </div>
        @endif

        <!-- Step 4: Confirm -->
        @if($step == 4)
        <div class="max-w-xl mx-auto animate-fade-in">
            <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Penukaran</label>
            <textarea wire:model="alasan" class="w-full rounded-2xl border-slate-200 p-4 font-medium" rows="3" placeholder="Mengapa Anda ingin menukar jadwal ini?"></textarea>
            <button wire:click="submit" class="w-full mt-6 py-4 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-700 shadow-xl transition-transform hover:-translate-y-1">
                Kirim Permintaan Tukar
            </button>
        </div>
        @endif
    </div>

    <!-- History & Inbox -->
    <div class="space-y-6">
        <div class="flex gap-6 border-b border-slate-200 pb-1">
            <button wire:click="setTab('sent')" class="text-sm font-black uppercase tracking-widest pb-3 border-b-2 transition-colors {{ $activeTab == 'sent' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                Riwayat Pengajuan
            </button>
            <button wire:click="setTab('received')" class="text-sm font-black uppercase tracking-widest pb-3 border-b-2 transition-colors {{ $activeTab == 'received' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                Permintaan Masuk <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full ml-1">{{ count($receivedRequests->where('status', 'Menunggu Respon')) }}</span>
            </button>
        </div>

        @if($activeTab == 'sent')
            @foreach($sentRequests as $req)
            <div class="bg-white p-6 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden">
                <div class="absolute left-0 top-0 w-2 h-full {{ $req->status == 'Disetujui Admin' ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                
                <div class="flex-1 text-center md:text-left">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jadwal Asal</p>
                    <p class="font-black text-slate-800">{{ \Carbon\Carbon::parse($req->jadwalAsal->tanggal)->format('d M') }} ({{ $req->jadwalAsal->shift->nama_shift }})</p>
                </div>

                <div class="flex items-center gap-2 text-slate-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                </div>

                <div class="flex-1 text-center md:text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Ditukar Dengan</p>
                    <p class="font-black text-indigo-600">{{ $req->pengganti->name }}</p>
                    <p class="text-sm font-medium text-slate-600">{{ \Carbon\Carbon::parse($req->jadwalTujuan->tanggal)->format('d M') }} ({{ $req->jadwalTujuan->shift->nama_shift }})</p>
                </div>

                <div class="px-4 py-2 rounded-xl bg-slate-100 font-bold text-xs text-slate-600 uppercase">
                    {{ $req->status }}
                </div>
            </div>
            @endforeach
        @endif

        @if($activeTab == 'received')
            @forelse($receivedRequests as $req)
            <div class="bg-white p-6 rounded-3xl border border-slate-100 relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                            {{ substr($req->pemohon->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $req->pemohon->name }}</h4>
                            <p class="text-xs text-slate-500">Meminta tukar jadwal</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                        {{ $req->status == 'Menunggu Respon' ? 'bg-amber-100 text-amber-700' : ($req->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700') }}">
                        {{ $req->status }}
                    </span>
                </div>

                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                    <div class="flex-1 text-center border-r border-slate-200 pr-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Jadwal Dia</p>
                        <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($req->jadwalAsal->tanggal)->format('d M') }}</p>
                        <p class="text-xs text-slate-500">{{ $req->jadwalAsal->shift->nama_shift }}</p>
                    </div>
                    <div class="text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    </div>
                    <div class="flex-1 text-center border-l border-slate-200 pl-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Jadwal Anda</p>
                        <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($req->jadwalTujuan->tanggal)->format('d M') }}</p>
                        <p class="text-xs text-slate-500">{{ $req->jadwalTujuan->shift->nama_shift }}</p>
                    </div>
                </div>

                @if($req->status == 'Menunggu Respon')
                <div class="flex gap-3">
                    <button wire:click="approve({{ $req->id }})" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-500/20">Setujui</button>
                    <button wire:click="reject({{ $req->id }})" class="flex-1 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-red-50 hover:text-red-600 hover:border-red-200">Tolak</button>
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-slate-400 font-medium">Tidak ada permintaan masuk.</div>
            @endforelse
        @endif
    </div>
</div>
