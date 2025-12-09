<x-app-layout>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Retardos
            </h2>
        </div>
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Targeta Principal --}}
            <div class="z-10 bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                data-hs-datatable='{
                    "pageLength": 10,
                    "pagingOptions": {
                        "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                    }
                    }'>
                {{-- Encabezado de la tarjeta --}}
                <div class="z-10 flex items-center justify-between border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                    <div class="flex items-center space-x-4">

                        @php
                            // Declaramos las fechas que vamos a necesitar
                            $now = now();
                            $periodoActual = $now->subWeek()->weekOfYear; // Semana pasada, aun se esta registrando diario la semana actual
                            $anoActual = $now->year;
                        @endphp

                        <div class="relative w-64">
                            <select name="periodo" id="periodo"
                                data-hs-select='{
                                        "hasSearch": true,
                                        "searchPlaceholder": "Buscar...",
                                        "searchClasses": "block w-full text-sm border-gray-300 rounded-md focus:border-blue-500 py-2 px-3 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300",
                                        "toggleClasses": "min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 font-normal shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 cursor-pointer",
                                        "dropdownClasses": "z-50 mt-1 w-full max-h-60 bg-white border border-gray-300 text-sm rounded-md shadow-sm overflow-y-auto dark:bg-gray-900 dark:border-gray-700",
                                        "optionClasses": "py-2 px-3 text-gray-700 hover:bg-blue-100 dark:text-gray-300 dark:hover:bg-gray-800",
                                        "disabledOptionClasses": "text-gray-400 dark:text-gray-500"
                                    }'
                                class="cursor-pointer">
                                <option value="" disabled selected class="text-gray-400 dark:text-gray-500">Selecciona un periodo</option>
                                {{-- Recorremos las semanas de la mas reciente a la mas antigua en el año --}}
                                @for ($periodo = $periodoActual; $periodo >= 1; $periodo--)
                                    @php
                                        $fechaInicio = $now->copy()->setISODate($anoActual, $periodo)->startOfWeek(); // Primer dia del periodo
                                        $fechafin = $fechaInicio->copy()->endOfWeek(); // Ultimo dia del periodo
                                        $periodoValor = $periodo + 1; // Movemos el numero del periodo para que coincida con el que se una
                                        $isSelected = $periodoValor == $periodoOg; // Nos aseguramos que se seleccione el periodo que estamos viendo
                                    @endphp
                                    <option value="{{ $periodoValor }}" {{ $isSelected ? 'selected' : '' }}>
                                        Periodo {{ $periodoValor }} ({{ $fechaInicio->format('d/m') }} - {{ $fechafin->format('d/m') }})
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <button onclick="changePeriodo()" type="submit"
                            class="transform rounded-lg bg-indigo-600 px-4 py-2 text-white transition-all hover:scale-105 hover:bg-indigo-700">
                            Buscar
                        </button>

                        @if (!$empleados)
                            <div x-data="{ isOpen: false }" class="relative flex justify-center">
                                <button @click="isOpen = true" id="newPuestoBtn"
                                    class="mx-auto transform rounded-md bg-indigo-600 px-4 py-2 capitalize tracking-wide text-white transition-all hover:scale-105 hover:bg-indigo-700">
                                    <i class="fas fa-plus-circle mr-2"></i> Importar Reporte
                                </button>

                                <!-- Backdrop -->
                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacit y-0"
                                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isOpen = false"
                                    style="display: none;"></div>

                                <!-- Modal Contenido -->
                                <div x-show="isOpen" x-transition:enter="transition duration-300 ease-out"
                                    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100" x-transition:leave="transition duration-150 ease-in"
                                    x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                                    x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                                    class="fixed inset-0 z-20 flex items-center justify-center p-4 sm:p-0" style="display: none;">
                                    <div
                                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom text-lg font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                                        <div>
                                            Importar Reporte
                                        </div>
                                        <form method="POST" action="{{ route('rh.retardos.import') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mt-4">

                                                <div>
                                                    <label class="text-sm text-gray-700 dark:text-gray-200" for="nombre">Archivo de Excel</label>
                                                    <div class="-mx-1 flex items-center">
                                                        <input type="file" accept=".xlsx,.xls,.csv" required name="file"
                                                            class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 placeholder-gray-400/70 file:rounded-full file:border-none file:bg-gray-200 file:px-4 file:py-1 file:text-sm file:text-gray-700 focus:border-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:file:bg-gray-800 dark:file:text-gray-200 dark:focus:border-blue-300" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 sm:-mx-2 sm:mt-6 sm:flex sm:items-center">
                                                <button @click="isOpen = false" type="button"
                                                    class="w-full transform rounded-md border border-gray-200 px-4 py-2 text-sm font-medium capitalize tracking-wide text-gray-700 transition-colors duration-300 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 sm:mx-2 sm:w-1/2">
                                                    Cancelar
                                                </button>
                                                <button type="submit"
                                                    class="mt-3 w-full transform rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 hover:bg-indigo-700 focus:outline-none sm:mx-2 sm:mt-0 sm:w-1/2">
                                                    Importar
                                                </button>
                                            </div>
                                        </form>

                                        @if ($errors->any())
                                        <script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error al importar',
                                                    html: 'No se encontraron los campos necesarios.',
                                                    background: '#fff', 
                                                    backdrop: 'rgba(0,0,0,0.7)'
                                                });
                                            </script>
                                        @endif

                                        @if (session('error'))
                                            <script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error al importar',
                                                    html: '{{ session('error') }}',
                                                    background: '#fff', 
                                                    backdrop: 'rgba(0,0,0,0.7)'
                                                });
                                            </script>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="relative" data-hs-datatable-search>
                        <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                            class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex flex-col">

                    <div class="min-h-130 overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full">
                                    <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                        <tr>
                                            <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                scope="col" data-column="empleado">
                                                Empleado
                                            </th>
                                            @foreach ($fechaDia as $dia)
                                                <th class="--exclude-from-ordering sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                    scope="col" data-column="{{ strtolower($dia['nombre']) }}">

                                                    <span>{{ $dia['nombre'] }}</span>
                                                    <span class="mt-1 text-xs font-normal">{{ $dia['fecha'] }}</span>

                                                </th>
                                            @endforeach
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Total
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody class="divide-y divide-[#A0B4CB] dark:divide-neutral-700">
                                        @foreach ($empleados as $empleado)
                                            <tr>
                                                <td class="whitespace-nowrap px-6 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                                    <div class="flex flex-col space-y-0">
                                                        <div>
                                                            {{ $empleado['apellidos'] ?? '' }}
                                                        </div>
                                                        <div>
                                                            {{ $empleado['nombre'] ?? '' }}
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Iterar sobre días de la semana (Lunes a Viernes) --}}
                                                @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                                        @if (!empty($empleado['semana'][$dia]))
                                                            <!-- Contenedor principal -->
                                                            <div class="space-y-1">
                                                                <!-- Entrada con tooltip -->
                                                                <div class="group relative">
                                                                    <div class="cursor-default rounded p-1 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                                        <strong>Entrada:</strong> {{ $empleado['semana'][$dia]['entrada'] ?? '--:--' }}
                                                                        @if (($empleado['semana'][$dia]['retraso'] ?? 0) > 0)
                                                                            <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                                                                            <div
                                                                                class="absolute -left-4 -top-10 z-10 hidden w-40 rounded border border-gray-200 bg-white p-2 shadow-lg group-hover:block dark:border-gray-700 dark:bg-gray-800">
                                                                                <span class="font-semibold text-red-500">Retraso:
                                                                                    {{ $empleado['semana'][$dia]['retraso'] }}
                                                                                    min</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <!-- Salida con tooltip -->
                                                                <div class="group relative">
                                                                    <div class="cursor-default rounded p-1 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                                        <strong>Salida:</strong> {{ $empleado['semana'][$dia]['salida'] ?? '--:--' }}
                                                                        @if (($empleado['semana'][$dia]['salida_temprana'] ?? 0) > 0)
                                                                            <i class="fa-solid fa-circle-exclamation text-orange-400"></i>
                                                                            <div
                                                                                class="absolute -left-4 -top-10 z-10 hidden w-auto rounded border border-gray-200 bg-white p-2 shadow-lg group-hover:block dark:border-gray-700 dark:bg-gray-800">
                                                                                <span class="font-semibold text-orange-500">Salida temprana:
                                                                                    {{ $empleado['semana'][$dia]['salida_temprana'] }} min</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">Sin registro</span>
                                                        @endif
                                                    </td>
                                                @endforeach

                                                {{-- Total de retrasos --}}
                                                <td class="whitespace-nowrap px-6 py-3 text-center text-sm font-bold text-gray-900 dark:text-white">
                                                    <div class="flex flex-col space-y-3">
                                                        <div>
                                                            @php
                                                                $retrasoTotal = array_sum(array_column(array_filter($empleado['semana']), 'retraso'));
                                                            @endphp
                                                            <span class="{{ $retrasoTotal == 0 ? 'text-green-700' : 'text-red-500' }}">{{ $retrasoTotal }} min</span>

                                                        </div>
                                                        <div>
                                                            @php
                                                                $salidaTotal = array_sum(array_column(array_filter($empleado['semana']), 'salida_temprana'));
                                                            @endphp
                                                            <span class="{{ $salidaTotal == 0 ? 'text-green-700' : 'text-orange-500' }}">
                                                                {{ $salidaTotal }} min
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (empty($empleados))
                                            <tr>
                                                <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">No se
                                                    encontraron resultados</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
                    data-hs-datatable-paging>

                    <div class="text-sm text-gray-700 dark:text-neutral-300">
                        <span data-hs-datatable-info>
                            Mostrando <span class="font-medium" data-hs-datatable-info-from></span>
                            a <span class="font-medium" data-hs-datatable-info-to></span> de
                            <span data-hs-datatable-info-length></span> resultados
                        </span>
                    </div>

                    <div class="flex space-x-1">
                        <!-- Previous Button -->
                        <button type="button" data-hs-datatable-paging-prev
                            class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                            Anterior
                            <span class="sr-only">Previous</span>
                        </button>

                        <!-- Page numbers will be auto-generated here by DataTables -->
                        <div class="flex space-x-1" data-hs-datatable-paging-pages></div>

                        <!-- Next Button -->
                        <button type="button" data-hs-datatable-paging-next
                            class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                            Siguiente
                            <span class="sr-only">Siguiente</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Hide the entire control row */
            div.dt-layout-row.dt-layout-table {
                display: none !important;
            }

            .sortable:hover {
                background-color: #f3f4f6;
            }

            .sortable i {
                opacity: 0.5;
                transition: opacity 0.2s;
            }

            .sortable:hover i {
                opacity: 1;
            }

            #filterPanel {
                transition: all 0.3s ease;
                opacity: 0;
                transform: translateY(-10px);
            }

            #filterPanel.show {
                opacity: 1;
                transform: translateY(0);
            }

            tr {
                transition: transform 0.2s, background-color 0.2s;
            }

            .hover\:scale-\[1\.002\]:hover {
                transform: scale(1.002);
            }
        </style>
    @endpush

    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
                axios.post('{{ route('rh.empleados.destroy', ':id') }}'.replace(':id', id), {
                        _method: 'DELETE', // El metodo destroy necesita DELETE
                        _token: '{{ csrf_token() }}' // Pasamos el token
                    })
                    .then(response => {

                    })
                    .catch(error => {
                        // Handle error
                        console.error('Error deleting employee:', error);
                    });
            }
        }

        function changePeriodo() {
            const periodo = document.getElementById('periodo').value;
            window.location.href = `/rh/retardos/${periodo}`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
                console.log('Preline inicializado'); // Debug
            } else {
                console.error('Preline no está disponible');
            }
        });
    </script>
</x-app-layout>
