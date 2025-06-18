<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Accion Administrativa Y Fiscal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'instrument-sans', sans-serif;
                background-color: #fdfdfc;
                color: #1b1b18;
            }
        </style>
    @endif

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.7s ease-out forwards;
        }
        .contact-icon {
            transition: all 0.3s ease;
        }
        .contact-icon:hover {
            transform: translateY(-3px) scale(1.1);
        }
        .whatsapp-bg {
            background-color: #25D366;
        }
        .linkedin-bg {
            background-color: #0077B5;
        }
        .email-bg {
            background: linear-gradient(135deg, #D44638, #EA4335);
        }

        @keyframes fade-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.fade-up {
    animation: fade-up 0.8s ease-out both;
}
.linkedin-bg {
    background: #0077b5;
}
.whatsapp-bg {
    background: #25D366;
}
.email-bg {
    background: #ea4335;
}
.contact-icon:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.contact-minimal-icon {
    color: #00404a;
    background-color: #f1f5f9;
    border: 1px solid #d1d5db;
    transition: all 0.3s ease;
}
.contact-minimal-icon:hover {
    background-color: #e2e8f0;
    color: #022e35;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
    </style>
</head>
<body class="bg-[#c1611a] dark:bg-[#01163d] text-[#1b1b18] flex flex-col items-center p-6 lg:p-8 min-h-screen">

    <!-- Header -->
    <header class="w-full max-w-7xl mb-6 text-sm animate-fade-in">
        @if (Route::has('login'))
            <nav class="flex justify-end items-center gap-4 p-4 rounded-xl shadow-lg bg-[#01163d]">
                @auth

                @else
                    @if (Route::has('register'))
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Cuerpo Principal -->
    <div class="w-full max-w-7xl h-auto lg:h-[80vh] flex flex-col lg:flex-row rounded-xl overflow-hidden shadow-xl animate-fade-in bg-white">

        <!-- Lado Izquierdo - Imagen con overlay -->
        <div class="relative w-full lg:w-1/2 h-64 lg:h-auto bg-cover bg-center group overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-[#01163d]/80 to-[#c1611a]/30 z-10"></div>
            <img src="{{ asset('img/Fondo.png') }}" alt="Imagen descriptiva" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            
            <div class="absolute bottom-0 left-0 p-8 z-20 text-white">
                <h2 class="text-2xl lg:text-3xl font-bold mb-2">¿Nuevo en nuestra plataforma?</h2>
                <p class="text-[#d3d8db] max-w-md">Descubre cómo podemos ayudarte a alcanzar tus objetivos</p>
            </div>
        </div>

        <!-- Lado Derecho - Contenido -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 lg:p-10">
            <div class="w-full max-w-md space-y-8">
                <!-- Sección para clientes existentes -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-[#00404a]">Bienvenido</h1>
                    <p class="text-[#01163d] mt-2">Accede a tu cuenta o regístrate para continuar.</p>
                </div>
                
                <!-- Botones de acceso -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2 rounded-md text-[#01163d] bg-[#d3d8db] hover:bg-[#c1611a] hover:text-white
                                  transition-transform duration-300 hover:scale-105 shadow-md">
                            Acceder
                        </a>
                    @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-6 py-2 rounded-md text-white bg-[#00404a] hover:bg-[#022e35]
                                      transition-transform duration-300 hover:scale-105 shadow-md">
                                Registrarse
                            </a>
                    @endif
                </div>
                
                <!-- Separador -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#d3d8db]"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-[#00404a] text-sm">¿No eres cliente aún?</span>
                    </div>
                </div>
                
                <!-- Sección para no clientes -->
                <!-- Sección Cotización con más diseño -->
<div class="text-center bg-gradient-to-br from-[#f8f9fa] to-[#e6edf2] p-8 rounded-2xl border border-[#d3d8db] shadow-xl fade-up">
    <h3 class="text-2xl font-bold text-[#00404a] mb-4">¿Listo para dar el siguiente paso?</h3>
    <p class="text-[#01163d] mb-6 text-sm md:text-base">Solicita una cotización personalizada y descubre todos nuestros servicios</p>
    
    <a href="#" 
       class="inline-flex items-center justify-center btn-primary py-3 px-8 rounded-full bg-[#00404a] hover:bg-[#022e35] text-white font-semibold
              transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
        Solicitar Cotización
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </a>
</div>

<div class="text-center mt-12 fade-up">
    <h4 class="text-base font-medium text-[#00404a] mb-3">También puedes contactarnos por</h4>
    <div class="flex justify-center gap-4">
        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/company/acci%C3%B3n-administrativa-y-fiscal/" target="_blank" 
           class="contact-minimal-icon w-10 h-10 rounded-md flex items-center justify-center text-sm shadow-sm hover:shadow-md">
            <i class="fab fa-linkedin-in"></i>
        </a>

        <!-- WhatsApp -->
        <a href="https://wa.me/528112905775" target="_blank" 
           class="contact-minimal-icon w-10 h-10 rounded-md flex items-center justify-center text-sm shadow-sm hover:shadow-md">
            <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Correo -->
        <a href="mailto:csaucedo@aaf.mx" 
           class="contact-minimal-icon w-10 h-10 rounded-md flex items-center justify-center text-sm shadow-sm hover:shadow-md">
            <i class="fas fa-envelope"></i>
        </a>
    </div>
</div>
            </div>
        </div>
    </div>

</body>
</html>