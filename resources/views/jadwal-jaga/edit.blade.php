<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Jadwal Jaga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('jadwal-jaga.update', $jadwalJaga->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Jaga')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', $jadwalJaga->tanggal)" required />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pegawai_id" :value="__('Pegawai')" />
                                <select id="pegawai_id" name="pegawai_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ $jadwalJaga->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->user->name }} - {{ $pegawai->jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pegawai_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="shift_id" :value="__('Shift')" />
                                <select id="shift_id" name="shift_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ $jadwalJaga->shift_id == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->nama_shift }} ({{ $shift->jam_mulai }} - {{ $shift->jam_selesai }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('shift_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_kehadiran" :value="__('Status Kehadiran')" />
                                <select id="status_kehadiran" name="status_kehadiran" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Belum Hadir" {{ $jadwalJaga->status_kehadiran == 'Belum Hadir' ? 'selected' : '' }}>Belum Hadir</option>
                                    <option value="Hadir" {{ $jadwalJaga->status_kehadiran == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ $jadwalJaga->status_kehadiran == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ $jadwalJaga->status_kehadiran == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="Alpha" {{ $jadwalJaga->status_kehadiran == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jadwal-jaga.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
