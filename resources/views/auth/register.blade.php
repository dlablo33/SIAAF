<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#eaf1f9] px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/aaf.png') }}"
                     alt="Logo AAF"
                     class="w-40 h-auto object-contain" />
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-sm text-gray-600 mb-1">Nombre</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none bg-blue-50" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm text-gray-600 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none bg-blue-50" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-sm text-gray-600 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none bg-blue-50" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-gray-600 mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-400 focus:outline-none bg-blue-50" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between">
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                        ¿Ya estás registrado?
                    </a>

                    <button type="submit" class="login-button-special">
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
