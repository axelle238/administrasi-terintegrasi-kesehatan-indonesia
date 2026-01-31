<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Status Integrasi Eksternal</h2>
            <p class="text-sm text-slate-500">Monitoring koneksi API ke layanan pihak ketiga (BPJS, SatuSehat, WhatsApp).</p>
        </div>
        <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            Cek Koneksi
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- BPJS VClaim -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
                <h3 class="font-bold text-slate-700">BPJS V-Claim</h3>
            </div>
            <p class="text-xs text-slate-400 mb-6">Layanan bridging klaim dan SEP.</p>
            <div class="flex justify-between items-end">
                <span class="text-2xl font-black text-slate-800">Online</span>
                <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded">98ms</span>
            </div>
        </div>

        <!-- SatuSehat -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></div>
                <h3 class="font-bold text-slate-700">SatuSehat Kemenkes</h3>
            </div>
            <p class="text-xs text-slate-400 mb-6">Pertukaran data rekam medis elektronik.</p>
            <div class="flex justify-between items-end">
                <span class="text-2xl font-black text-slate-800">Online</span>
                <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded">120ms</span>
            </div>
        </div>

        <!-- WhatsApp Gateway -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M16.75 13.96c.25.13.36.43.26.7-.1.27-.29.53-.53.79-.24.26-.6.54-1.07.61-.47.07-1.13.07-2.32-1.12-1.19-1.19-1.19-1.85-1.12-2.32.07-.47.35-.83.61-1.07.26-.24.52-.43.79-.53.27-.1.57.01.7.26.19.38.63 1.37.63 1.37s.05.16-.07.38c-.12.22-.26.39-.53.56-.27.17-.37.37-.16.73.21.36.93 1.54 2.02 2.63 1.09 1.09 2.27 1.81 2.63 2.02.36.21.56.11.73-.16.17-.27.34-.41.56-.53.22-.12.38-.07.38-.07s.99.44 1.37.63zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                <h3 class="font-bold text-slate-700">WhatsApp Gateway</h3>
            </div>
            <p class="text-xs text-slate-400 mb-6">Notifikasi antrean & pengingat kontrol.</p>
            <div class="flex justify-between items-end">
                <span class="text-2xl font-black text-slate-800">Connected</span>
                <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-1 rounded">Device Ready</span>
            </div>
        </div>
    </div>
</div>
