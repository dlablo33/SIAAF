<x-app-layout>

    <style>
        /* Active Paginacion */
        [data-hs-datatable-paging-pages]>.active {
            --tw-bg-opacity: 1;
            background-color: rgb(229 231 235 / var(--tw-bg-opacity, 1));
            color: rgb(17 24 39);
            font-weight: 600;
        }

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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="min-h-[100vh]">
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
                                    $fechaFin = $fechaInicio->copy()->endOfWeek(); // Ultimo dia del periodo
                                    $periodoValor = $periodo + 1; // Movemos el numero del periodo para que coincida con el que se una
                                    $isSelected = $periodoValor == $periodoOg; // Nos aseguramos que se seleccione el periodo que estamos viendo
                                    $fechaFormateada = $fechaInicio->format('j') . ' - ' . $fechaFin->translatedFormat('j M Y'); // Formatemos la fecha para mostrarla en las opciones
                                @endphp
                                <option value="{{ $periodoValor }}" {{ $isSelected ? 'selected' : '' }}>
                                    Periodo {{ $periodoValor }} {{ !$isSelected ? '(' . $fechaFormateada . ')' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Fecha Periodo -->
                <div class="flex min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-lg shadow-sm">
                    <div class="font-semibold">
                        <div class="text-sm text-gray-500">Fecha de Periodo:</div>
                        {{ $fechaPeriodo }}
                    </div>
                </div>

                <!-- Fecha Nomina -->
                <div class="flex min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-lg shadow-sm">
                    <div class="font-semibold">
                        <div class="text-sm text-gray-500">Fecha Nómina:</div>
                        {{ $fechaNomina }}
                    </div>
                </div>

                <div id="total-box" class="flex hidden min-w-64 cursor-default items-center rounded-lg border border-slate-300 bg-white px-5 py-4 text-lg shadow-sm">
                    <div class="text-xl font-semibold">
                        <div class="text-sm text-gray-500">Total:</div>
                        <div id="total"></div>
                    </div>
                </div>

                <div id="generar-box" class="mx-auto flex items-center justify-center">
                    <div data-empleado="" data-empleados='@json($empleados)'
                        class="btn-generar h-1/2 cursor-pointer rounded-lg border border-slate-300 bg-blue-500 px-4 py-1 text-lg font-semibold text-white shadow-sm">
                        Generar Reportes
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
                    Dispersion
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Total
                                    </span>
                                </label>
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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                        <!-- Empleado Info -->
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
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-gray-900">
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Total
                                    </span>
                                </label>
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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                        <!-- Empleado Info -->
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
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-gray-900">
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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

                    {{-- Total Fiscal --}}
                    <div id="total-fiscal"
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Total
                                    </span>
                                </label>
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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Ver
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
                                                        $netoFiscalPagar = $netoRealPercepciones ?? 0;
                                                        $recibo = $complementoNetoPagar + $netoFiscalPagar;
                                                    @endphp
                                                    <tr>
                                                        <!-- Empleado Info -->
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
                                                        <td class="text-center">
                                                            <svg class="btn-generar inline-block h-7 w-7 cursor-pointer" data-empleado="{{ $data['empleado']->id }}"
                                                                data-empleados='' viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4 7C4 5.11438 4 4.17157 4.58579 3.58579C5.17157 3 6.11438 3 8 3H16C17.8856 3 18.8284 3 19.4142 3.58579C20 4.17157 20 5.11438 20 7V15C20 17.8284 20 19.2426 19.1213 20.1213C18.2426 21 16.8284 21 14 21H10C7.17157 21 5.75736 21 4.87868 20.1213C4 19.2426 4 17.8284 4 15V7Z"
                                                                    stroke="#33363F" stroke-width="2" />
                                                                <path d="M15 18L15 21M9 18L9 21" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                                <path d="M9 8L15 8" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                                <path d="M9 12L15 12" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                            </svg>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados
                                                        </td>
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Total
                                    </span>
                                </label>
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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                        <!-- Empleado Info -->
                                                        <td class="whitespace-nowrap">
                                                            <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                            </div>
                                                        </td>

                                                        <!-- Prestaciones Columns -->
                                                        @foreach ($prestaciones as $prestacion)
                                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                                {{ $data['prestaciones']['COMPLEMENTO']->has($prestacion->id) ? number_format($data['prestaciones']['COMPLEMENTO'][$prestacion->id]->cantidad, 2) : 0 }}
                                                            </td>
                                                        @endforeach

                                                        <!-- Total Column -->
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-gray-900">
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Total
                                    </span>
                                </label>
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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                        <!-- Empleado Info -->
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
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-gray-900">
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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
                            <div class="flex w-full max-w-lg items-center gap-4">
                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="prestaciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Prestaciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="deducciones" class="peer hidden">
                                    <span class="flex-1 rounded-lg border border-gray-400 px-3 py-2 text-center text-gray-500 transition">
                                        Deducciones
                                    </span>
                                </label>

                                <label class="flex flex-1 cursor-pointer items-center justify-center">
                                    <input type="radio" name="viewMode" value="total" class="peer hidden" checked>
                                    <span class="flex-1 rounded-lg border border-gray-400 bg-blue-600 px-3 py-2 text-center text-white transition">
                                        Total
                                    </span>
                                </label>

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
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
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
                                                    <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col" data-column="total">
                                                        Ver
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    @php
                                                        $totalPercepciones = $data['prestaciones']['COMPLEMENTO']->sum('cantidad') ?? 0;
                                                        $totalDeducciones = $data['deducciones']['COMPLEMENTO']->sum('cantidad') ?? 0;
                                                        $netoRealPercepciones = $totalPercepciones - $totalDeducciones;
                                                        $totalFiscalPercepciones = 0;
                                                        $isrImss = 0;
                                                        $complementoNetoPagar =
                                                            $data['prestaciones']['COMPLEMENTO']->sum('cantidad') -
                                                                $data['deducciones']['COMPLEMENTO']->sum('cantidad') ??
                                                            0;
                                                        $netoFiscalPagar = $netoRealPercepciones ?? 0;
                                                        $recibo = $complementoNetoPagar + $netoFiscalPagar;
                                                    @endphp
                                                    <tr>
                                                        <!-- Empleado Info -->
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
                                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-500">
                                                            {{ number_format($recibo, 2) }}</td>
                                                        <td class="text-center">
                                                            <svg class="btn-generar inline-block h-7 w-7 cursor-pointer" data-empleado="{{ $data['empleado']->id }}"
                                                                data-empleados='' viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4 7C4 5.11438 4 4.17157 4.58579 3.58579C5.17157 3 6.11438 3 8 3H16C17.8856 3 18.8284 3 19.4142 3.58579C20 4.17157 20 5.11438 20 7V15C20 17.8284 20 19.2426 19.1213 20.1213C18.2426 21 16.8284 21 14 21H10C7.17157 21 5.75736 21 4.87868 20.1213C4 19.2426 4 17.8284 4 15V7Z"
                                                                    stroke="#33363F" stroke-width="2" />
                                                                <path d="M15 18L15 21M9 18L9 21" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                                <path d="M9 8L15 8" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                                <path d="M9 12L15 12" stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                                            </svg>
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

                        <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
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

                {{-- DISPERSION --}}
                <div class="flex justify-center">
                    <div id="unstyled-tabs-3" class="relative hidden h-auto w-3/4" role="tabpanel" aria-labelledby="unstyled-tabs-item-3">
                        {{-- DISPERSION FISCAL --}}
                        <div class="flex justify-center">
                            <div id="dispersion-fiscal"
                                class="z-10 w-full bg-white opacity-100 shadow-sm transition-all duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                                data-hs-datatable='{
                                        "pageLength": 10,
                                        "pagingOptions": {
                                            "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                                        }
                                    }'>
                                <div class="flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                                    <div class="relative" data-hs-datatable-search>
                                        <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                            class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                    <!-- Switch -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-base font-bold text-gray-500">Fiscal</span>
                                        <label class="switch">
                                            <input id="dispersion-fis" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <span class="text-base font-bold text-gray-500">Complemento</span>
                                    </div>
                                </div>
                                <!-- Tabla -->
                                <div class="flex flex-col">
                                    <div class="min-h-[32rem] overflow-auto">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">
                                                <tr>
                                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                        <div class="flex cursor-pointer gap-1">
                                                            Empleado
                                                            <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m7 15 5 5 5-5"></path>
                                                                <path d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </div>
                                                    </th>
                                                    <th
                                                        class="--exclude-from-ordering px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                        Monto
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-300 dark:divide-neutral-500">
                                                @php
                                                    $dispersionFiscal = 0;
                                                @endphp
                                                @foreach ($empleados as $idEmpleado => $data)
                                                    @php
                                                        $totalFiscal = $dispersion['FISCAL'][$idEmpleado]['total'] ?? 0;
                                                        $dispersionFiscal += $totalFiscal;
                                                    @endphp
                                                    <tr>
                                                        <td class="px-6 py-2">
                                                            <div class="flex flex-col space-y-0 font-semibold">
                                                                <div>{{ $data['empleado']->nombre }}</div>
                                                                <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center font-semibold">
                                                            ${{ number_format($totalFiscal, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if ($empleados->isEmpty())
                                                    <tr>
                                                        <td class="px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white" colspan="2">
                                                            No se encontraron resultados
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Pagination -->
                                <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
                                    data-hs-datatable-paging>
                                    <div class="text-sm text-gray-700 dark:text-neutral-300">
                                        <span data-hs-datatable-info>
                                            Mostrando <span class="font-medium" data-hs-datatable-info-from></span>
                                            a <span class="font-medium" data-hs-datatable-info-to></span> de
                                            <span data-hs-datatable-info-length></span> resultados
                                        </span>
                                    </div>
                                    <div class="flex space-x-1">
                                        <button type="button" data-hs-datatable-paging-prev
                                            class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                                            Anterior
                                        </button>
                                        <div class="flex space-x-1" data-hs-datatable-paging-pages></div>
                                        <button type="button" data-hs-datatable-paging-next
                                            class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                                            Siguiente
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Fiscal -->
                            <div class="flex hidden items-start justify-center">
                                <div class="mt-20 rounded-2xl border border-gray-300 bg-white p-10 text-center shadow-md dark:border-gray-600 dark:bg-gray-800">
                                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-100">Total</h2>
                                    <p class="mt-4 text-4xl font-semibold" id="totalFiscal">
                                        ${{ number_format($dispersionFiscal ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- DISPERSION COMPLEMENTO --}}
                        <div class="flex justify-center">
                            <div id="dispersion-complemento"
                                class="pointer-events-none absolute inset-0 z-10 h-full bg-white opacity-0 transition-opacity duration-500 dark:bg-gray-700 sm:rounded-t-lg"
                                data-hs-datatable='{
                                        "pageLength": 10,
                                        "pagingOptions": {
                                            "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                                        }
                                    }'>
                                <div class="z-10 bg-white shadow-sm transition-all duration-500 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg">
                                    <div class="flex items-center gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                                        <div class="relative" data-hs-datatable-search>
                                            <input type="text" placeholder="Buscar empleado..." data-hs-datatable-search-input
                                                class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                        </div>
                                        <!-- Switch -->
                                        <div class="flex items-center gap-2">
                                            <span class="text-base font-bold text-gray-500">Fiscal</span>
                                            <label class="switch">
                                                <input id="dispersion-comp" type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="text-base font-bold text-gray-500">Complemento</span>
                                        </div>
                                    </div>
                                    <!-- Tabla -->
                                    <div class="flex flex-col">
                                        <div class="min-h-[32rem] overflow-auto">
                                            <table class="min-w-full">
                                                <thead class="bg-[#D3D8DB] dark:bg-gray-800">
                                                    <tr>
                                                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                            <div class="flex cursor-pointer gap-1">
                                                                Empleado
                                                                <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="m7 15 5 5 5-5"></path>
                                                                    <path d="m7 9 5-5 5 5"></path>
                                                                </svg>
                                                            </div>
                                                        </th>
                                                        <th
                                                            class="--exclude-from-ordering px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                            Monto
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-300 dark:divide-neutral-500">
                                                    @php
                                                        $dispersionComplemento = 0;
                                                    @endphp
                                                    @foreach ($empleados as $idEmpleado => $data)
                                                        @php
                                                            $totalComplemento = $dispersion['COMPLEMENTO'][$idEmpleado]['total'] ?? 0;
                                                            $dispersionComplemento += $totalComplemento;
                                                        @endphp
                                                        <tr>
                                                            <td class="px-6 py-2">
                                                                <div class="flex flex-col font-semibold">
                                                                    <div>{{ $data['empleado']->nombre }}</div>
                                                                    <div>{{ $data['empleado']->a_paterno }} {{ $data['empleado']->a_materno }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center font-semibold">
                                                                ${{ number_format($totalComplemento, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @if ($empleados->isEmpty())
                                                        <tr>
                                                            <td colspan="2" class="px-6 py-2 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                                No se encontraron resultados
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="flex items-center justify-between border-t border-gray-200 bg-[#D3D8DB] px-4 py-3 dark:border-neutral-700 dark:bg-neutral-800 sm:px-6"
                                        data-hs-datatable-paging>
                                        <div class="text-sm text-gray-700 dark:text-neutral-300">
                                            <span data-hs-datatable-info>
                                                Mostrando <span class="font-medium" data-hs-datatable-info-from></span>
                                                a <span class="font-medium" data-hs-datatable-info-to></span> de
                                                <span data-hs-datatable-info-length></span> resultados
                                            </span>
                                        </div>
                                        <div class="flex space-x-1">
                                            <button type="button" data-hs-datatable-paging-prev
                                                class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                                                Anterior
                                            </button>
                                            <div class="flex space-x-1" data-hs-datatable-paging-pages></div>
                                            <button type="button" data-hs-datatable-paging-next
                                                class="flex min-w-10 items-center justify-center rounded-full p-2 text-gray-800 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-white dark:hover:bg-neutral-700">
                                                Siguiente
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Complemento -->
                                <div class="flex hidden items-start justify-center">
                                    <div class="mt-20 rounded-2xl border border-gray-300 bg-white p-10 text-center shadow-md dark:border-gray-600 dark:bg-gray-800">
                                        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-100">Total</h2>
                                        <p class="mt-4 text-4xl font-semibold" id="totalComplemento">
                                            ${{ number_format($dispersionComplemento ?? 0, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-40"></div>

    <div id="loadingOverlay" class="fixed inset-0 z-50 flex hidden flex-col items-center justify-center bg-black/60 text-white backdrop-blur-sm">
        <!-- Spinner -->
        <svg class="mb-4 h-12 w-12 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-lg font-medium">Generando reportes...<br>Por favor, no cierres esta página.</p>
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
            const radios = document.querySelectorAll('input[name="viewMode"]');

            // Tables
            const prestacionesFiscal = document.getElementById('prestaciones-fiscal');
            const deduccionesFiscal = document.getElementById('deducciones-fiscal');
            const totalFiscal = document.getElementById('total-fiscal');
            const prestacionesComplemento = document.getElementById('prestaciones-complemento');
            const deduccionesComplemento = document.getElementById('deducciones-complemento');
            const totalComplemento = document.getElementById('total-complemento');

            const dispersionFiscal = document.getElementById('dispersion-fiscal');
            const dispersionComplemento = document.getElementById('dispersion-complemento');

            const dispersionSwitches = document.querySelectorAll('input[type="checkbox"][id^="dispersion"]');

            dispersionSwitches.forEach(sw => {
                sw.addEventListener('change', e => {
                    const checked = e.target.checked;
                    dispersionSwitches.forEach(other => (other.checked = checked));
                    localStorage.setItem('dispersionState', checked);
                    toggleTotal(checked);
                });
            });

            // Restore last mode
            const savedMode = localStorage.getItem('viewMode') || 'prestaciones';
            radios.forEach(r => (r.checked = r.value === savedMode));
            toggleTables(savedMode);

            // Event listener
            radios.forEach(radio => {
                radio.addEventListener('change', e => {
                    const mode = e.target.value;
                    localStorage.setItem('viewMode', mode);
                    toggleTables(mode);
                });
            });

            function toggleVisibility(el, visible) {
                if (!el) return;
                el.classList.replace(visible ? 'opacity-0' : 'opacity-100', visible ? 'opacity-100' : 'opacity-0');
                el.classList.toggle('pointer-events-none', !visible);
            }

            function toggleTables(mode) {
                const showPrest = mode === 'prestaciones';
                const showDed = mode === 'deducciones';
                const showTotal = mode === 'total';

                // Hide/show each group
                toggleVisibility(prestacionesFiscal, showPrest);
                toggleVisibility(prestacionesComplemento, showPrest);

                toggleVisibility(deduccionesFiscal, showDed);
                toggleVisibility(deduccionesComplemento, showDed);

                toggleVisibility(totalFiscal, showTotal);
                toggleVisibility(totalComplemento, showTotal);
            }
            const savedDispersion = localStorage.getItem('dispersionState') === 'true';
            toggleTotal(savedDispersion);

            dispersionSwitches.forEach(sw => {
                sw.addEventListener('change', e => {
                    const checked = e.target.checked;

                    dispersionSwitches.forEach(other => (other.checked = checked));
                    localStorage.setItem('dispersionState', checked);
                    toggleTotal(checked);

                    const activeTab = document.querySelector('[id^="unstyled-tabs-item-"].active');
                    if (activeTab && activeTab.id === 'unstyled-tabs-item-3') {
                        const totalFiscal = document.getElementById('totalFiscal')?.textContent.replace(/\s+/g, '') || '';
                        const totalComplemento = document.getElementById('totalComplemento')?.textContent.replace(/\s+/g, '') || '';
                        document.getElementById('total').textContent = checked ? totalComplemento : totalFiscal;
                    }
                });
            });

            function toggleTotal(checked) {
                toggleVisibility(dispersionFiscal, !checked);
                toggleVisibility(dispersionComplemento, checked);
            }
        });

        document.querySelectorAll('[id^="unstyled-tabs-item-"]').forEach(btn => {
            btn.addEventListener('click', () => {
                const activeId = btn.id; // example: unstyled-tabs-item-3

                let totalFiscal = document.getElementById('totalFiscal').textContent.replace(/\s+/g, '');
                let totalComplemento = document.getElementById('totalComplemento').textContent.replace(/\s+/g, '');

                const isSwitchOn = localStorage.getItem('dispersionState') === 'true';

                const totalBox = document.getElementById('total-box');
                const generarBox = document.getElementById('generar-box');
                const totalDisplay = document.getElementById('total');

                // If tab 3 is active → Show totals
                if (activeId === 'unstyled-tabs-item-3') {
                    totalBox.classList.remove('hidden');
                    generarBox.classList.add('hidden');

                    // Put correct amount depending on switch
                    totalDisplay.textContent = isSwitchOn ? totalComplemento : totalFiscal;
                } else {
                    // Any other tab → hide total box, show button
                    totalBox.classList.add('hidden');
                    generarBox.classList.remove('hidden');
                }
            });
        });


        document.querySelectorAll('.btn-generar').forEach(btn => {
            btn.addEventListener('click', async () => {
                let empleado = btn.dataset.empleado;
                const empleados = JSON.parse(btn.dataset.empleados || '[]');
                const periodo = document.getElementById('periodo').value;

                // Normalize empleado
                if (empleado === "null" || empleado === "") {
                    empleado = null;
                }

                if (empleado) {
                    // Un reporte
                    await handleSingleReport(empleado, periodo);
                } else {
                    // Todos los reportes
                    await handleMultipleReports(empleados, periodo);
                }
            });
        });

        async function handleSingleReport(empleado, periodo) {
            try {
                showLoadingOverlay();

                // Checamos si existe un reporte
                const response = await axios.get(`/rh/nomina/${periodo}/check`, {
                    params: {
                        empleado
                    }
                });
                console.log(response);

                if (!response.data.exists) {
                    Swal.fire({
                        icon: "warning",
                        title: "Reporte no encontrado",
                        text: "No se ha generado el reporte para este empleado.",
                        backdrop: "rgba(0,0,0,0.6)"
                    });
                    return;
                }

                // Descargamos el reporte
                const downloadUrl = `/rh/nomina/${periodo}/reporte/download?path=${encodeURIComponent(response.data.path)}`;
                window.location.href = downloadUrl;

            } catch (error) {
                console.log(error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: error.response?.data?.error || error || "Ocurrió un error.",
                    backdrop: "rgba(0,0,0,0.6)"
                });

            } finally {
                hideLoadingOverlay();
            }
        }

        async function handleMultipleReports(empleados, periodo) {
            try {
                showLoadingOverlay();

                // Checamos si hay reportes creados
                
                const existing = await axios.get(`/rh/nomina/${periodo}/check-all`);

                if (existing.data.exists) {
                    const confirm = await Swal.fire({
                        title: "Reportes ya generados",
                        icon: "warning",
                        text: "Ya existen reportes para este periodo. Si los generas de nuevo serán sobreescritos.",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sobrescribir",
                        cancelButtonText: "Cancelar",
                        backdrop: "rgba(0,0,0,0.6)"
                    });

                    if (!confirm.isConfirmed) {
                        return;
                    }
                }


                // Generamos todos los reportes
                const response = await fetch(`/rh/nomina/${periodo}/reporte`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                if (!response.ok) throw new Error(await response.text());

                Swal.fire({
                    icon: "success",
                    title: "¡Reportes generados!",
                    text: "Los reportes se generaron correctamente.",
                    confirmButtonText: "Aceptar",
                    backdrop: "rgba(0,0,0,0.6)"
                });

            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: error.message,
                    backdrop: "rgba(0,0,0,0.6)"
                });
            } finally {
                hideLoadingOverlay();
            }
        }
    </script>

    <script>
        function showLoadingOverlay() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
            // disable all buttons
            document.querySelectorAll('button, input[type="submit"]').forEach(btn => btn.disabled = true);
        }

        function hideLoadingOverlay() {
            document.getElementById('loadingOverlay').classList.add('hidden');
            // re-enable buttons
            document.querySelectorAll('button, input[type="submit"]').forEach(btn => btn.disabled = false);
        }
    </script>

</x-app-layout>
