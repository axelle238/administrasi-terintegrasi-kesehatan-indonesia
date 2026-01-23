<div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-6">Statistik Kunjungan (7 Hari Terakhir)</h3>
    
    <div class="flex items-end justify-between h-48 gap-2">
        @foreach($chartData as $data)
            <div class="flex flex-col items-center flex-1 h-full justify-end group">
                <div class="w-full bg-teal-100 rounded-t-md relative hover:bg-teal-200 transition-all duration-300 group-hover:shadow-lg" 
                     style="height: {{ ($data['count'] / $maxCount) * 100 }}%;">
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                        {{ $data['count'] }} Pasien
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-2 text-center font-medium">{{ $data['day'] }}<br><span class="text-xxs text-gray-400">{{ $data['date'] }}</span></div>
            </div>
        @endforeach
    </div>
</div>