<x-app-layout>
@vite(['resources/js/rh/nomina/nomina.js'])

    <div class="border-r border rounded-xl max-w-sm p-2 flex flex-wrap shadow-md">
        <h1 class="mt-2">Periodo {{ $periodo }}</h2>
        <div class="ml-4">
            <h4>Fecha de Periodo: 19 - 25 Mayo 2025</h2>
            <h4>Fecha Nomina: Jueves, 29 Mayo 2025</h2>
        </div>
    </div>

    <div id="nomina" class="mt-4">
        <index></index>
    </div>


</x-app-layout>
