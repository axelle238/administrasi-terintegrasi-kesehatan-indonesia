<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Peminjaman Barang Inventaris</h2>
            <p class="text-sm text-slate-500">Kelola peminjaman barang oleh pegawai atau unit lain.</p>
        </div>
        <button class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Peminjaman
        </button>
    </div>

    <!-- Empty State -->
    <div class="bg-white rounded-[2.5rem] p-12 text-center border-2 border-dashed border-slate-200">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Peminjaman Aktif</h3>
        <p class="text-slate-500 max-w-md mx-auto">Gunakan fitur ini untuk mencatat barang yang dipinjam sementara oleh staf atau ruangan lain.</p>
    </div>
</div>