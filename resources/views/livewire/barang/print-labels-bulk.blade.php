<div class="max-w-7xl mx-auto bg-white p-8 print:p-0">
    
    <div class="no-print mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Cetak Label Inventaris ({{ count($barangs) }} Item)</h1>
            <p class="text-gray-500 text-sm">Gunakan kertas A4 atau Sticker Paper untuk mencetak.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('barang.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50">
                Kembali
            </a>
            <button onclick="window.print()" class="bg-teal-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-teal-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Sekarang
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 print:grid-cols-2 print:gap-2">
        @foreach($barangs as $barang)
        <!-- Label Item -->
        <div class="border-2 border-gray-800 rounded-lg h-[5cm] relative overflow-hidden flex flex-col break-inside-avoid page-break-inside-avoid">
            <!-- Header -->
            <div class="bg-gray-800 text-white p-2 text-center flex items-center justify-center gap-3">
                <div class="leading-tight">
                    <h2 class="text-[10px] font-bold tracking-widest uppercase text-gray-300">Milik Pemerintah</h2>
                    <h1 class="text-xs font-black uppercase tracking-wide">Puskesmas Jagakarsa</h1>
                </div>
            </div>

            <!-- Body -->
            <div class="flex-1 p-3 flex items-center gap-4">
                <!-- QR Code Placeholder -->
                <div id="qrcode-{{ $barang->id }}" class="flex-shrink-0 bg-white p-1 border border-gray-100 rounded"></div>
                
                <div class="flex-1 text-left">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5">Kode Inventaris</p>
                    <p class="text-xl font-mono font-black text-gray-900 tracking-widest mb-2">{{ $barang->kode_barang }}</p>
                    
                    <h3 class="text-sm font-bold text-gray-800 leading-tight mb-0.5 line-clamp-2">{{ $barang->nama_barang }}</h3>
                    <p class="text-[10px] text-gray-600 font-medium">{{ $barang->merk ?? '-' }} • {{ $barang->tanggal_pengadaan ? \Carbon\Carbon::parse($barang->tanggal_pengadaan)->year : '-' }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 p-1.5 flex justify-between items-center text-[9px] font-mono text-gray-500 border-t border-gray-200">
                <span class="truncate max-w-[150px]">LOC: {{ strtoupper($barang->ruangan->nama_ruangan ?? ($barang->lokasi_penyimpanan ?? 'GUDANG')) }}</span>
                <span>SATRIA v2.0</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- QR Generation Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($barangs as $barang)
                new QRCode(document.getElementById("qrcode-{{ $barang->id }}"), {
                    text: "{{ route('barang.show', $barang->id) }}",
                    width: 80,
                    height: 80,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.M
                });
            @endforeach
        });
    </script>
</div>
