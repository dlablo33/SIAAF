<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
            {{ $empleado->nombre . ' ' . $empleado->a_materno . ' ' . $empleado->a_paterno }}
        </h2>
    </x-slot>
    <div class="mx-auto max-w-6xl gap-y-2">
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-950 sm:rounded-lg">
            <div class="border-b border-gray-200 bg-white p-6 dark:border-gray-900 dark:bg-gray-800">
                <div class="grid grid-cols-12 gap-6">
                    <!-- Contenedor Izquierdo -->
                    <div class="col-span-12 p-1 md:col-span-6">
                        <!-- Imagen de Perfil -->
                        <div class="items-center-top mb-6 flex justify-center">
                            <img class="w-100 shadow-blue-gray-900/50 h-96 rounded-lg object-cover object-center shadow-xl"
                                src="{{ asset('resources/images/pp/placeholder_male.jpg') }}" alt="Imagen de Perfil" />
                        </div>

                        <!-- Subir foto de ¨Perfil -->
                        <div class="mb-6 flex flex-col items-center">
                            <button class="mt-1 rounded-full border bg-blue-400 px-4 py-2 text-white dark:bg-blue-950">Subir Imagen</button>
                        </div>

                        <!-- Cambio de contraseña-->
                        <div class="mb-4 flex flex-col items-center">
                            <label for="password_old" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Contraseña Actual</label>
                            <input id="password_old" name="password_old" type="password" required value="{{ old('password_old') }}" placeholder="********"
                                class="w-6/12 rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                        </div>

                        <div class="mb-4 flex flex-col items-center">
                            <label for="password_new" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Nueva Contraseña</label>
                            <input id="password_new" name="password_new" type="password" required value="{{ old('password_new') }}" placeholder="********"
                                class="w-6/12 rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                        </div>

                        <!-- Guarda Contraseña Nueva -->
                        <div class="mb-6 flex flex-col items-center">
                            <button onclick=updatePassword() class="mt-1 rounded-full border bg-blue-400 px-4 py-2 text-white dark:bg-blue-950">Guardar
                                Contraseña</button>
                        </div>
                    </div>

                    <!-- Contenedor Derecho -->
                    <div class="col-span-12 [-ms-overflow-style:none] [scrollbar-width:none] md:col-span-6 md:h-[750px] md:overflow-y-auto [&::-webkit-scrollbar]:hidden">
                        <!-- Nombres -->
                        <div class="mb-6">
                            <label for="nombre" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Nombres</label>
                            <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                {{ $empleado->nombre }}
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="a_paterno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Apellido Paterno</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->a_paterno }}
                                </div>
                            </div>
                            <div>
                                <label for="a_materno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Apellido Materno</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->a_materno }}
                                </div>
                            </div>
                        </div>

                        <!-- CURP -->
                        <div class="mb-6">
                            <label for="curp" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">CURP</label>
                            <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                {{ $empleado->curp }}
                            </div>
                        </div>

                        <!-- RFC y NSS -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="rfc" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">RFC</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->rfc }}
                                </div>
                            </div>
                            <div>
                                <label for="nss" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">NSS</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->nss }}
                                </div>
                            </div>
                        </div>

                        <!-- Fecha Nacimiento y Genero -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="rfc" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de Nacimiento</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->fecha_nacimiento }}
                                </div>
                            </div>
                            <div>
                                <label for="nss" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Genero</label>
                                <input id="nss" name="nss" type="text" required value="{{ old('nss') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Correo Interno y Personal -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="correo_interno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Correo Interno</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->correo_interno }}
                                </div>
                            </div>
                            <div>
                                <label for="correo_personal" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Correo Personal</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->correo_personal }}
                                </div>
                            </div>
                        </div>

                        <!-- Domicilio y Telefono -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="domicilio" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Domicilio</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->id_domicilio }}
                                </div>
                            </div>
                            <div>
                                <label for="telefono" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Telefono</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->telefono }}
                                </div>
                            </div>
                        </div>

                        <!-- Contacto y Contacto Telefono -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="contacto" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Contacto</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->contacto }}
                                </div>
                            </div>
                            <div>
                                <label for="contecto_telefono" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Telefono</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->contacto_telefono }}
                                </div>
                            </div>
                        </div>

                        <!-- Divider Informacion de la Empresa -->
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-4 text-sm font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-300">Informacion de la Empresa</span>
                            </div>
                        </div>

                        <!-- Empresa y Puesto -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="empresa" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Empresa</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->id_empresa }}
                                </div>
                            </div>
                            <div>
                                <label for="puesto" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Puesto</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->id_puesto }}
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de ingreso y salida -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="fecha_ingreso" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de Ingreso</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                    {{ $empleado->fecha_ingreso }}
                                </div>
                            </div>
                            <div>
                                <label for="puesto" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de Baja</label>
                                <div class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">

                                </div>
                            </div>
                        </div>

                        <!-- Divider Esquema de Pago -->
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-4 text-sm font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-300">Esquema de Pago</span>
                            </div>
                        </div>

                        <!-- Sueldo y Tipo -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div class="col-start-1 md:col-span-2 md:col-start-2">
                                <label for="tipo_pago" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Tipo de Pago</label>
                                <input id="tipo_pago" name="tipo_pago" type="text" required value="{{ old('tipo_pago') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Sueldo y 7mo dia -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="sueldo" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Sueldo</label>
                                <input id="sueldo" name="sueldo" type="text" required value="{{ old('sueldo') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                            <div>
                                <label for="septimo_dia" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Septimo Dia</label>
                                <input id="septimo_dia" name="septimo_dia" type="text" required value="{{ old('septimo_dia') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Bonos Puntualidad y Asistencia -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="bono_puntualidad" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de Puntualidad</label>
                                <input id="bono_puntualidad" name="bono_puntualidad" type="text" required value="{{ old('bono_puntualidad') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                            <div>
                                <label for="bono_asistencia" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de Asistencia</label>
                                <input id="bono_asistencia" name="bono_asistencia" type="text" required value="{{ old('bono_asistencia') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Bonos Despensa y Bono Mensual/Extra -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="bono_despensa" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de Despensa</label>
                                <input id="bono_despensa" name="bono_despensa" type="text" required value="{{ old('bono_despensa') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                            <div>
                                <label for="bono_extra" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono Extra</label>
                                <input id="bono_extra" name="bono_extra" type="text" required value="{{ old('bono_extra') }}"
                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Divider Documentos -->
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-4 text-sm font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-300">Documentos</span>
                            </div>
                        </div>

                        <!-- INE y CURP -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="ine" class="block text-sm font-bold text-gray-800 dark:text-gray-300">INE</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                            <div>
                                <label for="curp" class="block text-sm font-bold text-gray-800 dark:text-gray-300">CURP</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                        </div>

                        <!-- Comprobante de Domicilio y Constancia de Situacion Fiscal -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="domicilio" class="block text-sm font-bold text-gray-800 dark:text-gray-300">Comprobante de Domicilio</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                            <div>
                                <label for="constancia" class="block text-sm font-bold text-gray-800 dark:text-gray-300">Constancia de Situacion
                                    Fiscal</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                        </div>

                        <!-- NSS y Acta de Nacimiento -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="nss" class="block text-sm font-bold text-gray-800 dark:text-gray-300">Numero de Seguro Social</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                            <div>
                                <label for="acta_nacimiento" class="block text-sm font-bold text-gray-800 dark:text-gray-300">Acta de Nacimineto</label>
                                <input type="file"
                                    class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePassword() {
            const old_password = document.getElementById('password_old').value;
            const new_password = document.getElementById('password_new').value;
            const data = new FormData();
            data.append('password_old', old_password);
            data.append('password_new', new_password);

            axios.post('updatePassword', data, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {

        }).catch(error => {

        })
        }
    </script>

</x-app-layout>
