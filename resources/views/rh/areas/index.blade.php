<x-app-layout>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Areas
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Targeta Principal --}}
            <div class="overflow-hidden bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg">
                <div x-data="areaEditor()" x-init="init()" class="overflow-x-auto">
                    <div class="z-10 bg-white shadow-sm hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg"
                        data-hs-datatable='{
                            "pageLength": 10,
                            "pagingOptions": {
                                "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-500 py-2.5 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
                            }
                        }'>
                        <div class="flex items-center justify-between gap-10 border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                            <div class="flex items-center space-x-4">

                                {{-- Modal Nueva Area --}}
                                <div x-data="{ isOpen: false }" class="relative flex justify-center">
                                    <button @click="isOpen = true"
                                        class="mx-auto transform rounded-md bg-indigo-600 px-4 py-2 capitalize tracking-wide text-white transition-all hover:scale-105 hover:bg-indigo-700">
                                        <i class="fas fa-plus-circle mr-2"></i> Nueva Área
                                    </button>

                                    <!-- Backdrop -->
                                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
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
                                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                                            <div>
                                                Agregar Área
                                            </div>
                                            <form method="POST" action="{{ route('rh.areas.store') }}">
                                                @csrf
                                                <div class="mt-4">
                                                    <label class="text-sm text-gray-700 dark:text-gray-200" for="nombre">Nombre</label>
                                                    <div class="-mx-1 mt-2 flex items-center">
                                                        <input type="text" value="{{ old('nombre') }}" id="nombre" name="nombre"
                                                            class="mx-1 block h-10 flex-1 rounded-md border border-gray-200 bg-white px-4 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">
                                                    </div>
                                                </div>

                                                <div class="mt-4 sm:-mx-2 sm:mt-6 sm:flex sm:items-center">
                                                    <button @click="isOpen = false" type="button"
                                                        class="w-full transform rounded-md border border-gray-200 px-4 py-2 text-sm font-medium capitalize tracking-wide text-gray-700 transition-colors duration-300 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 sm:mx-2 sm:w-1/2">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit"
                                                        class="mt-3 w-full transform rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 hover:bg-indigo-700 focus:outline-none sm:mx-2 sm:mt-0 sm:w-1/2">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <span class="rounded-full bg-white px-3 py-1 text-sm text-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-300">
                                    {{ count($areas) }} Áreas
                                </span>
                            </div>
                            <div class="relative" data-hs-datatable-search>
                                <input type="text" placeholder="Buscar..." data-hs-datatable-search-input
                                    class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class=" overflow-scroll">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full">
                                            <thead class="bg-[#D3D8DB] dark:bg-gray-800">
                                                <tr>
                                                    <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="nombrre">
                                                        Nombre <i class="fas fa-sort ml-1"></i>
                                                    </th>
                                                    <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                                        scope="col" data-column="gerente">
                                                        Gerente <i class="fas fa-sort ml-1"></i>
                                                    </th>
                                                    <th class="cursor-default px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                                        scope="col">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-slate-300/ divide-y dark:divide-neutral-500">
                                                @foreach ($areas as $area)
                                                    <tr class="hover:bg-gray-200 transform transition-all hover:scale-[1.002] dark:hover:bg-gray-600">
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            {{ $area->nombre }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            {{ $area->puesto?->gerente ?? 'N/A' }}
                                                        </td>

                                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                                            <div class="flex justify-center space-x-2">
                                                                <button
                                                                    class="edit-btn rounded-full p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-900"
                                                                    data-id="{{ $area->id }}" data-nombre="{{ $area->nombre }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>

                                                                <button class="rounded-full p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-900"
                                                                    title="Eliminar" data-tooltip-target="tooltip-delete" onclick="confirmDelete({{ $area->id }})">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($areas->isEmpty())
                                                    <tr>
                                                        <td class="max-w-4 whitespace-nowrap px-6 py-1 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                            No se encontraron resultados</td>
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

                    <!-- Modal Editar -->
                    <!-- Backdrop -->
                    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isModalOpen = false"
                        style="display: none;"></div>
                    <!-- Modal Contenido -->
                    <div x-show="isModalOpen" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95" x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                        x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                        class="fixed inset-0 z-20 flex items-center justify-center p-4 sm:p-0" style="display: none;">
                        <div
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                            <div>
                                Editar Área
                            </div>
                            <div class="mt-4">
                                <input type="hidden" id="editId" x-model="id">
                                <label class="text-sm text-gray-700 dark:text-gray-200" for="nombre">Nombre</label>
                                <div class="-mx-1 mt-2 flex items-center">
                                    <input type="text" x-model="nombre" id="editNombre" name="nombre"
                                        class="mx-1 block h-10 flex-1 rounded-md border border-gray-200 bg-white px-4 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">
                                </div>
                            </div>
                            <div class="mt-4 sm:-mx-2 sm:mt-6 sm:flex sm:items-center">
                                <button @click="isModalOpen = false" type="button"
                                    class="w-full transform rounded-md border border-gray-200 px-4 py-2 text-sm font-medium capitalize tracking-wide text-gray-700 transition-colors duration-300 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 sm:mx-2 sm:w-1/2">
                                    Cancelar
                                </button>
                                <button type="button" onclick="editArea()"
                                    class="mt-3 w-full transform rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 hover:bg-indigo-700 focus:outline-none sm:mx-2 sm:mt-0 sm:w-1/2">
                                    Guardar
                                </button>
                            </div>
                        </div>
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
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Estas apunto de borrar una área.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirmar"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('{{ route('rh.areas.destroy', ':id') }}'.replace(':id', id), {
                            _method: 'DELETE', // El metodo destroy necesita DELETE
                            _token: '{{ csrf_token() }}' // Pasamos el token
                        })
                        .then(response => {

                            if (response.status === 202) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No se puede borrar.',
                                    text: response?.data?.message,
                                    confirmButtonText: 'Cerrar',
                                    backdrop: "rgb(0 0 0 / 0.6)"
                                });
                            } else if (response.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Borrado con exito'
                                }).then(() =>
                                    window.location.reload());
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting área:', error);
                        });
                }
            });

        }

        function editArea() {
            let id = document.getElementById('editId').value;
            let nombre = document.getElementById('editNombre').value;
            const formData = new FormData();
            formData.append('_method', 'PUT')
            formData.append('nombre', nombre);
            console.log(id);
            axios.post(`/rh/areas/${id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                window.location.reload();
            }).catch(error => {
                console.log('Error updating area:', error);
            })
        }

        function areaEditor() {
            return {
                isModalOpen: false,
                id: '',
                nombre: '',

                init() {
                    document.addEventListener('click', (e) => {
                        const btn = e.target.closest('.edit-btn');
                        if (!btn) return;

                        this.id = btn.dataset.id;
                        this.nombre = btn.dataset.nombre;
                        this.isModalOpen = true;
                    });
                },
            };
        }
    </script>
</x-app-layout>
