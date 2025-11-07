<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#01163d] dark:text-[#d3d8db] leading-tight tracking-wide">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#00404a] dark:bg-[#00404a] min-h-screen">
        <div class="w-full px-4 lg:px-8 space-y-8"> 
            
            <!-- Sección: Información del perfil -->
            <div class="p-6 sm:p-8 bg-white/80 dark:bg-[#00404a] border border-[#00404a] shadow-xl rounded-2xl transition-all w-full">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Sección: Cambiar contraseña -->
            <div class="p-6 sm:p-8 bg-white/80 dark:bg-[#00404a] border border-[#00404a] shadow-xl rounded-2xl transition-all w-full">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Sección: Eliminar usuario -->
            <div class="p-6 sm:p-8 bg-white/80 dark:bg-[#00404a] border border-[#00404a] shadow-xl rounded-2xl transition-all w-full">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
