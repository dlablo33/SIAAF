<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Clientes') }}
            </h2>
            <div class="relative">
                <div id="filterPanel" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl z-10 p-4 border border-gray-200">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estatus</label>
                        <select class="filter-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                            <option value="pending">Pendiente</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select class="filter-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="physical">Física</option>
                            <option value="moral">Moral</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" id="globalSearch" placeholder="Nombre o RFC..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                <!-- Encabezado de la tarjeta -->
                <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50 to-blue-50">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('legal.clients.create') }}">
                        <button id="newClientBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all flex items-center transform hover:scale-105">
                            <i class="fas fa-plus-circle mr-2"></i> Nuevo Cliente
                        </button></a>
                        <span class="text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">
                            {{ count($clients) }} registros
                        </span>
                    </div>
                    <div class="relative">
                        <input type="text" id="quickSearch" placeholder="Buscar cliente..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Tabla simplificada -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="clientsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 sortable" data-column="id">
                                    ID <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 sortable" data-column="name">
                                    Nombre <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 sortable" data-column="type">
                                    Tipo <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 sortable" data-column="rfc">
                                    RFC <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 sortable" data-column="status">
                                    Estatus <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="clientTableBody">
                            @foreach($clients as $client)
                            <tr class="transition-all hover:bg-gray-50 transform hover:scale-[1.002]">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $client->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $client->name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $client->type == 'physical' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $client->type == 'physical' ? 'Física' : 'Moral' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $client->rfc }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $client->status == 'active' ? 'bg-green-100 text-green-800' :
                                           ($client->status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        @if($client->status == 'active')
                                            Activo
                                        @elseif($client->status == 'inactive')
                                            Inactivo
                                        @else
                                            Pendiente
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('legal.clients.show', $client) }}"
                                           class="text-indigo-600 hover:text-indigo-900 p-2 rounded-full hover:bg-indigo-50 transition-colors"
                                           title="Ver"
                                           data-tooltip-target="tooltip-view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('legal.clients.edit', $client) }}"
                                           class="text-yellow-600 hover:text-yellow-900 p-2 rounded-full hover:bg-yellow-50 transition-colors"
                                           title="Editar"
                                           data-tooltip-target="tooltip-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition-colors"
                                                title="Eliminar"
                                                data-tooltip-target="tooltip-delete"
                                                onclick="confirmDelete({{ $client->id }})">
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
<div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between sm:px-6">
    <div class="flex-1 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            @if($clients->count() > 0)
                Mostrando <span class="font-medium">{{ $clients->firstItem() }}</span> a
                <span class="font-medium">{{ $clients->lastItem() }}</span> de
                <span class="font-medium">{{ $clients->total() }}</span> resultados
            @else
                No se encontraron resultados
            @endif
        </div>
        <div class="flex space-x-2">
            @if ($clients->onFirstPage())
                <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                    Anterior
                </span>
            @else
                <a href="{{ $clients->previousPageUrl() }}" class="px-3 py-1 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                    Anterior
                </a>
            @endif

            @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                @if ($page == $clients->currentPage())
                    <span class="px-3 py-1 rounded-md bg-indigo-600 text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            @if ($clients->hasMorePages())
                <a href="{{ $clients->nextPageUrl() }}" class="px-3 py-1 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                    Siguiente
                </a>
            @else
                <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
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

        // Filtrado rápido
        document.getElementById('quickSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#clientTableBody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const rfc = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (name.includes(searchTerm) || rfc.includes(searchTerm)) {
                    row.style.display = '';
                    row.classList.add('animate-pulse');
                    setTimeout(() => row.classList.remove('animate-pulse'), 300);
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filtros avanzados
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', applyFilters);
        });

        document.getElementById('globalSearch').addEventListener('input', applyFilters);

        function applyFilters() {
            const statusFilter = document.querySelector('select.filter-select:nth-of-type(1)').value;
            const typeFilter = document.querySelector('select.filter-select:nth-of-type(2)').value;
            const searchTerm = document.getElementById('globalSearch').value.toLowerCase();

            const rows = document.querySelectorAll('#clientTableBody tr');

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
        document.getElementById('newClientBtn').addEventListener('mouseenter', function() {
            this.classList.add('animate-bounce');
        });

        document.getElementById('newClientBtn').addEventListener('mouseleave', function() {
            this.classList.remove('animate-bounce');
        });

        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
                // Aquí iría la lógica para eliminar el cliente
                console.log(`Eliminar cliente con ID: ${id}`);
            }
        }
    </script>
    @endpush
</x-app-layout>
