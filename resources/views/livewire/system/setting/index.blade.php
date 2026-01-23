<div class="max-w-4xl mx-auto">
    <form wire:submit="save">
        <div class="space-y-6">
            @foreach($groups as $groupName => $settings)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900 capitalize">{{ $groupName }} Settings</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($settings as $setting)
                            <div>
                                <x-input-label :for="$setting->key" :value="$setting->label" />
                                
                                @if($setting->type == 'textarea')
                                    <textarea wire:model="settings_data.{{ $setting->key }}" id="{{ $setting->key }}" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                                @else
                                    <x-text-input wire:model="settings_data.{{ $setting->key }}" id="{{ $setting->key }}" class="block mt-1 w-full" type="text" />
                                @endif
                                
                                <p class="text-xs text-gray-500 mt-1">Key: {{ $setting->key }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end">
            <x-primary-button wire:loading.attr="disabled">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</div>