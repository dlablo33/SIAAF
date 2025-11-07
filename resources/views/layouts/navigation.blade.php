<nav x-data="{ open: false, showNotifications: false, showTasks: false }" class="bg-[#01163d] border-b border-[#00404a] shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end h-16 items-center space-x-6 text-white">
            <!-- Notificaciones -->
            <div class="relative" @click.away="showNotifications = false">
                <button @click="showNotifications = !showNotifications" class="relative focus:outline-none hover:text-[#c1611a] transition">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#c1611a] rounded-full animate-ping"></span>
                </button>
                <div x-show="showNotifications" x-transition class="absolute right-0 mt-2 w-64 bg-[#00404a] text-[#d3d8db] rounded-lg shadow-xl z-50 p-4">
                    <p class="font-bold mb-2">🔔 Notificaciones</p>
                    <ul class="space-y-2 text-sm">
                        <li class="border-b border-[#a0b4c] pb-1">📢 Nueva tarea asignada</li>
                        <li class="border-b border-[#a0b4c] pb-1">📁 Solicitud actualizada</li>
                        <li>✉️ Mensaje del equipo legal</li>
                    </ul>
                </div>
            </div>

            <!-- Lista de pendientes -->
            <div class="relative" @click.away="showTasks = false">
                <button @click="showTasks = !showTasks" class="relative focus:outline-none hover:text-[#c1611a] transition">
                    <i class="fas fa-list-check text-xl"></i>
                </button>
                <div x-show="showTasks" x-transition class="absolute right-0 mt-2 w-64 bg-[#00404a] text-[#d3d8db] rounded-lg shadow-xl z-50 p-4">
                    <p class="font-bold mb-2">📝 Lista de Pendientes</p>
                    <ul class="space-y-2 text-sm">
                        <li><input type="checkbox" checked class="mr-2 accent-[#c1611a]">Revisar contratos</li>
                        <li><input type="checkbox" class="mr-2 accent-[#c1611a]">Subir facturas abril</li>
                        <li><input type="checkbox" class="mr-2 accent-[#c1611a]">Confirmar pedidos</li>
                    </ul>
                </div>
            </div>

            <!-- Usuario -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[#d3d8db] bg-[#00404a] hover:text-white hover:bg-[#c1611a] transition duration-200">
                        <div>{{ Auth::user()->name }}</div>
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
