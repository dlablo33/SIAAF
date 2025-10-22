<x-app-layout>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Puestos
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Targeta Principal --}}
            <div class="overflow-hidden bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg">
                {{-- Encabezado de la tarjeta --}}
                <div class="flex items-center justify-between border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                    <div class="flex items-center space-x-4">

                        {{-- Modal Nuevo Puesto --}}
                        <div x-data="{ isOpen: false }" class="relative flex justify-center">
                            <button @click="isOpen = true" id="newPuestoBtn"
                                class="mx-auto transform rounded-md bg-indigo-600 px-4 py-2 capitalize tracking-wide text-white transition-all hover:scale-105 hover:bg-indigo-700">
                                <i class="fas fa-plus-circle mr-2"></i> Nuevo Puesto
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
                                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                                    <div>
                                        Agregar Puestos
                                    </div>
                                    <form method="POST" action="{{ route('rh.puestos.store') }}">
                                        @csrf
                                        <div class="mt-4">
                                            <div>
                                                <label class="text-sm text-gray-700 dark:text-gray-200" for="nombre">Nombre</label>
                                                <div class="-mx-1 mt-2 flex items-center">
                                                    <input type="text" value="{{ old('nombre') }}" id="nombre" name="nombre"
                                                        class="mx-1 block h-10 flex-1 rounded-md border border-gray-200 bg-white px-4 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">
                                                </div>
                                            </div>

                                            <div>
                                                <label for="id_departamento" class="mb-2 block text-sm text-gray-800 dark:text-gray-300">Departamento</label>
                                                <select name="id_departamento" id="id_departamento"
                                                    class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm dark:bg-gray-900 dark:text-gray-300"
                                                    required>
                                                    <option value="" disabled selected class="text-gray-400">Asigna un Departamento</option>

                                                    @foreach ($departamentos as $departamento)
                                                        <option value="{{ $departamento->id }}">{{ $departamento->area->nombre}} - {{  $departamento->nombre }}</option>
                                                    @endforeach
                                                    </optgroup>
                                                </select>
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
                            {{ count($puestos) }} Puestos
                        </span>
                    </div>
                    <div class="relative">
                        <input type="text" id="quickSearch" placeholder="Buscar puesto..."
                            class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                {{-- Tabla --}}
                <div x-data="{ isModalOpen: false, id: '', nombre: '', departamento: '' }" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="puestosTable">
                        <thead class="bg-[#D3D8DB] dark:bg-gray-800">
                            <tr>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="nombrre">
                                    Nombre <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="nombrre">
                                    Area <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="nombrre">
                                    Departamento <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="gerente">
                                    Empleado (?) <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300" scope="col">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#A0B4CB] bg-white dark:bg-gray-700" id="departamentoTableBody">
                            @foreach ($puestos as $puesto)
                                <tr class="hover:bg-gray-2 00 transform transition-all hover:scale-[1.002] dark:hover:bg-gray-600">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $puesto->nombre }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $puesto->departamento->area->nombre }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $puesto->departamento->nombre }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $puesto->puesto?->coordinador ?? 'N/A' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <button
                                                @click="isModalOpen = true; id = '{{ $puesto->id }}'; nombre = '{{ $puesto->nombre }}'; departamento = '{{ $puesto->id_departamento }}'"
                                                id="newPuestoBtn" class="rounded-full p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-900">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="rounded-full p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-900" title="Eliminar"
                                                data-tooltip-target="tooltip-delete" onclick="confirmDelete({{ $puesto->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div>
                        <!-- Backdrop -->
                        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isModalOpen = false"
                            style="display: none;"></div>
                        <!-- Modal Contenido -->
                        <div x-show="isModalOpen" x-transition:enter="transition duration-300 ease-out"
                            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100" x-transition:leave="transition duration-150 ease-in"
                            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                            x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                            class="fixed inset-0 z-20 flex items-center justify-center p-4 sm:p-0" style="display: none;">
                            <div
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                                <div>
                                    Editar Area
                                </div>
                                <div class="mt-4">
                                    <input type="hidden" id="editId" x-model="id">
                                    <label class="text-sm text-gray-700 dark:text-gray-200" for="nombre">Nombre</label>
                                    <div class="-mx-1 mt-2 flex items-center">
                                        <input type="text" x-model="nombre" id="editNombre" name="nombre"
                                            class="mx-1 block h-10 flex-1 rounded-md border border-gray-200 bg-white px-4 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">
                                    </div>
                                </div>
                                <div>
                                    <label for="id_departamento" class="mb-2 block text-sm text-gray-800 dark:text-gray-300">Areas</label>
                                    <select name="id_departamento" id="editDepartamento" x-model="departamento"
                                        class="min-h-10 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm dark:bg-gray-900 dark:text-gray-300"
                                        required>
                                        <option value="" disabled class="text-gray-400">Asigna un Departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->area->nombre}} - {{  $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4 sm:-mx-2 sm:mt-6 sm:flex sm:items-center">
                                    <button @click="isModalOpen = false" type="button"
                                        class="w-full transform rounded-md border border-gray-200 px-4 py-2 text-sm font-medium capitalize tracking-wide text-gray-700 transition-colors duration-300 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 sm:mx-2 sm:w-1/2">
                                        Cancelar
                                    </button>
                                    <button type="button" onclick="editPuesto()"
                                        class="mt-3 w-full transform rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 hover:bg-indigo-700 focus:outline-none sm:mx-2 sm:mt-0 sm:w-1/2">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie de página -->
                <!-- Replace the pagination section with this: -->
                <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3 dark:bg-gray-800 sm:px-6">
                    <div class="flex flex-1 items-center justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            @if ($puestos->count() > 0)
                                Mostrando <span class="font-medium">{{ $puestos->firstItem() }}</span>
                                a
                                <span class="font-medium">{{ $puestos->lastItem() }}</span> de
                                <span class="font-medium">{{ $puestos->total() }}</span> resultados
                            @else
                                No se encontraron resultados
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            @if ($puestos->onFirstPage())
                                <span class="cursor-not-allowed rounded-md bg-gray-100 px-3 py-1 text-gray-400 dark:bg-gray-600">
                                    Anterior
                                </span>
                            @else
                                <a href="{{ $puestos->previousPageUrl() }}"
                                    class="rounded-md bg-white px-3 py-1 text-gray-700 transition-colors hover:bg-gray-50 dark:bg-gray-600">
                                    Anterior
                                </a>
                            @endif

                            @foreach ($puestos->getUrlRange(1, $puestos->lastPage()) as $page => $url)
                                @if ($page == $puestos->currentPage())
                                    <span class="rounded-md bg-indigo-600 px-3 py-1 text-white">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="rounded-md bg-white px-3 py-1 text-gray-700 transition-colors hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($puestos->hasMorePages())
                                <a href="{{ $puestos->nextPageUrl() }}"
                                    class="rounded-md bg-white px-3 py-1 text-gray-700 transition-colors hover:bg-gray-50 dark:bg-gray-600">
                                    Siguiente
                                </a>
                            @else
                                <span class="cursor-not-allowed rounded-md bg-gray-100 px-3 py-1 text-gray-400 dark:bg-gray-600">
                                    Siguiente
                                </span>
                            @endif
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

    @push('scripts')
        <script>
            // Toggle del panel de filtros
            document.getElementById('filterToggle').addEventListener('click', function() {
                const panel = document.getElementById('filterPanel');
                panel.classList.toggle('hidden');
                panel.classList.toggle('show');

                // Cerrar al hacer clic fuera
                if (!panel.classList.contains('hidden')) {
                    setTimeout(() => {
                        document.addEventListener('click', closeFilterPanel);
                    }, 10);
                } else {
                    document.removeEventListener('click', closeFilterPanel);
                }
            });

            function closeFilterPanel(e) {
                const panel = document.getElementById('filterPanel');
                const button = document.getElementById('filterToggle');

                if (!panel.contains(e.target) && !button.contains(e.target)) {
                    panel.classList.add('hidden');
                    panel.classList.remove('show');
                    document.removeEventListener('click', closeFilterPanel);
                }
            }


            // Filtros avanzados
            document.querySelectorAll('.filter-select').forEach(select => {
                select.addEventListener('change', applyFilters);
            });

            document.getElementById('globalSearch').addEventListener('input', applyFilters);

            function applyFilters() {
                const statusFilter = document.querySelector('select.filter-select:nth-of-type(1)').value;
                const typeFilter = document.querySelector('select.filter-select:nth-of-type(2)').value;
                const searchTerm = document.getElementById('globalSearch').value.toLowerCase();

                const rows = document.querySelectorAll('#departamentoTableBody tr');

                rows.forEach(row => {
                    const status = row.querySelector('td:nth-child(5) span').textContent.trim().toLowerCase();
                    const type = row.querySelector('td:nth-child(3) span').textContent.trim().toLowerCase();
                    const name = row.querySelector('td:nth-child(2) div.font-medium').textContent.toLowerCase();
                    const rfc = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                    const statusMatch = !statusFilter ||
                        (statusFilter === 'active' && status === 'activo') ||
                        (statusFilter === 'inactive' && status === 'inactivo') ||
                        (statusFilter === 'pending' && status === 'pendiente');

                    const typeMatch = !typeFilter ||
                        (typeFilter === 'physical' && type === 'física') ||
                        (typeFilter === 'moral' && type === 'moral');

                    const searchMatch = !searchTerm ||
                        name.includes(searchTerm) ||
                        rfc.includes(searchTerm);

                    if (statusMatch && typeMatch && searchMatch) {
                        row.style.display = '';
                        row.classList.add('animate-fadeIn');
                        setTimeout(() => row.classList.remove('animate-fadeIn'), 300);
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Ordenamiento
            document.querySelectorAll('.sortable').forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.getAttribute('data-column');
                    const icon = this.querySelector('i');
                    const isAsc = icon.classList.contains('fa-sort-up');
                    console.log('Entro a sort');

                    // Reset all icons
                    document.querySelectorAll('.sortable i').forEach(i => {
                        i.className = 'fas fa-sort ml-1';
                    });

                    if (isAsc) {
                        icon.className = 'fas fa-sort-down ml-1';
                        sortTable(column, 'desc');
                    } else {
                        icon.className = 'fas fa-sort-up ml-1';
                        sortTable(column, 'asc');
                    }
                });
            });

            function sortTable(column, direction) {
                // Aquí implementarías la lógica de ordenamiento
                // Puedes hacerlo con JavaScript puro o enviar una petición al servidor
                console.log(`Ordenar por ${column} en orden ${direction}`);
                // Por simplicidad, aquí solo mostramos un mensaje, pero en producción
                // deberías implementar el ordenamiento real
            }

            // Animación para el botón nuevo
            document.getElementById('newPuestoBtn').addEventListener('mouseenter', function() {
                this.classList.add('animate-bounce');
            });

            document.getElementById('newPuestoBtn').addEventListener('mouseleave', function() {
                this.classList.remove('animate-bounce');
            });
        </script>
    @endpush

    <script>
        // Filtrado rápido
        document.getElementById('quickSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#departamentoTableBody tr');
            rows.forEach(row => {
                const nombre = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                if (nombre.includes(searchTerm)) {
                    row.style.display = '';
                    row.classList.add('animate-pulse');
                    setTimeout(() => row.classList.remove('animate-pulse'), 300);
                } else {
                    row.style.display = 'none';
                }
            });
        });


        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este departamento?')) {
                axios.post('{{ route('rh.departamentos.destroy', ':id') }}'.replace(':id', id), {
                        _method: 'DELETE', // El metodo destroy necesita DELETE
                        _token: '{{ csrf_token() }}' // Pasamos el token
                    })
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        // Handle error
                        console.error('Error deleting departamento:', error);
                    });
            }
        }

        function editPuesto() {
            let id = document.getElementById('editId').value;
            let nombre = document.getElementById('editNombre').value;
            let departamento = document.getElementById('editDepartamento').value;

            const formData = new FormData();
            formData.append('_method', 'PUT')
            formData.append('nombre', nombre);
            formData.append('id_departamento', departamento);
            console.log(id);
            axios.post(`/rh/puestos/${id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                window.location.reload();
            }).catch(error => {
                console.log('Error updating departamento:', error);
            })
        }
    </script>
</x-app-layout>
