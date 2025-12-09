<x-app-layout>

    <x-slot name="backButton">
        {{ route('rh.prestamos.index') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Calculadora de Prestamo {{ $solicitud->empleado->nombre ?? '' }} {{ $solicitud->empleado->a_paterno ?? '' }}
            </h2>
        </div>
    </x-slot>

    <div class="mx-auto flex max-w-7xl flex-col">
        <div class="mx-auto mt-8 flex gap-2">
            <div class="flex items-center gap-2 px-4">
                <div class="font-semibold">Monto</div>
                <div class="flex items-center">
                    <div class="rounded-l-xl border border-r-0 border-black px-2 py-2 font-semibold">$</div>
                    <input id="monto" type="text" value="{{ $solicitud->monto_pedido ?? '' }}" class="rounded-r-xl">
                </div>

            </div>
            <div class="flex items-center gap-2 px-4">
                <div class="font-semibold">Plazos</div>
                <input id="plazos" type="text" class="rounded-xl">
            </div>
            <div class="flex items-center gap-2 px-4">
                <div class="font-semibold">Interés</div>
                <input id="interes" type="text" class="rounded-xl">
            </div>
            <div class="flex items-center gap-2 px-4">
                <div class="font-semibold">Fecha Disposicion</div>
                <input id="fecha" value="" class="datepicker rounded-xl">
            </div>
        </div>

        <div class="mx-auto mt-8">
            <div onclick="generarTabla()" class="cursor-pointer rounded-3xl bg-blue-500 px-4 py-2 text-white">
                Generar
            </div>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-6" id="tabla"></div>

        <div class="mt-10 flex justify-center">
            <div id="usar" onclick="savePrestamo()" class="hidden cursor-pointer rounded-lg bg-blue-500 px-4 py-2 text-center text-lg font-semibold text-white">
                Usar Esquema
            </div>
        </div>

    </div>

    <script>
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');
        console.log(id);

        function nextThursday(date) {
            const d = new Date(date);
            const day = d.getDay();
            let diff = (3 - day + 7) % 7;
            if (diff === 0) diff = 7;
            d.setDate(d.getDate() + diff);
            return d;
        }

        function add7days(date) {
            const d = new Date(date);
            d.setDate(d.getDate() + 7);
            return d;
        }

        function formatDate(date) {
            return date.toISOString().split("T")[0]; // YYYY-MM-DD
        }

        function generarTabla() {
            const monto = parseFloat(document.getElementById('monto').value);
            const plazos = parseInt(document.getElementById('plazos').value);
            const interes = parseFloat(document.getElementById('interes').value);
            const fechaInicio = document.getElementById('fecha').value;

            const tabla = document.getElementById('tabla');

            if (!fechaInicio || isNaN(monto) || isNaN(plazos) || isNaN(interes)) {
                tabla.innerHTML = "<div class='text-red-500 col-span-2'>Ingresa valores válidos.</div>";
                return;
            }

            const r = interes / 100;
            const pago = (monto * r) / (1 - Math.pow(1 + r, -plazos));

            let restante = monto;

            // Get first Thursday after fechaInicio
            let fechaPago = nextThursday(fechaInicio);

            const rows = [];

            for (let i = 1; i <= plazos; i++) {
                const interesPago = restante * r;
                const capitalPago = pago - interesPago;
                restante -= capitalPago;

                rows.push(`
                <tr>
                    <td class="border p-2 text-center">${i}</td>
                    <td class="border p-2 text-center">${formatDate(fechaPago)}</td>
                    <td class="border p-2 text-right">$${pago.toFixed(2)}</td>
                    <td class="border p-2 text-right">$${interesPago.toFixed(2)}</td>
                    <td class="border p-2 text-right">$${capitalPago.toFixed(2)}</td>
                    <td class="border p-2 text-right">$${Math.max(restante, 0).toFixed(2)}</td>
                </tr>`);

                fechaPago = add7days(fechaPago);
            }

            const mid = Math.ceil(rows.length / 2);
            const leftRows = rows.slice(0, mid).join('');
            const rightRows = rows.slice(mid).join('');

            const tableHeader = `
                <thead>
                    <tr class="bg-[#D3D8DB]">
                        <th class="border p-2">#</th>
                        <th class="border p-2">Fecha</th>
                        <th class="border p-2">Pago</th>
                        <th class="border p-2">Interés</th>
                        <th class="border p-2">Capital</th>
                        <th class="border p-2">Restante</th>
                    </tr>
                </thead>`;

            const tableStart = `<table class="min-w-full border border-gray-400 text-sm">`;
            const tableEnd = `</table>`;

            tabla.innerHTML = `
                <div>${tableStart + tableHeader + "<tbody>" + leftRows + "</tbody>" + tableEnd}</div>
                <div>${tableStart + tableHeader + "<tbody>" + rightRows + "</tbody>" + tableEnd}</div>
            `;

            if (id !== null) {
                document.getElementById("usar").classList.remove('hidden');
            }

        }


        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d", // Formato de fecha
                locale: "es", // Idioma
                allowInput: true, // Con esto se puede validar
            });
        });

        function savePrestamo() {
            let formData = new FormData();
            formData.append('id', id)

        }
    </script>

</x-app-layout>
