<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight font-display tracking-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Update Info -->
            <div class="p-8 bg-white rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-8 bg-white rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-8 bg-white rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>