<x-app-layout>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Prestamos
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ isModalOpen: false, id: '', nombre: '' }" @open-modal.window="isModalOpen = true; id = $event.detail.id; nombre = $event.detail.nombre">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
            {{-- Targeta Principal --}}

            <div class="z-10 bg-white shadow-sm hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
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
                                                Tipo
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Pago por Periodo
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Periodo Inicio
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Periodo<br>Fin
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Periodos Pagados
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Periodos Faltantes
                                            </th>

                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Total Pagado
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Total a Pagar
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Ver
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                        @foreach ($prestamos as $data)
                                            <tr>
                                                <!-- Empleado Info -->
                                                <td class="whitespace-nowrap">
                                                    <div class="ml-2 flex flex-col space-y-0 py-2 font-semibold">
                                                        <div>{{ $data->empleado->nombre }}</div>
                                                        <div>{{ $data->empleado->a_paterno }} {{ $data->empleado->a_materno }}</div>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ $data->tipo }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ $data->pago_periodo }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ $data->fecha_inicio }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ $data->fecha_fin }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    @php
                                                        $now = new DateTime();
                                                        $start = new DateTime($data->fecha_inicio);
                                                        $end = new DateTime($data->fecha_fin);

                                                        // total days for passed and remaining periods
                                                        $passedDays = max(0, $start->diff($now)->days);
                                                        $remainingDays = max(0, $now < $end ? $now->diff($end)->days : 0);

                                                        // convert to weeks (rounded down)
                                                        $weeksPassed = floor($passedDays / 7);
                                                        $weeksLeft = floor($remainingDays / 7);

                                                        $nombreCompleto = "{$data->empleado->nombre} {$data->empleado->a_paterno} {$data->empleado->a_materno}";
                                                    @endphp
                                                    {{ $weeksPassed }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-500">
                                                    {{ $weeksLeft }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-500">
                                                    {{ $weeksPassed * $data->pago_periodo }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ ($weeksPassed + $weeksLeft) * $data->pago_periodo }}
                                                </td>
                                                <td class="text-center">

                                                    <button id="open-{{ $data->id }}" data-id="{{ $data->id }}" data-nombre="{{ $nombreCompleto }}"
                                                        onclick="getHistorial<  ()"
                                                        class="rounded-full p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-900">
                                                        <svg class="inline-block h-7 w-7 cursor-pointer" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 3V6M17 3V6M7.10002 20C7.56329 17.7178 9.58104 16 12 16C14.419 16 16.4367 17.7178 16.9 20M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21ZM14 11C14 12.1046 13.1046 13 12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11Z"
                                                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($prestamos->isEmpty())
                                            <tr>
                                                <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                    No se encontraron resultados</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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

            <!-- Modal Historial -->
            <div>
                <!-- Backdrop -->
                <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isModalOpen = false" style="display: none;"></div>
                <!-- Modal Contenido -->
                <div x-show="isModalOpen" x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95" x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95" class="fixed inset-0 z-20 flex items-center justify-center p-4 sm:p-0"
                    style="display: none;">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                        <div x-model="nombre">
                        </div>
                        {{-- Header --}}
                        <div class="mt-4">
                            <input type="hidden" id="permisoId" x-model="id">
                            <label class="text-xl font-semibold text-gray-700 dark:text-gray-200" for="nombre">
                                Historial de Pagos
                            </label>
                            <hr>
                        </div>
                        {{-- Body --}}
                        <div class="mt-2">
                            <table class="min-w-full border">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2 text-left">Fecha</th>
                                        <th class="px-4 py-2 text-left">Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="historialBody" class="divide-y divide-gray-300"></tbody>
                            </table>

                            <hr>
                        </div>
                        {{-- Footer --}}
                        <div class="mt-4 sm:-mx-2 sm:mt-6 sm:flex sm:items-center">
                            <button @click="isModalOpen = false" type="button" onclick="cleanHistorial()"
                                class="w-full transform rounded-md border border-gray-200 bg-blue-500 px-4 py-2 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 sm:mx-2 sm:w-1/2">
                                Confirmar
                            </button>

                        </div>
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
        document.addEventListener('DOMContentLoaded', () => {
 
            document.querySelectorAll('[id^="open"]').forEach(el => {
                el.addEventListener('click', async () => {
                    clearHistorial();
                    const id = el.id.replace('open-', '');
                    const nombre = el.dataset.nombre; 

                    try {
                    await getHistorial(id);

                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: { id, nombre }
                    }));
                } catch (err) {
                    console.error('Error loading historial:', err);
                }
            });
        });

            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
                console.log('Preline inicializado'); // Debug
            } else {
                console.error('❌ Preline no está disponible');
            }
        });
    </script>

    <script>
        async function getHistorial(id) {
            try {
                const response = await axios.get('/rh/prestamos/getHistorial', {
                    params: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = response.data;
                const tbody = document.getElementById('historialBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="2" class="text-center py-2 text-gray-500">
                                No se encontró historial
                            </td>
                        </tr>
                    `;
                    return;
                }
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2">${item.fecha ?? '-'}</td>
                        <td class="px-4 py-2">$${(item.pago ?? 0).toFixed(2) ?? '-'}</td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (error) {
                console.error('Error getting historial:', error);
            }

        }


        function clearHistorial() {
            const tbody = document.getElementById('historialBody');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center py-2 text-gray-400">
                            Cargando...
                        </td>
                    </tr>
                `;
            }
        }
    </script>
</x-app-layout>
