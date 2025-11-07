<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#d3d8db] to-[#a0b4cb] px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl border border-[#d3d8db] transform transition-all hover:scale-[1.01] duration-300">
            <!-- Encabezado con logo y título -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="bg-[#01163d] p-4 rounded-full shadow-lg">
                        <img src="{{ asset('img/aaf.png') }}" 
                             alt="Logo AAF" 
                             class="w-24 h-auto object-contain" />
                    </div>
                </div>
                <h2 class="text-xl font-bold text-[#01163d] uppercase tracking-wider mt-1">ACCIÓN ADMINISTRATIVA Y FISCAL</h2>
                <p class="text-sm text-[#00404a] mt-2">Soluciones integrales para su negocio</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Campo Usuario -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[#00404a] mb-1">Usuario</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#c1611a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 px-4 py-3 border border-[#d3d8db] rounded-lg focus:ring-2 focus:ring-[#c1611a] focus:border-[#c1611a] outline-none transition duration-200 placeholder-gray-400" 
                               placeholder="usuario@empresa.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[#00404a] mb-1">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#c1611a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full pl-10 px-4 py-3 border border-[#d3d8db] rounded-lg focus:ring-2 focus:ring-[#c1611a] focus:border-[#c1611a] outline-none transition duration-200 placeholder-gray-400" 
                               placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Recordar y Olvidé contraseña -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 text-[#c1611a] focus:ring-[#c1611a] border-gray-300 rounded" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-[#00404a]">Recordar sesión</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#c1611a] hover:text-[#01163d] hover:underline transition duration-150">
                            ¿Olvidó la contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón de Ingreso - Estilo mejorado -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-[#c1611a] to-[#01163d] text-white py-3 px-4 rounded-lg font-medium text-sm uppercase tracking-wider hover:opacity-90 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Ingresar
                    </button>
                </div>
            </form>
            
            <!-- Mensaje de servicios -->
            <div class="mt-6 text-center">
                <p class="text-xs text-[#00404a]">
                    Ofrecemos servicios shelter: administrativos, contables, fiscales, nóminas e import-export
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>