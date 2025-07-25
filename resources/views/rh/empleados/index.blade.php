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
            {{-- Targeta Principal --}}
            <div class="overflow-hidden bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:bg-gray-700 sm:rounded-t-lg">
                {{-- Encabezado de la tarjeta --}}
                <div class="flex items-center justify-between border-b border-gray-200 bg-white p-4 dark:bg-gray-700">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('rh.empleados.create') }}">
                            <button id="newEmpleadoBtn"
                                class="flex transform items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition-all hover:scale-105 hover:bg-indigo-700">
                                <i class="fas fa-plus-circle mr-2"></i> Nuevo Empleado
                            </button></a>
                        <span class="rounded-full bg-white px-3 py-1 text-sm text-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-300">
                            {{ count($empleados) }} Empleados
                        </span>
                    </div>
                    <div class="relative">
                        <input type="text" id="quickSearch" placeholder="Buscar empleado..."
                            class="w-64 rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:bg-gray-800 dark:text-gray-300">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="empleadosTable">
                        <thead class="bg-[#D3D8DB] dark:bg-gray-800">
                            <tr>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="empleado">
                                    Empleado <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="cumpleaños">
                                    Fecha de Nacimiento <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="puesto">
                                    Puesto <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="ingreso">
                                    Fecha de Ingreso <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="antiguedad">
                                    Años Cumplidos <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="sortable cursor-pointer px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 hover:text-gray-900 dark:text-gray-300"
                                    scope="col" data-column="documentos">
                                    Documentos <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300" scope="col">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#A0B4CB] bg-white dark:bg-gray-700" id="empleadoTableBody">
                            @foreach ($empleados as $empleado)
                                <tr class="hover:bg-gray-2 00 transform transition-all hover:scale-[1.002] dark:hover:bg-gray-600">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $empleado->nombre . ' ' . $empleado->a_paterno . ' ' . $empleado->a_materno }}
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
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        Documentos
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('rh.empleados.show', $empleado) }}"
                                                class="rounded-full p-2 text-indigo-600 transition-colors hover:bg-indigo-50 hover:text-indigo-900" title="Ver"
                                                data-tooltip-target="tooltip-view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rh.empleados.edit', $empleado) }}"
                                                class="rounded-full p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-900" title="Editar"
                                                data-tooltip-target="tooltip-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="rounded-full p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-900" title="Eliminar"
                                                data-tooltip-target="tooltip-delete" onclick="confirmDelete({{ $empleado->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pie de página -->
                <!-- Replace the pagination section with this: -->
                <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3 dark:bg-gray-800 sm:px-6">
                    <div class="flex flex-1 items-center justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            @if ($empleados->count() > 0)
                                Mostrando <span class="font-medium">{{ $empleados->firstItem() }}</span>
                                a
                                <span class="font-medium">{{ $empleados->lastItem() }}</span> de
                                <span class="font-medium">{{ $empleados->total() }}</span> resultados
                            @else
                                No se encontraron resultados
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            @if ($empleados->onFirstPage())
                                <span class="cursor-not-allowed rounded-md bg-gray-100 px-3 py-1 text-gray-400 dark:bg-gray-600">
                                    Anterior
                                </span>
                            @else
                                <a href="{{ $empleados->previousPageUrl() }}"
                                    class="rounded-md bg-white px-3 py-1 text-gray-700 transition-colors hover:bg-gray-50 dark:bg-gray-600">
                                    Anterior
                                </a>
                            @endif

                            @foreach ($empleados->getUrlRange(1, $empleados->lastPage()) as $page => $url)
                                @if ($page == $empleados->currentPage())
                                    <span class="rounded-md bg-indigo-600 px-3 py-1 text-white">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="rounded-md bg-white px-3 py-1 text-gray-700 transition-colors hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($empleados->hasMorePages())
                                <a href="{{ $empleados->nextPageUrl() }}"
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

                const rows = document.querySelectorAll('#empleadoTableBody tr');

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
            document.getElementById('newEmpleadoBtn').addEventListener('mouseenter', function() {
                this.classList.add('animate-bounce');
            });

            document.getElementById('newEmpleadoBtn').addEventListener('mouseleave', function() {
                this.classList.remove('animate-bounce');
            });
        </script>
    @endpush

    <script>
        // Filtrado rápido
        document.getElementById('quickSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#empleadoTableBody tr');
            rows.forEach(row => {
                const empleado = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                if (empleado.includes(searchTerm)) {
                    row.style.display = '';
                    row.classList.add('animate-pulse');
                    setTimeout(() => row.classList.remove('animate-pulse'), 300);
                } else {
                    row.style.display = 'none';
                }
            });
        });


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
    </script>
</x-app-layout>
