<x-app-layout>
    <x-slot name="backButton">
        {{ route('rh.empleados.index') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
            Nuevo Empleado
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

                        <!-- Agregar contraseña-->
                        <div class="mb-4 flex flex-col items-center">
                            <label for="password_new" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Agregar Contraseña</label>
                            <input id="password_new" name="password_new" type="password" value="{{ old('password_new') }}" placeholder="********"
                                class="w-6/12 rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                        </div>

                        <!-- Guarda Contraseña Nueva -->
                        <div class="mb-6 flex flex-col items-center">
                            <button onclick=updatePassword() class="mt-1 rounded-full border bg-blue-400 px-4 py-2 text-white dark:bg-blue-950">Guardar
                                Contraseña</button>
                        </div>

                        <!-- Guardar Empleado -->
                        <div class="mb-6 flex flex-col items-center">
                            <button type="submit" form="saveEmpleado" class="mt-1 rounded-full border bg-blue-400 px-4 py-2 text-white dark:bg-blue-950">Guardar
                                Empleado</button>
                        </div>

                    </div>

                    <!-- Contenedor Derecho -->
                    <div class="col-span-12 [-ms-overflow-style:none] [scrollbar-width:none] md:col-span-6 md:h-[750px] md:overflow-y-auto [&::-webkit-scrollbar]:hidden">

                        <div class="hs-accordion-group">

                            <!-- Divider 1 -->
                            <div class="hs-accordion" id="hs-unstyled-heading-one">
                                <button class="hs-accordion-toggle mb-2 w-full rounded-3xl bg-blue-900 py-1 text-white hover:bg-blue-600" aria-expanded="false"
                                    aria-controls="hs-unstyled-collapse-one">
                                    Informacion del Empleado
                                </button>
                                <div id="hs-unstyled-collapse-one" class="hs-accordion-content mt-4 hidden overflow-hidden transition-[height] duration-300"
                                    role="region" aria-labelledby="hs-unstyled-heading-one">
                                    <form id="saveEmpleado" novalidate method="POST" action="{{ route('rh.empleados.store') }}">
                                        @csrf
                                        <!-- Nombres -->
                                        <div class="mb-6">
                                            <label for="nombre" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Nombres</label>
                                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required
                                                class="peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0">
                                            <p class="mt-1 hidden text-sm text-pink-600 [.validated_&]:peer-invalid:block">
                                                Este campo es obligatorio
                                            </p>
                                        </div>

                                        <!-- Apellidos -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="a_paterno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Apellido Paterno</label>
                                                <input id="a_paterno" name="a_paterno" type="text" value="{{ old('a_paterno') }}" required
                                                    class="peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0">
                                                <p class="mt-1 hidden text-sm text-pink-600 [.validated_&]:peer-invalid:block">
                                                    Este campo es obligatorio
                                                </p>
                                            </div>
                                            <div>
                                                <label for="a_materno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Apellido Materno</label>
                                                <input id="a_materno" name="a_materno" type="text" value="{{ old('a_materno') }}" required
                                                    class="peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0">
                                                <p class="mt-1 hidden text-sm text-pink-600 [.validated_&]:peer-invalid:block">
                                                    Este campo es obligatorio
                                                </p>
                                            </div>
                                        </div>

                                        <!-- CURP -->
                                        <div class="mb-6">
                                            <label for="curp" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">CURP</label>
                                            <input id="curp" name="curp" type="text" value="{{ old('curp') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                        </div>

                                        <!-- RFC y NSS -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="rfc" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">RFC</label>
                                                <input id="rfc" name="rfc" type="text" value="{{ old('rfc') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label for="nss" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">NSS</label>
                                                <input id="nss" name="nss" type="text" value="{{ old('nss') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                        </div>

                                        <!-- Fecha Nacimiento y Genero -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="fecha_nacimiento" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de
                                                    Nacimiento</label>
                                                <input id="fecha_nacimiento" name="fecha_nacimiento" type="text" value="{{ old('fecha_nacimiento') }}"
                                                    class="datepicker form-input min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label for="genero" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Genero</label>
                                                <select name="genero" id="genero"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 font-normal shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                                    <option value="">Seleccione género</option>
                                                    <option value="MASCULINO" {{ old('genero', $empleado->genero ?? '') == 'MASCULINO' ? 'selected' : '' }}>MASCULINO
                                                    </option>
                                                    <option value="FEMENINO" {{ old('genero', $empleado->genero ?? '') == 'FEMENINO' ? 'selected' : '' }}>FEMENINO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Correo Interno y Personal -->
                                        <div class="mb-1 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div class="mb-6">
                                                <label for="correo_interno" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Correo Interno</label>
                                                <input id="correo_interno" name="correo_interno" type="email" value="{{ old('correo_interno') }}" required
                                                    class="placeholder:text-default focus:border-primary focus:ring-primary border-3 peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0">

                                                <p class="mt-2 hidden text-sm text-pink-600 [.validated_&]:peer-placeholder-shown:peer-invalid:block">
                                                    Este campo es obligatorio
                                                </p>
                                                <p class="mt-2 hidden text-sm text-pink-600 [.validated_&]:peer-[:not(:placeholder-shown)]:peer-invalid:block">
                                                    Por favor ingrese un correo válido
                                                </p>
                                            </div>
                                            <div>
                                                <label for="correo_personal" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Correo
                                                    Personal</label>
                                                <input id="correo_personal" name="correo_personal" type="text" value="{{ old('correo_personal') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                        </div>

                                        <!-- Domicilio y Telefono -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="id_domicilio" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Domicilio</label>
                                                <input id="id_domicilio" name="id_domicilio" type="text" value="{{ old('id_domicilio') }}" readonly
                                                    onclick="domicilioModal()"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label for="telefono" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Telefono</label>
                                                <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                        </div>

                                        <!-- Contacto y Contacto Telefono -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="contacto" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Contacto</label>
                                                <input id="contacto" name="contacto" type="text" value="{{ old('contacto') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                            <div>
                                                <label for="contecto_telefono" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Telefono</label>
                                                <input id="contacto_telefono" name="contacto_telefono" type="text" value="{{ old('contacto_telefono') }}"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                        </div>

                                        <!-- Divider Informacion de la Empresa -->
                                        <div class="relative py-4">
                                            <div class="absolute inset-0 flex items-center">
                                                <div class="w-full border-b border-gray-300"></div>
                                            </div>
                                            <div class="relative flex justify-center">
                                                <span class="bg-white px-4 text-sm font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-300">Informacion de la
                                                    Empresa</span>
                                            </div>
                                        </div>

                                        <!-- Empresa y Puesto -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="id_empresa" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Empresa</label>

                                                <select name="id_empresa" id="id_empresa" required
                                                    class="peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0">
                                                    <option value="" disabled selected class="text-gray-400">Escoge una Empresa</option>
                                                    @foreach ($empresas as $empresa)
                                                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="mt-1 hidden text-sm text-pink-600 [.validated_&]:peer-invalid:block">
                                                    Este campo es obligatorio
                                                </p>
                                            </div>
                                            <div>
                                                <label for="id_puesto" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Puesto</label>

                                                <select name="id_puesto" id="id_puesto"
                                                    data-hs-select='{
                                            "hasSearch": true,
                                            "searchPlaceholder": "Buscar...",
                                            "placeholder": "Escoge un puesto",
                                            "searchClasses": "block w-full text-sm border-gray-300 rounded-md focus:border-blue-500 py-2 px-3 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300",
                                            "toggleClasses": "min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 font-normal shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700",
                                            "dropdownClasses": "z-50 mt-1 w-full bg-white border border-gray-300 text-sm rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700",
                                            "optionClasses": "py-2 px-3 text-gray-700 hover:bg-blue-100 dark:text-gray-300 dark:hover:bg-gray-800",
                                            "disabledOptionClasses": "text-gray-400 dark:text-gray-500",
                                            "extraMarkup": "<div class=\"pointer-events-none absolute inset-y-0 right-0 flex items-center pe-2\"><svg class=\"size-4 text-gray-700 dark:text-gray-400\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M19 9L12 16L5 9\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/></svg></div>"
                                            }'>

                                                    <option value="" disabled selected class="text-gray-400 dark:text-gray-500">Escoge un puesto</option>
                                                    @foreach ($puestos as $puesto)
                                                        <option value="{{ $puesto->id }}">
                                                            {{ $puesto->departamento->area->nombre }}/{{ $puesto->departamento->nombre }} -
                                                            {{ $puesto->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>

                                        <!-- Fecha de ingreso y salida -->
                                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="fecha_ingreso" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de
                                                    Ingreso</label>
                                                <input id="fecha_ingreso" name="fecha_ingreso" type="text" value="{{ old('fecha_ingreso') }}" required
                                                    class="datepicker peer min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm outline-none focus:ring-1 dark:bg-gray-900 dark:text-gray-300 [.validated_&]:invalid:border-pink-600 [.validated_&]:invalid:ring-0"
                                                    placeholder="Seleccione fecha">
                                                <p class="mt-1 hidden text-sm text-pink-600 [.validated_&]:peer-invalid:block">
                                                    Este campo es obligatorio
                                                </p>
                                            </div>
                                            <div>
                                                <label for="fecha_baja" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Fecha de Baja</label>
                                                <input id="fecha_baja" name="fecha_baja" type="text" value="{{ old('fecha_baja') }}"
                                                    class="datepicker form-input min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Divider 3 -->
                            <div class="hs-accordion" id="hs-unstyled-heading-two">
                                <button class="hs-accordion-toggle mb-2 w-full rounded-3xl bg-blue-900 py-1 text-white hover:bg-blue-600" aria-expanded="false"
                                    aria-controls="hs-unstyled-collapse-two">
                                    Esquema de Pago
                                </button>
                                <div id="hs-unstyled-collapse-two" class="hs-accordion-content mt-4 hidden overflow-hidden transition-[height] duration-300"
                                    role="region" aria-labelledby="hs-unstyled-heading-two">

                                    <!-- Sueldo y Tipo -->
                                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                                        <div class="col-start-1 md:col-span-2 md:col-start-2">
                                            <label for="tipo_pago" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Tipo de Pago</label>
                                            <input id="tipo_pago" name="tipo_pago" type="text" value="{{ old('tipo_pago') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                    </div>

                                    <!-- Sueldo y 7mo dia -->
                                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label for="sueldo" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Sueldo</label>
                                            <input id="sueldo" name="sueldo" type="text" value="{{ old('sueldo') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                        <div>
                                            <label for="septimo_dia" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Septimo Dia</label>
                                            <input id="septimo_dia" name="septimo_dia" type="text" value="{{ old('septimo_dia') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                    </div>

                                    <!-- Bonos Puntualidad y Asistencia -->
                                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label for="bono_puntualidad" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de
                                                Puntualidad</label>
                                            <input id="bono_puntualidad" name="bono_puntualidad" type="text" value="{{ old('bono_puntualidad') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                        <div>
                                            <label for="bono_asistencia" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de
                                                Asistencia</label>
                                            <input id="bono_asistencia" name="bono_asistencia" type="text" value="{{ old('bono_asistencia') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                    </div>

                                    <!-- Bonos Despensa y Bono Mensual/Extra -->
                                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label for="bono_despensa" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono de Despensa</label>
                                            <input id="bono_despensa" name="bono_despensa" type="text" value="{{ old('bono_despensa') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                        <div>
                                            <label for="bono_extra" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-300">Bono Extra</label>
                                            <input id="bono_extra" name="bono_extra" type="text" value="{{ old('bono_extra') }}"
                                                class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-300" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider 4 -->
                            <div class="hs-accordion" id="hs-unstyled-heading-three">
                                <button class="hs-accordion-toggle mb-2 w-full rounded-3xl bg-blue-900 py-1 text-white hover:bg-blue-600" aria-expanded="false"
                                    aria-controls="hs-unstyled-collapse-three">
                                    Documentos
                                </button>
                                <div id="hs-unstyled-collapse-three" class="hs-accordion-content mt-4 hidden overflow-hidden transition-[height] duration-300"
                                    role="region" aria-labelledby="hs-unstyled-heading-three">

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

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d", // Formato de fecha
                locale: "es", // Idioma
                allowInput: true, // Con esto se puede validar
            });
        });

        function domicilioModal() {
            console.log('Entro');
        }
    </script>

    <script>
        const form = document.getElementById("saveEmpleado");

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            form.classList.add("validated");
            if (!form.checkValidity()) {
                form.querySelectorAll(":invalid")[0].focus();
                return;
            }
            const formData = new FormData(form);
            const object = Object.fromEntries(formData);
            const json = JSON.stringify(object);


            axios.post(form.action, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    console.log(response.data);
                    window.location.href = `/rh/empleados/${response.data}`;

                }).catch(error => {
                    console.log(error);
                })
                .then(function() {
                    form.reset();
                    form.classList.remove("validated");
                });
        });
    </script>

</x-app-layout>
