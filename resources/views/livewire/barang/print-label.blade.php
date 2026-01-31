<div class="max-w-3xl mx-auto bg-white p-8 shadow-lg rounded-xl print:shadow-none print:p-0">
    
    <div class="no-print mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Pratinjau Label Aset</h1>
        <button onclick="window.print()" class="bg-teal-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-teal-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Cetak Label
        </button>
    </div>

    <!-- Label Container -->
    <div class="border-2 border-gray-800 rounded-lg w-[10cm] h-[5cm] mx-auto relative overflow-hidden flex flex-col print:border-4">
        <!-- Header -->
        <div class="bg-gray-800 text-white p-2 text-center flex items-center justify-center gap-3">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
            </svg>
            <div class="leading-tight">
                <h2 class="text-xs font-bold tracking-widest uppercase text-gray-300">Milik Pemerintah</h2>
                <h1 class="text-sm font-black uppercase tracking-wide">Puskesmas Jagakarsa</h1>
            </div>
        </div>

        <!-- Body -->
        <div class="flex-1 p-4 flex flex-row items-center justify-between gap-4">
            <div class="flex-1 text-left">
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5">Kode Inventaris</p>
                <p class="text-2xl font-mono font-black text-gray-900 tracking-tighter mb-2">{{ $barang->kode_barang }}</p>
                
                <h3 class="text-sm font-bold text-gray-800 leading-tight mb-1 line-clamp-2">{{ $barang->nama_barang }}</h3>
                <p class="text-[10px] text-gray-600 font-medium">{{ $barang->merk ?? '-' }} • {{ $barang->tanggal_pengadaan ? \Carbon\Carbon::parse($barang->tanggal_pengadaan)->year : '' }}</p>
                
                @if($barang->detailMedis && $barang->detailMedis->kalibrasi_selanjutnya)
                    <div class="mt-2 bg-black/5 rounded px-2 py-1 inline-block">
                        <p class="text-[8px] font-bold uppercase">Next Kalibrasi:</p>
                        <p class="text-[10px] font-mono font-black">{{ \Carbon\Carbon::parse($barang->detailMedis->kalibrasi_selanjutnya)->format('d M Y') }}</p>
                    </div>
                @endif
            </div>
            
            <div id="qrcode-main" class="bg-white p-1 rounded border border-gray-200"></div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 p-1.5 flex justify-between items-center text-[9px] font-mono text-gray-500 border-t border-gray-200">
            <span class="truncate max-w-[60%]">LOC: {{ strtoupper($barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan ?? 'GUDANG') }}</span>
            <span>SATRIA v2.0</span>
        </div>
    </div>

    <!-- Small Labels Preview (Grid) -->
    <div class="no-print mt-12 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pratinjau QR Code</h3>
        <p class="text-sm text-gray-500 mb-4">QR Code berisi tautan langsung ke halaman detail aset.</p>
    </div>

    <!-- QR Generation Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Main Label QR
        new QRCode(document.getElementById("qrcode-main"), {
            text: "{{ route('barang.show', $barang->id) }}",
            width: 80,
            height: 80,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.M
        });
        
        // Small Label QR
        new QRCode(document.getElementById("qrcode-small"), {
            text: "{{ route('barang.show', $barang->id) }}",
            width: 64,
            height: 64,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.L
        });
    </script>
</div>
