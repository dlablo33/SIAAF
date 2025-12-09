<x-app-layout>

    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Solicitudes
            </h2>
        </div>
    </x-slot>

    <style>
        * {
            transition: all 0.1s ease !important;
        }
    </style>

    <div  x-data="{
        isModalPermisoOpen: false,
        isModalPrestamoOpen: false,
        isModalVacacionesOpen: false,
        isModalSugerenciasOpen: false,
        id: '',
        nombre: ''
    }" @open-permiso-modal.window="isModalPermisoOpen = true" @open-prestamo-modal.window="isModalPrestamoOpen = true"
        @open-vacaciones-modal.window="isModalVacacionesOpen = true" @open-sugerencias-modal.window="isModalSugerenciasOpen = true">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">

            <div class="mb-2 flex h-32 justify-between gap-x-3 px-4">
                <!-- Permisos -->
                <div
                    class="flex h-full min-w-56 cursor-default flex-col items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-4 text-lg font-semibold shadow-sm">
                    <div class="h-12 w-12 rounded-full bg-[#8987C7] p-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 7V12L14.5 13.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </div>
                    <div>{{ $conteos['Permiso'] ?? '0' }}</div>
                    <div class="text-lg text-gray-700">Permisos</div>
                </div>

                <!-- Préstamos -->
                <div
                    class="flex h-full min-w-56 cursor-default flex-col items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-4 text-lg font-semibold shadow-sm">

                    <div class="h-12 w-12 rounded-full bg-yellow-600 p-2">
                        <svg id="Layer_3" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" data-name="Layer 3">
                            <path d="m22 45v-2h-2v-4h-2v5a1 1 0 0 0 1 1z" />
                            <path
                                d="m19 63h30a1 1 0 0 0 .707-.293l8-8a1 1 0 0 0 .293-.707v-52a1 1 0 0 0 -1-1h-38a1 1 0 0 0 -1 1v29.051a12.987 12.987 0 0 0 0 25.9v5.049a1 1 0 0 0 1 1zm31-3.414v-4.586h4.586zm6-56.586v50h-7a1 1 0 0 0 -1 1v7h-28v-4.051a13 13 0 0 0 9.937-5.949h24.063v-2h-23a12.985 12.985 0 0 0 .64-2h22.36v-2h-22.051c.026-.331.051-.662.051-1s-.025-.669-.051-1h22.051v-2h-22.363a12.985 12.985 0 0 0 -.637-2h23v-2h-24.063a13.052 13.052 0 0 0 -1.578-2h25.641v-2h-28.1a12.885 12.885 0 0 0 -5.9-1.949v-28.051zm-48 41a11 11 0 1 1 11 11 11.013 11.013 0 0 1 -11-11z" />
                            <path
                                d="m29 17a2 2 0 0 1 2 2h2a4 4 0 0 0 -3-3.858v-2.142h-2v2.142a3.992 3.992 0 0 0 1 7.858 2 2 0 1 1 -2 2h-2a4 4 0 0 0 3 3.858v2.142h2v-2.142a3.992 3.992 0 0 0 -1-7.858 2 2 0 0 1 0-4z" />
                            <path d="m36 15h18v2h-18z" />
                            <path d="m36 19h18v2h-18z" />
                            <path d="m36 23h18v2h-18z" />
                            <path d="m36 27h18v2h-18z" />
                            <path d="m25 11h26a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1h-26a1 1 0 0 0 -1 1v4a1 1 0 0 0 1 1zm1-4h24v2h-24z" />
                            <path d="m28 44a9 9 0 1 0 -9 9 9.01 9.01 0 0 0 9-9zm-16 0a7 7 0 1 1 7 7 7.008 7.008 0 0 1 -7-7z" />
                        </svg>
                    </div>
                    <div>{{ $conteos['Préstamo'] ?? '0' }}</div>
                    <div class="text-lg text-gray-700">Préstamos </div>
                </div>

                <!-- Vacaciones -->
                <div
                    class="flex h-full min-w-56 cursor-default flex-col items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-4 text-lg font-semibold shadow-sm">
                    <div class="h-12 w-12 rounded-full bg-yellow-500 p-2.5">
                        <svg version="1.1" class="text-black" fill="currentColor" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                            <g>
                                <rect x="102.583" y="394.18" class="st0" width="117.236" height="21.82" />
                                <rect x="102.583" y="305.684" class="st0" width="160.305" height="21.82" />
                                <rect x="102.583" y="217.205" class="st0" width="228.367" height="21.82" />
                                <rect x="223.312" y="128.726" class="st0" width="107.638" height="21.82" />
                                <path class="st0" d="M392.765,465.44c0,11.228-9.135,20.38-20.375,20.38H61.141c-11.241,0-20.376-9.151-20.376-20.38V175.998
                                H165.32c13.773,0,24.976-11.211,24.976-24.988V26.181h182.093c11.24,0,20.375,9.135,20.375,20.364v147.07l26.185-26.18V46.544
                                C418.949,20.885,398.06,0,372.389,0H183.532c-13.574,0-26.577,5.379-36.164,14.968L29.565,132.78
                                c-9.598,9.591-14.981,22.606-14.981,36.168V465.44c0,25.675,20.89,46.56,46.557,46.56h311.249c25.671,0,46.56-20.885,46.56-46.56
                                V340.23l-26.185,26.181V465.44z M167.021,32.345v104.656c0,11.319-4.41,15.721-15.726,15.721H46.639L167.021,32.345z" />
                                <path class="st0" d="M493.792,206.746l-27.761-27.761c-4.828-4.832-12.66-4.832-17.492,0l-17.998,17.998l45.258,45.253
                                l1 .993-17.997C498.624,219.406,498.624,211.578,493.792,206.746z" />
                                <polygon class="st0" points="262.897,364.632 247.469,425.316 308.15,409.884" />
                                <path class="st0" d="M272.152,355.372l45.257,45.254l150.161-150.157l-45.257-45.262L272.152,355.372z M439.801,243.27
                                L308.973,374.098l-10.285-10.294l130.827-130.828L439.801,243.27z" />
                            </g>
                        </svg>
                    </div>
                    <div>{{ $conteos['Vacaciones'] ?? '0' }}</div>
                    <div class="text-lg text-gray-700">Vacaciones </div>
                </div>

                <!-- Sugerencias -->
                <div
                    class="flex h-full min-w-56 cursor-default flex-col items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-4 text-lg font-semibold shadow-sm">
                    <div class="h-12 w-12 rounded-full bg-blue-500 p-2">
                        <svg id="Layer_1" fill="currentColor" class="text-black" enable-background="new 0 0 66 66" viewBox="0 0 66 66"
                            xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="m62.99 18.9c-.26-7.41-6.32-13.53-13.79-13.92-4.1-.22-7.96 1.2-10.9 3.99-2.28 2.16-3.74 4.92-4.27 7.93h-26.5c-2.5 0-4.53 2.03-4.53 4.53v26.77c0 2.5 2.03 4.53 4.53 4.53h2.83c.72 0 1.37.43 1.66 1.09l2.16 5.03c.46 1.08 1.43 1.87 2.58 2.12.25.05.5.08.75.08.91 0 1.79-.34 2.47-.97l7.4-6.88c.33-.31.77-.48 1.23-.48h16.18c2.5 0 4.53-2.03 4.53-4.53v-3.98c2.65-.44 4.68-2.74 4.68-5.51v-.75h1.69c.5 0 .91-.41.91-.91s-.41-.91-.91-.91h-1.62c.25-2.01 1.33-3.86 3-5.07 3.87-2.83 6.09-7.38 5.92-12.16zm-17.39 1.64h-1.79c-.98 0-1.79-.8-1.79-1.79v-.51c0-.98.8-1.79 1.79-1.79.98 0 1.79.8 1.79 1.79zm3.78 15.6h-1.97v-13.78h1.97zm1.82 0v-13.78h1.79c1.99 0 3.6-1.62 3.6-3.6v-.51c0-1.99-1.62-3.6-3.6-3.6-1.99 0-3.6 1.62-3.6 3.6v2.3h-1.97v-2.3c0-1.99-1.62-3.6-3.6-3.6-1.99 0-3.6 1.62-3.6 3.6v.51c0 1.99 1.62 3.6 3.6 3.6h1.79v13.77h-1.03c-.26-2.57-1.64-4.98-3.8-6.57-3.28-2.41-5.15-6.11-5.15-10.15 0-3.48 1.4-6.72 3.94-9.13 2.58-2.44 5.96-3.69 9.56-3.49 6.54.35 11.84 5.69 12.07 12.17.15 4.18-1.79 8.15-5.19 10.64-2.13 1.56-3.5 3.96-3.76 6.54zm0-15.6v-2.3c0-.98.8-1.79 1.79-1.79.98 0 1.79.8 1.79 1.79v.51c0 .98-.8 1.79-1.79 1.79zm-6.42 30.37h-16.18c-.92 0-1.79.34-2.47.97l-7.4 6.88c-.44.4-1.02.56-1.6.44s-1.05-.51-1.28-1.05l-2.16-5.04c-.57-1.33-1.88-2.2-3.33-2.2h-2.83c-1.49 0-2.71-1.22-2.71-2.71v-26.78c0-1.49 1.22-2.71 2.71-2.71h26.3c-.01.23-.04.47-.04.7 0 4.62 2.15 8.85 5.89 11.61 1.69 1.25 2.79 3.11 3.05 5.11h-1.62c-.5 0-.91.41-.91.91s.41.91.91.91h1.68v.75c0 2.78 2.04 5.08 4.69 5.52v3.97c.01 1.5-1.21 2.72-2.7 2.72zm7.39-12.2c0 2.08-1.69 3.78-3.78 3.78-2.08 0-3.78-1.69-3.78-3.78v-.75h1.89 3.79 1.88z" />
                                <path d="m9.75 25.4h19.56c.5 0 .91-.41.91-.91s-.41-.91-.91-.91h-19.56c-.5 0-.91.41-.91.91.01.5.41.91.91.91z" />
                                <path d="m9.75 32.16h24.95c.5 0 .91-.41.91-.91s-.41-.91-.91-.91h-24.95c-.5 0-.91.41-.91.91.01.5.41.91.91.91z" />
                                <path d="m9.75 38.92h24.95c.5 0 .91-.41.91-.91s-.41-.91-.91-.91h-24.95c-.5 0-.91.41-.91.91.01.5.41.91.91.91z" />
                                <path d="m39.46 43.86h-29.71c-.5 0-.91.41-.91.91s.41.91.91.91h29.7c.5 0 .91-.41.91-.91 0-.51-.4-.91-.9-.91z" />
                            </g>
                        </svg>
                    </div>
                    <div>{{ $conteos['Sugerencias'] ?? '0' }}</div>
                    <div class="text-lg text-gray-700">Sugerencias </div>
                </div>
            </div>

            {{-- Targeta Principal --}}
            <div class="z-10 bg-white shadow-sm hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                data-hs-datatable='{
                            "pageLength": 5,
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

                    <div class="flex gap-2">
                        {{-- Tipo --}}
                        @php
                            $tipo = request('tipo'); // permismo, prestamo, etc. or null
                        @endphp
                        <select id="filtroTipo"
                            data-hs-select='{
                                "placeholder": "Solicitud",
                                "toggleClasses": "relative px-3 py-3 ps-4 pe-9 flex gap-x-2 text-nowrap min-w-[130px] cursor-pointer border border-gray-300 rounded-lg text-start text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200",
                                "dropdownClasses": "mt-2 z-50 -translate-y-1 w-full max-h-72 min-w-[130px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto ",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer rounded-lg hover:bg-indigo-300 focus:outline-hidden focus:bg-gray-100",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                            class="hidden">
                            <option value="">Solicitud</option>
                            <option value="all" {{ $tipo === 'all' ? 'selected' : '' }}>Todas</option>
                            <option value="Permiso" {{ $tipo === 'Permiso' ? 'selected' : '' }}>Permiso</option>
                            <option value="Préstamo" {{ $tipo === 'Préstamo' ? 'selected' : '' }}>Préstamo</option>
                            <option value="Vacaciones" {{ $tipo === 'Vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                            <option value="Sugerencias" {{ $tipo === 'Sugerencias' ? 'selected' : '' }}>Sugerencias</option>
                        </select>

                        {{-- Estatus --}}
                        <select id="filtroEstatus"
                            data-hs-select='{
                                "placeholder": "Estatus",
                                "toggleClasses": "relative px-3 py-3 ps-4 pe-9 flex gap-x-2 text-nowrap min-w-[130px] cursor-pointer border border-gray-300 rounded-lg text-start text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200",
                                "dropdownClasses": "mt-2 z-50 -translate-y-1 w-full max-h-72 min-w-[130px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto ",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer rounded-lg hover:bg-indigo-300 focus:outline-hidden focus:bg-gray-100",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                            class="hidden">
                            <option value="">Estatus</option>
                            <option value="all">Todos</option>
                            <option value="3">Recibido</option>
                            <option value="5">Rechazado</option>
                            <option value="4">Aceptado</option>
                        </select>
                        <div onclick="resetFilter()" class="cursor-pointer rounded-xl bg-red-500 px-4 py-2 text-white">
                            Reset
                        </div>
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
                                                <div class="flex gap-1">
                                                    Empleado
                                                    <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="m7 15 5 5 5-5"></path>
                                                        <path d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>

                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Tipo
                                            </th>
                                            <th class="cursor-default px-6 py-4 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                <div class="flex justify-center gap-1">
                                                    Fecha
                                                    <svg class="size-3.5 shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="m7 15 5 5 5-5"></path>
                                                        <path d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>

                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Estatus
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Ver
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                        @foreach ($solicitudes as $data)
                                            <tr>
                                                <!-- Empleado Info -->
                                                <td class="whitespace-nowrap">
                                                    <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                        @if ($data->tipo === 'Vacaciones')
                                                            {{ $data->empleadoVacaciones->empleado->nombre }} <br>
                                                            {{ $data->empleadoVacaciones->empleado->a_paterno }}
                                                            {{ $data->empleadoVacaciones->empleado->a_materno }}
                                                        @else
                                                            <div>{{ $data->empleado->nombre }}</div>
                                                            <div>{{ $data->empleado->a_paterno }} {{ $data->empleado->a_materno }}</div>
                                                        @endif

                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    @php
                                                        $colors = [
                                                            'Permiso' => 'border-2 border-[#8987C7]',
                                                            'Vacaciones' => 'border-2 border-yellow-500',
                                                            'Préstamo' => 'border-2 border-orange-400',
                                                            'Sugerencias' => 'border-2 border-blue-400',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="{{ $colors[$data->tipo] }} inline-flex w-28 items-center justify-center rounded-xl px-2 py-1 text-base font-semibold text-gray-700">
                                                        {{ $data->tipo }}
                                                    </span>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-500">
                                                    {{ explode(' ', $data->created_at)[0] }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    @php
                                                        $colors = [
                                                            'Recibido' => 'bg-blue-500',
                                                            'Aceptado' => 'bg-green-600',
                                                            'Rechazado' => 'bg-red-400',
                                                            'Activo' => 'bg-gray-400',
                                                            'Inactivo' => 'bg-gray-400',
                                                        ];
                                                    @endphp
                                                    <div class="{{ $colors[$data->estatus->descripcion] }} rounded-lg py-1 font-semibold text-white">
                                                        {{ $data->estatus->descripcion }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button id="open-{{ $data->id }}" data-id="{{ $data->id }}" data-tipo="{{ $data->tipo }}"
                                                        class="rounded-full p-2 text-blue-400 transition-colors hover:text-blue-900">
                                                        <svg fill="currentColor" class="inline-block h-7 w-7 cursor-pointer" viewBox="0 0 22 22"
                                                            xmlns="http://www.w3.org/2000/svg" id="memory-card-text">
                                                            <path d="M17 8V10H5V8H17M5 12H15V14H5V12M2 3H20V4H21V18H20V19H2V18H1V4H2V3M3 5V17H19V5H3Z" />
                                                        </svg>

                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($solicitudes->isEmpty())
                                            <tr>
                                                <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                    No se encontraron resultados</td>
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

            @include('rh.solicitudes.modal.permiso')
            @include('rh.solicitudes.modal.vacaciones')
            @include('rh.solicitudes.modal.prestamo')
            @include('rh.solicitudes.modal.sugerencias')

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

                tr {
                    transition: transform 0.2s, background-color 0.2s;
                }

                .hover\:scale-\[1\.002\]:hover {
                    transform: scale(1.002);
                }
            </style>
        @endpush

        <script>
            function resetFilter() {
                window.location.replace('/rh/solicitud');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const params = new URLSearchParams(window.location.search);

                const tipoParam = params.get('tipo');
                const estadoParam = params.get('estado');

                const filtroTipo = document.getElementById('filtroTipo');
                const filtroEstatus = document.getElementById('filtroEstatus');

                // Apply URL params to selects (if exist)
                if (tipoParam !== null && tipoParam !== '') {
                    filtroTipo.value = tipoParam;
                }

                if (estadoParam !== null && estadoParam !== '') {
                    filtroEstatus.value = estadoParam;
                }


            });


            document.addEventListener('DOMContentLoaded', () => {

                const filtroTipo = document.getElementById('filtroTipo');
                const filtroEstatus = document.getElementById('filtroEstatus');

                function applyFilters() {
                    window.location.replace('/rh/solicitud?tipo=' + filtroTipo.value + "&estado=" + filtroEstatus.value);
                }

                filtroTipo.addEventListener('change', applyFilters);
                filtroEstatus.addEventListener('change', applyFilters);



                document.querySelectorAll('[id^="open"]').forEach(el => {
                    el.addEventListener('click', async () => {


                        const id = el.dataset.id;
                        const row = el.closest('tr');
                        const tipo = row.querySelector('span').textContent.trim();

                        try {
                            if (tipo === 'Permiso') {
                                clearPermisoHistorial();
                                const data = await getHistorial(id, 'Permiso');
                                fillPermisoModal(data);
                                window.dispatchEvent(new CustomEvent('open-permiso-modal'));
                            } else if (tipo === 'Préstamo') {
                                const data = await getHistorial(id, 'Préstamo');
                                fillPrestamoModal(data);
                                window.dispatchEvent(new CustomEvent('open-prestamo-modal'));
                            } else if (tipo === 'Vacaciones') {
                                const data = await getHistorial(id, 'Vacaciones');
                                fillVacacionesModal(data);
                                window.dispatchEvent(new CustomEvent('open-vacaciones-modal'));
                            } else if (tipo === 'Sugerencias') {
                                const data = await getHistorial(id, 'Sugerencias');
                                fillSugerenciasModal(data);
                                window.dispatchEvent(new CustomEvent('open-sugerencias-modal'));
                            }

                        } catch (err) {
                            console.error('Error loading historial:', err);
                        }
                    });
                });

                if (window.HSStaticMethods) {
                    window.HSStaticMethods.autoInit();
                    console.log('Preline inicializado');
                } else {
                    console.error(' Preline no está disponible');
                }
            });

            async function getHistorial(id, tipo) {
                try {
                    const response = await fetch('/rh/solicitud/getSolicitud', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            tipo,
                            id
                        })
                    });

                    if (!response.ok) throw new Error(`Error ${response.status}`);

                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Error fetching solicitud:', error);
                    throw error;
                }
            }
        </script>
</x-app-layout>
