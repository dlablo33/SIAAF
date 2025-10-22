<x-app-layout>

    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Nominas
            </h2>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-2 flex gap-x-3">
                <!-- Periodo -->
                <div class="flex min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-xl shadow-sm">
                    @php
                        // Declaramos las fechas que vamos a necesitar
                        $now = now();
                        $periodoActual = $now->subWeek()->weekOfYear; // Semana pasada
                        $anoActual = $now->year;
                    @endphp

                    <div class="relative w-64">
                        <select name="periodo" id="periodo" onchange="cambioPeriodo()" class="opacity-0"
                            data-hs-select='{
                                        "hasSearch": true,
                                        "searchPlaceholder": "Buscar...",
                                        "searchClasses": "block w-full text-sm rounded-md focus:border-blue-500 py-2 px-3 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300",
                                        "toggleClasses": "min-h-10 w-full -translate-x-2 rounded-md px-3 py-2 font-normal dark:bg-gray-900 dark:text-gray-300 font-semibold cursor-pointer",
                                        "dropdownClasses": "z-50 -translate-x-5 translate-y-3 w-[116%] max-h-60 bg-white border border-slate-300 text-lg  rounded-md shadow-sm overflow-y-auto dark:bg-gray-900 dark:border-gray-700",
                                        "optionClasses": "py-2 px-3 text-gray-700 hover:bg-blue-100 dark:text-gray-300 dark:hover:bg-gray-800"
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
                                    Periodo {{ $periodoValor }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Fecha Periodo -->
                <div class="flex min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-lg shadow-sm">
                    <div class="font-semibold">
                        <div class="text-sm text-gray-500">Fecha de Periodo:</div>
                        <div> {{ $fechaPeriodo }} </div>
                    </div>
                </div>

                <!-- Fecha Nomina -->
                <div class="flex min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-lg shadow-sm">
                    <div class="font-semibold">
                        <div class="text-sm text-gray-500">Fecha Nómina:</div>
                        <div> {{ $fechaNomina }} </div>
                    </div>
                </div>
            </div>

            <nav class="flex w-full rounded-xl shadow-lg" aria-label="Tabs" role="tablist">
                <button type="button"
                    class="active mt-3 w-full rounded-l-xl bg-gray-100 py-3 text-lg font-semibold hover:bg-orange-600/80 hover:text-white hs-tab-active:bg-[#00404a] hs-tab-active:text-white"
                    id="unstyled-tabs-item-1" aria-selected="" data-hs-tab="#unstyled-tabs-1" aria-controls="unstyled-tabs-1" role="tab">
                    Nomina Fiscal
                </button>
                <button type="button"
                    class="mt-3 w-full bg-gray-100 py-3 text-lg font-semibold hover:bg-orange-600/80 hover:text-white hs-tab-active:bg-[#00404a] hs-tab-active:text-white"
                    id="unstyled-tabs-item-2" aria-selected="" data-hs-tab="#unstyled-tabs-2" aria-controls="unstyled-tabs-2" role="tab">
                    Complemento
                </button>
                <button type="button" id="unstyled-tabs-item-3"
                    class="mt-3 w-full rounded-r-lg bg-gray-100 py-3 text-lg font-semibold hover:bg-orange-600/80 hover:text-white hs-tab-active:bg-[#00404a] hs-tab-active:text-white"
                    aria-selected="" data-hs-tab="#unstyled-tabs-3" aria-controls="unstyled-tabs-3" role="tab">
                    Total
                </button>
            </nav>

            <div class="mt-4">
                {{-- NOMINA FISCAL --}}
                <div id="unstyled-tabs-1" role="tabpanel" class="relative h-auto w-full" aria-labelledby="unstyled-tabs-item-1">
                    {{-- PRESTACIONES --}}
                    <div id="prestaciones-fiscal"
                        class="absolute inset-0 z-10 bg-white opacity-100 shadow-sm transition-all duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Prestaciones</span>
                                <label class="switch">
                                    <input id="switch2" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-base font-bold text-gray-500">Deducciones</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>

                                                    @foreach ($prestaciones as $prestacion)
                                                        <th class="--exclude-from-ordering sortable cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                            scope="col" data-column="{{ strtolower($prestacion) }}">
                                                            <span>{{ $prestacion->nombre }} </span>
                                                        </th>
                                                    @endforeach

                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>

                                                        <!-- Prestaciones Columns -->
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                                {{ $data['prestaciones']['FISCAL']->has($prestacion->id) ? number_format($data['prestaciones']['FISCAL'][$prestacion->id]->cantidad, 2) : 0 }}
                                                            </td>
                                                        @endforeach

                                                        <!-- Total Column -->
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">
                                                            {{ number_format($data['prestaciones']['FISCAL']->sum('cantidad'), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td></td>
                                                        @endforeach
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

                    {{-- DEDUCCIONES --}}
                    <div id="deducciones-fiscal"
                        class="pointer-events-none absolute inset-0 z-10 bg-white opacity-0 shadow-sm transition-opacity duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Prestaciones</span>
                                <label class="switch">
                                    <input id="switch1" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-base font-bold text-gray-500">Deducciones</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>

                                                    @foreach ($deducciones as $deduccion)
                                                        <th class="--exclude-from-ordering sortable cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                            scope="col" data-column="{{ strtolower($deduccion) }}">
                                                            <span>{{ $deduccion->nombre }} </span>
                                                        </th>
                                                    @endforeach

                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>

                                                        <!-- Deducciones Columns -->
                                                        @foreach ($deducciones as $deduccion)
                                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                                {{ $data['deducciones']['FISCAL']->has($deduccion->id) ? number_format($data['deducciones']['FISCAL'][$deduccion->id]->cantidad, 2) : 0 }}
                                                            </td>
                                                        @endforeach

                                                        <!-- Total Column -->
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">
                                                            {{ number_format($data['deducciones']['FISCAL']->sum('cantidad'), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($deducciones as $deduccion)
                                                            <td></td>
                                                        @endforeach
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

                {{-- COMPLEMENTO --}}
                <div id="unstyled-tabs-2" class="relative hidden h-auto w-full" role="tabpanel" aria-labelledby="unstyled-tabs-item-2">
                    <div id="prestaciones-complemento"
                        class="absolute inset-0 z-10 bg-white opacity-100 shadow-sm transition-all duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Prestaciones</span>
                                <label class="switch">
                                    <input id="switch2-complemento" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-base font-bold text-gray-500">Deducciones</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>

                                                    @foreach ($prestaciones as $prestacion)
                                                        <th class="--exclude-from-ordering sortable cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                            scope="col" data-column="{{ strtolower($prestacion) }}">
                                                            <span>{{ $prestacion->nombre }} </span>
                                                        </th>
                                                    @endforeach

                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>

                                                        <!-- Prestaciones Columns -->
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                                {{ $data['prestaciones']['COMPLEMENTO']->has($prestacion->id) ? number_format($data['prestaciones']['COMPLEMENTO'][$prestacion->id]->cantidad, 2) : 0 }}
                                                            </td>
                                                        @endforeach

                                                        <!-- Total Column -->
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">
                                                            {{ number_format($data['prestaciones']['COMPLEMENTO']->sum('cantidad'), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td></td>
                                                        @endforeach
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

                    {{-- DEDUCCIONES COMPLEMENTO --}}
                    <div id="deducciones-complemento"
                        class="pointer-events-none absolute inset-0 z-10 bg-white opacity-0 shadow-sm transition-opacity duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Prestaciones</span>
                                <label class="switch">
                                    <input id="switch1-complemento" type="checkbox">
                                    <span class="slider round"></span>

                                </label>
                                <span class="text-base font-bold text-gray-500">Deducciones</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>

                                                    @foreach ($deducciones as $deduccion)
                                                        <th class="--exclude-from-ordering sortable cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                            scope="col" data-column="{{ strtolower($deduccion) }}">
                                                            <span>{{ $deduccion->nombre }} </span>
                                                        </th>
                                                    @endforeach

                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>

                                                        <!-- Deducciones Columns -->
                                                        @foreach ($deducciones as $deduccion)
                                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                                {{ $data['deducciones']['COMPLEMENTO']->has($deduccion->id) ? number_format($data['deducciones']['COMPLEMENTO'][$deduccion->id]->cantidad, 2) : 0 }}
                                                            </td>
                                                        @endforeach

                                                        <!-- Total Column -->
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">
                                                            {{ number_format($data['deducciones']['COMPLEMENTO']->sum('cantidad'), 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($deducciones as $deduccion)
                                                            <td></td>
                                                        @endforeach
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

                {{-- TOTAL --}}
                <div id="unstyled-tabs-3" class="relative hidden h-auto w-full" role="tabpanel" aria-labelledby="unstyled-tabs-item-3">
                    {{-- TOTAL FISCAL --}}
                    <div id="total-fiscal"
                        class="absolute inset-0 z-10 bg-white opacity-100 shadow-sm transition-all duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Fiscal</span>
                                <label class="switch">
                                    <input id="totalFisc" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-base font-bold text-gray-500">Complemento</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Percepcion
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Deducciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Neto Real Percepciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Fiscal Percepciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        ISR e IMSS
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Complemento Neto a Pagar
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default whitespace-normal px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300 md:min-w-28"
                                                        scope="col" data-column="total">
                                                        Neto Fiscal a Pagar
                                                    </th>

                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Recibo
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">

                                                @foreach ($empleados as $idEmpleado => $data)
                                                    @php
                                                        $totalPercepciones = $data['prestaciones']['FISCAL']->sum('cantidad') ?? 0;
                                                        $totalDeducciones = $data['deducciones']['FISCAL']->sum('cantidad') ?? 0;
                                                        $netoRealPercepciones = $totalPercepciones - $totalDeducciones;
                                                        $totalFiscalPercepciones = 0;
                                                        $isrImss = 0;
                                                        $complementoNetoPagar =
                                                            $data['prestaciones']['COMPLEMENTO']->sum('cantidad') -
                                                                $data['deducciones']['COMPLEMENTO']->sum('cantidad') ??
                                                            0;
                                                        $netoFiscalPagar = 0;
                                                        $recibo = $complementoNetoPagar + $netoFiscalPagar;
                                                    @endphp
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>

                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($totalPercepciones, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($totalDeducciones, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($netoRealPercepciones, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($totalFiscalPercepciones, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">{{ number_format($isrImss, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($complementoNetoPagar, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                            {{ number_format($netoFiscalPagar, 2) }}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-500">
                                                            {{ number_format($recibo, 2) }}</td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td></td>
                                                        @endforeach
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

                    {{-- TOTAL COMPLEMENTO --}}
                    <div id="total-complemento"
                        class="pointer-events-none absolute inset-0 z-10 bg-white opacity-0 shadow-sm transition-opacity duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="z-10 flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">

                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            {{-- SWITCH --}}
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-gray-500">Fiscal</span>
                                <label class="switch">
                                    <input id="totalComp" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-base font-bold text-gray-500">Complemento</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="min-h-130 overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">

                                                <tr>
                                                    <th class="sortable cursor-default px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="empleado">
                                                        Empleado
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Percepcion
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Deducciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Neto Real Percepciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Total Fiscal Percepciones
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        ISR e IMSS
                                                    </th>
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Exedente
                                                    </th>
                                                </tr>

                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    <tr>
                                                        <!-- Employee Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
                                                        @foreach ($deducciones as $deduccion)
                                                            <td></td>
                                                        @endforeach
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
        </div>
    </div>

    <script>
        function cambioPeriodo() {
            const periodo = document.getElementById('periodo').value;
            if (periodo) { // Only redirect if a value is selected (not the disabled option)
                window.location.href = `/rh/nomina/${periodo}`;
            }
        }

        // Switch sincronizado



        document.addEventListener('DOMContentLoaded', () => {
            // Switches
            const switches = document.querySelectorAll('input[type="checkbox"][id^="switch"]');
            const switchesTotal = document.querySelectorAll('input[type="checkbox"][id^="total"]');

            // Tablas
            const prestacionesFiscal = document.getElementById('prestaciones-fiscal');
            const deduccionesFiscal = document.getElementById('deducciones-fiscal');
            const prestacionesComplemento = document.getElementById('prestaciones-complemento');
            const deduccionesComplemento = document.getElementById('deducciones-complemento');
            const totalFiscal = document.getElementById('total-fiscal');
            const totalComplemento = document.getElementById('total-complemento');

            // Obtener ultimo estado
            const savedSwitchState = localStorage.getItem('switchState') === 'true';
            const savedTotalState = localStorage.getItem('totalState') === 'true';

            switches.forEach(sw => (sw.checked = savedSwitchState));
            switchesTotal.forEach(sw => (sw.checked = savedTotalState));

            // Mostrar al cargar pagina
            toggleTable(savedSwitchState);
            toggleTotal(savedTotalState);

            // EventListener para cambios
            switches.forEach(sw => {
                sw.addEventListener('change', e => {
                    const checked = e.target.checked;
                    // Sincronizar todos los switches fiscales/complemento
                    switches.forEach(other => (other.checked = checked));
                    localStorage.setItem('switchState', checked);
                    toggleTable(checked);
                });
            });

            //  Mantenemos totales separados
            switchesTotal.forEach(sw => {
                sw.addEventListener('change', e => {
                    const checked = e.target.checked;
                    switchesTotal.forEach(other => (other.checked = checked));
                    localStorage.setItem('totalState', checked);
                    toggleTotal(checked);
                });
            });

            // Clases para mostrar y quitar
            function toggleVisibility(el, visible) {
                if (!el) return;
                el.classList.replace(visible ? 'opacity-0' : 'opacity-100', visible ? 'opacity-100' : 'opacity-0');
                el.classList.toggle('pointer-events-none', !visible);
            }


            function toggleTable(checked) {
                // FISCAL
                toggleVisibility(prestacionesFiscal, !checked);
                toggleVisibility(deduccionesFiscal, checked);

                // COMPLEMENTO
                toggleVisibility(prestacionesComplemento, !checked);
                toggleVisibility(deduccionesComplemento, checked);
            }

            // TOTALES
            function toggleTotal(checked) {
                toggleVisibility(totalFiscal, !checked);
                toggleVisibility(totalComplemento, checked);
            }
        });
    </script>
</x-app-layout>
