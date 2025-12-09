<x-app-layout>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Empleados
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="z-10 bg-white shadow-sm hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                <div class="flex items-center justify-between border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('rh.empleados.create') }}">
                            <button id="newEmpleadoBtn"
                                class="flex transform items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition-all hover:scale-105 hover:bg-indigo-700">
                                <i class="fas fa-plus-circle mr-2"></i> Nuevo Empleado
                            </button></a>
                        <span class="rounded-full bg-white px-3 py-1 text-sm text-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-300">
                            {{ $empleadosCount }} Empleados
                        </span>
                    </div>
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
                                            <th class="cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                scope="col" data-column="empleado">
                                                Empleado
                                            </th>
                                            <th class="cursor-pointer px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Fecha de Nacimiento
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Puesto
                                            </th>
                                            <th class="cursor-pointer px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Fecha de Ingreso
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Años Cumplidos
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Documentos
                                            </th>
                                            <th class="--exclude-from-ordering cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                scope="col" data-column="total">
                                                Ver
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                        @foreach ($empleados as $empleado)
                                            <tr class="hover:bg-gray-2 00 transform transition-all hover:scale-[1.002] dark:hover:bg-gray-600">
                                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $empleado->a_paterno . ' ' . $empleado->a_materno . ' ' . $empleado->nombre }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $empleado->fecha_nacimiento }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $empleado->id_puesto }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $empleado->fecha_ingreso }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    @php
                                                        $año_entrada = $empleado->fecha_ingreso;
                                                        $antiguedad = date('Y') - date('Y', strtotime($año_entrada));
                                                    @endphp
                                                    {{ $antiguedad }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-900 dark:text-gray-300">
                                                    Documentos
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('rh.empleados.show', $empleado) }}"
                                                            class="rounded-full p-2 text-indigo-600 transition-colors hover:bg-indigo-50 hover:text-indigo-900"
                                                            title="Ver" data-tooltip-target="tooltip-view">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('rh.empleados.edit', $empleado) }}"
                                                            class="rounded-full p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-900"
                                                            title="Editar" data-tooltip-target="tooltip-edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="rounded-full p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-900"
                                                            title="Eliminar" data-tooltip-target="tooltip-delete" onclick="confirmDelete({{ $empleado->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($empleados->isEmpty())
                                            <tr>
                                                <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                    No se encontraron resultados</td>
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
        document.addEventListener('DOMContentLoaded', () => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
                console.log('Preline inicializado');
            } else {
                console.error(' Preline no está disponible');
            }
        });
    </script>
</x-app-layout>
