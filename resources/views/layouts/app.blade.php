<!DOCTYPE html>
<html class="" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <style>
        :root {
            --primary: #c1611a;
            --primary-dark: #a05216;
            --secondary: #00404a;
            --secondary-dark: #00333a;
            --dark: #01163d;
            --light: #d3d8db;
            --light-hover: #e9ecef;
            --accent: #9fb3cb;
        }

        /* Transiciones suaves */
        * {
            transition: all 0.3s ease;
        }

        /* Sidebar retráctil */
        .sidebar {
            width: 80px;
            overflow: auto;
            scrollbar-width: none;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.expanded {
            width: 256px;
        }

        .sidebar-content {
            width: 256px;
        }

        /* Logo */
        .logo-container {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
            margin-bottom: 1rem;
        }

        .logo {
            height: 40px;
            transition: all 0.3s ease;
        }

        .sidebar:not(.expanded) .logo {
            height: 35px;
        }

        /* Items de navegación */
        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            color: var(--secondary);
            overflow: hidden;
        }

        /* Íconos siempre visibles */
        .nav-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            min-width: 40px;
            font-size: 1.25rem;
            color: var(--secondary);
            transition: all 0.3s ease;
        }

        .nav-text {
            white-space: nowrap;
            margin-left: 0.75rem;
            transition: opacity 0.3s ease;
        }

        .sidebar:not(.expanded) .nav-text {
            opacity: 0;
            width: 0;
            height: 0;
            overflow: hidden;
            margin-left: 0;
        }

        /* ANIMACIONES ORIGINALES MEJORADAS */
        .nav-item::before {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(193, 97, 26, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .nav-item:hover::before {
            left: 100%;
        }

        .nav-item:hover {
            transform: translateX(5px);
        }

        /* Color al seleccionar */
        .nav-item.active,
        .nav-item.active .nav-icon {
            background-color: var(--primary);
            color: white;
        }

        .nav-item:hover:not(.active) {
            background-color: var(--light-hover);
        }

        /* Tooltips */
        .sidebar:not(.expanded) .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 10px);
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 20;
            font-size: 0.875rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .sidebar:not(.expanded) .nav-item:hover::after {
            opacity: 1;
        }

        /* Botón de toggle */
        .toggle-btn {
            position: absolute;
            right: 10px;
            top: 20px;
            background: var(--primary);
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }

        .toggle-icon {
            transition: transform 0.3s ease;
        }

        .sidebar.expanded .toggle-icon {
            transform: rotate(180deg);
        }

        /* Contenido principal */
        .main-content {
            margin-left: 80px;
            transition: margin-left 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.expanded~.main-content {
            margin-left: 256px;
        }

        /* Efecto de onda MEJORADO */
        .wave-effect {
            position: relative;
            overflow: hidden;
        }

        .wave-effect:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .wave-effect:focus:after,
        .wave-effect:hover:after {
            animation: wave-effect 0.7s ease-out;
        }

        @keyframes wave-effect {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .sidebar-actions .nav-item.text-white {
            color: white !important;
        }

        .sidebar-actions .nav-item.text-white i {
            color: white !important;
        }

        .sidebar-actions .nav-item.hover-white:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* Estilos para el menú */
        .nav-main-item {
            position: relative;
        }

        .nav-main-submenu,
        .nav-sublevel {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        /* Ajustar el padding para que la flecha no se corte */
        .nav-item {
            padding-right: 1.5rem;
            /* Más espacio para la flecha */
        }

        /* Transición suave para las flechas */
        .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Asegurar que los submenús no se salgan del contenedor */
        .nav-main-submenu {
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .nav-main-submenu:not(.hidden) {
            max-height: 1000px;
            /* Valor suficientemente grande */
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen text-gray-800">

        {{-- Sidebar retráctil con botón de toggle --}}
        <aside class="sidebar bg-gray-200 dark:bg-gray-950 flex flex-col justify-between p-5 fixed h-full z-10">
            <button class="toggle-btn ">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="sidebar-content">
                <div class="flex justify-center mb-6 py-2">
                    <img src="{{ asset('img/saafc.png') }}" alt="Logo" class="logo h-10">
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 bg-gray-300 font-semibold text-gray-800"
                        data-tooltip="Dashboard">
                        <i class="fas fa-th-large text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Dashboard</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Dirección">
                        <i class="fas fa-user-tie text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Dirección</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Dirección">
                        <i class="fas fa-shopping-bag text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Gerencia General</span>
                    </a>
                    <!-- ============================================================================================================================ -->

                    <!-- Menú principal Recursos Humanos (ahora desplegable) -->
                    <div class="nav-main-item">
                        <div class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer"
                            data-tooltip="Dirección">
                            <i class="fas fa-users text-lg w-6 text-center"></i>
                            <span class="nav-text ml-3">Recursos Humanos</span>
                            <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                        </div>

                        <!-- Contenedor de submenús principales -->
                        <div class="nav-main-submenu pl-2 hidden">

                            <!-- Submenú Nominas -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    @php
                                        $now = now();
                                        $periodoActual = $now->weekOfYear;
                                    @endphp
                                    <a href="{{ route('rh.nomina.index', ['periodo' => $periodoActual]) }}">
                                        <i class="fas fa-money-check-dollar text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Nomina</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Dispersion -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-calendar-alt text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Dispersion</span>
                                    <i
                                        class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                                </div>

                                <!-- Subniveles de Dispersion -->
                                <div class="nav-sublevel pl-6 hidden">
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-money-bill text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Fiscal</span>
                                    </a>
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-money-bill-1 text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Complemento</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Retardos -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    @php
                                        $now = now();
                                        $periodoActual = $now->weekOfYear;
                                    @endphp
                                    <a href="{{ route('rh.retardos.index', ['periodo' => $periodoActual]) }}">
                                        <i class="fas fa-user-clock text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Retardos</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Prestamos -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-money-bill-transfer text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Prestamos</span>
                                </div>
                            </div>

                            <!-- Submenú Prestamos -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <a href="{{ route('rh.empleados.index') }}">
                                        <i class="fas fa-solid fa-address-card text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Empleados</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Catalogos -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-ellipsis text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Catalogos</span>
                                    <i
                                        class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                                </div>

                                <!-- Subniveles de Citas -->
                                <div class="nav-sublevel pl-6 hidden">
                                    <a href="{{ route('rh.permisoTipo.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-rectangle-list text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Tipos de Permiso</span>
                                    </a>

                                    <a href="{{ route('rh.areas.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-users-rectangle text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Areas</span>
                                    </a>

                                    <a href="{{ route('rh.departamentos.index')}}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-user-group text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Departamentos</span>
                                    </a>

                                    <a href="{{ route('rh.puestos.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-building-user text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Puestos</span>
                                    </a>

                                    <a href="{{ route('rh.empresas.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-city text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Empresas</span>
                                    </a>

                                    <a href="{{ route('rh.documentos.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-file-contract text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Documentos</span>
                                    </a>

                                    <a href="{{ route('rh.prestaciones.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-sack-dollar text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Prestaciones</span>
                                    </a>

                                    <a href="{{ route('rh.deducciones.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-solid fa-sack-xmark text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Deducciones</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menú principal Legal-Fiscal (ahora desplegable) -->
                    <div class="nav-main-item">
                        <div class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer"
                            data-tooltip="Legal">
                            <i class="fas fa-balance-scale text-lg w-6 text-center"></i>
                            <span class="nav-text ml-3">Legal-Fiscal</span>
                            <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                        </div>

                        <!-- Contenedor de submenús principales -->
                        <div class="nav-main-submenu pl-2 hidden">
                            <!-- Submenú Trámites -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-file-alt text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Trámites</span>
                                    <i
                                        class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                                </div>

                                <!-- Subniveles de Trámites -->
                                <div class="nav-sublevel pl-6 hidden">
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-plus-circle text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Nuevo Trámite</span>
                                    </a>
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-tasks text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Trámites Activos</span>
                                    </a>
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-file-signature text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Formatos</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Clientes -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-users text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Clientes</span>
                                    <i
                                        class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                                </div>

                                <!-- Subniveles de Clientes -->
                                <div class="nav-sublevel pl-6 hidden">
                                    <a href="{{ route('legal.clients.create') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-user-plus text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Alta de Clientes</span>
                                    </a>
                                    <a href="{{ route('legal.clients.index') }}"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-address-book text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Clientes</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Submenú Citas -->
                            <div class="nav-subitem pl-6">
                                <div
                                    class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <i class="fas fa-calendar-alt text-lg w-6 text-center"></i>
                                    <span class="nav-text ml-3">Citas</span>
                                    <i
                                        class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"></i>
                                </div>

                                <!-- Subniveles de Citas -->
                                <div class="nav-sublevel pl-6 hidden">
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-calendar-plus text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Nueva Cita</span>
                                    </a>
                                    <a href="#"
                                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-list-alt text-lg w-6 text-center"></i>
                                        <span class="nav-text ml-3">Citas</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>




                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Contabilidad">
                        <i class="fas fa-calculator text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Contabilidad</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Administración">
                        <i class="fas fa-university text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Administración</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Administración">
                        <i class="fas fa-book text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Administración Interna</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Nóminas">
                        <i class="fas fa-money-check-alt text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Nóminas</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Importaciones">
                        <i class="fas fa-truck-loading text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Comercio Exterior</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Comercial">
                        <i class="fas fa-briefcase text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Comercial</span>
                    </a>
                    <a href="#"
                        class="nav-item flex items-center px-4 py-3 rounded-lg hover:bg-gray-300 text-gray-700 dark:text-gray-300"
                        data-tooltip="Dirección">
                        <i class="fas fa-desktop text-lg w-6 text-center"></i>
                        <span class="nav-text ml-3">Sistemas</span>
                    </a>


                </nav>
            </div>

            <div class="featured-box"
                style="
    background-color: #00404a;
    border-radius: 8px;
    padding: 12px;
    margin: 20px 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
">
                <!-- Botón de Opciones -->
                <a href="#"
                    class="nav-item flex items-center px-3 py-2 rounded-lg text-sm text-white hover:bg-opacity-10 hover:bg-white"
                    data-tooltip="Opciones">
                    <i class="fas fa-cog text-lg w-6 text-center text-white"></i>
                    <span class="nav-text ml-3 text-white">Opciones</span>
                </a>

                <!-- Botón de Cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button
                        class="nav-item flex items-center w-full text-left px-3 py-2 rounded-lg text-sm text-white hover:bg-opacity-10 hover:bg-red-500"
                        data-tooltip="Cerrar sesión">
                        <i class="fas fa-sign-out-alt text-lg w-6 text-center text-white"></i>
                        <span class="nav-text ml-3 text-white">Cerrar sesión</span>
                    </button>
                </form>
            </div>

        </aside>
        {{-- Contenido principal --}}
        <div class="main-content flex-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header) && isset($backButton))
                <header class="bg-white shadow-lg dark:bg-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-4">

                             @unless (request()->is('dashboard') || request()->is('dashboard/*'))
                                <a href="{{ $backButton }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500">
                                    <i class="fa-solid fa-arrow-left text-white"></i>
                                </a>
                            @endunless
                        <h1 class="text-2xl font-bold  text-gray-800 animate-slide-in">
                            {{ $header }}
                        </h1>
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.toggle-btn');
            const mainContent = document.querySelector('.main-content');

            // Función para actualizar el estado del sidebar
            function updateSidebarState(isExpanded) {
                // Actualizar clase del sidebar
                sidebar.classList.toggle('expanded', isExpanded);

                // Actualizar localStorage
                localStorage.setItem('sidebarExpanded', isExpanded);

                // Actualizar atributo ARIA para accesibilidad
                toggleBtn.setAttribute('aria-expanded', isExpanded);

                // Opcional: Actualizar margen del contenido principal
                if (mainContent) {
                    mainContent.style.marginLeft = isExpanded ? '260px' : '80px';
                }
            }

            // Toggle sidebar al hacer clic en el botón
            toggleBtn.addEventListener('click', function() {
                const isExpanded = !sidebar.classList.contains('expanded');
                updateSidebarState(isExpanded);
            });

            // Cargar el estado guardado al iniciar
            function loadSavedState() {
                const savedState = localStorage.getItem('sidebarExpanded');
                if (savedState !== null) {
                    updateSidebarState(savedState === 'true');
                } else {
                    // Estado predeterminado para dispositivos móviles
                    const defaultState = window.innerWidth >= 768;
                    updateSidebarState(defaultState);
                }
            }

            loadSavedState();

            // Cerrar sidebar en móvil al hacer clic en un enlace
            function handleMobileBehavior() {
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    item.addEventListener('click', () => {
                        if (window.innerWidth < 768) {
                            updateSidebarState(false);
                        }
                    });
                });
            }

            handleMobileBehavior();

            // Manejar cambios de tamaño de pantalla
            function handleResize() {
                if (window.innerWidth >= 768) {
                    // Restaurar estado guardado en desktop
                    const savedState = localStorage.getItem('sidebarExpanded');
                    if (savedState !== null) {
                        updateSidebarState(savedState === 'true');
                    }
                } else {
                    // Cerrar automáticamente en móvil
                    updateSidebarState(false);
                }
            }

            // Debounce para el evento resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(handleResize, 250);
            });

            // Opcional: Cerrar al hacer clic fuera del sidebar
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768 &&
                    !sidebar.contains(event.target) &&
                    event.target !== toggleBtn) {
                    updateSidebarState(false);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Función para manejar el despliegue de menús
            function setupMenuToggle(triggerSelector, targetSelector) {
                const triggers = document.querySelectorAll(triggerSelector);

                triggers.forEach(trigger => {
                    trigger.addEventListener('click', function(e) {
                        // Evitar que se active si se hace clic en un enlace
                        if (e.target.tagName === 'A') return;

                        const target = this.closest(targetSelector).querySelector(
                            '.nav-main-submenu, .nav-sublevel');
                        if (target) {
                            target.classList.toggle('hidden');

                            // Rotar el ícono de flecha
                            const chevron = this.querySelector('.fa-chevron-down');
                            if (chevron) {
                                chevron.classList.toggle('rotate-180');
                            }
                        }
                    });
                });
            }

            // Configurar todos los niveles de menú
            setupMenuToggle('.nav-main-item > .nav-item', '.nav-main-item');
            setupMenuToggle('.nav-subitem > .nav-item', '.nav-subitem');
        });


    </script>

    <!-- If you're using jQuery version of DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>

</html>
