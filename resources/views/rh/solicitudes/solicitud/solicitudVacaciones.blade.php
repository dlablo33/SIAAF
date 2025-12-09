<x-app-layout>
    <style>
        * {
            transition: all 0.1s ease !important;
        }
    </style>
    <x-slot name="backButton">
        {{ route('dashboard') }}
    </x-slot>
    <x-slot name="header">
        <div class="items center flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Solicitud de Vacaciones
            </h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl">
        <div class="mt-2 flex-col font-semibold">
            <div class="mt-2 flex flex-col items-center justify-center">
                <label for="empleadoVacaciones" class="text-xl text-black">Empleado</label>
                <input type="text" id="empleadoVacaciones" name="empleadoVacaciones"
                    class="mt-1 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black"
                    value="{{ $user->empleado->nombre . ' ' . $user->empleado->a_paterno . ' ' . $user->empleado->a_materno }}" readonly>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesDisponibles" class="text-xl text-black">Dias Disponibles:</label>
                    <input type="text" id="vacacionesDisponibles" name="vacacionesDisponibles"
                        class="mt-1 block min-h-8 min-w-60 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black" value="{{ $vacacionesDisponibles }}"
                        readonly>

                </div>
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesRestantes" class="text-xl text-black">Dias Restante:</label>
                    <input type="text" id="vacacionesRestantes" name="vacacionesRestantes"
                        class="mt-1 block min-h-8 min-w-60 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black" value="{{ $vacacionesRestantes }}"
                        readonly>

                </div>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesFechas" class="text-xl text-black">Fechas:</label>
                    <input id="vacacionesFechas" name="vacacionesFechas" value="" placeholder="Escoge las fechas... "
                        class="datepicker mt-1 min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-lg text-black">
                </div>
                <div class="flex flex-col items-center justify-center text-lg">
                    <label for="vacacionesSolicitados" class="text-black">Dias Solicitados:</label>
                    <input type="text" id="vacacionesSolicitados" name="vacacionesSolicitados"
                        class="mt-1 block min-h-8 min-w-60 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black" value="" readonly>

                </div>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesConcepto" class="text-xl text-black">Concepto:</label>

                    <select name="vacacionesConcepto" id="vacacionesConcepto"
                        data-hs-select='{
                                "placeholder": "Escoge un concepto...",
                                "toggleClasses": "relative px-2 py-1 ps-4 pe-9 flex gap-x-2 text-nowrap min-w-60 cursor-pointer border border-black rounded-lg text-start text-lg mt-1",
                                "dropdownClasses": "mt-2 z-50 -translate-y-1 w-full max-h-72 min-w-[130px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto ",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer rounded-lg hover:bg-indigo-300 focus:outline-hidden focus:bg-gray-100",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                        class="hidden">
                        <option value="" class=""></option>
                        <option value="GOZADAS">Gozadas</option>
                        <option value="PAGADAS">Pagadas</option>
                    </select>

                </div>
                <div class="flex flex-col items-center justify-center text-center">
                    <label for="vacionesPrima" class="text-xl text-black">Prima</label>
                    <input type="text" id="vacionesPrima" name="vacionesPrima"
                        class="block min-h-8 min-w-60 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black" value="{{ $prima }}" readonly>

                </div>
            </div>

        </div>
        {{-- Footer --}}
        <div class="mt-2 sm:-mx-2 sm:mt-4 sm:flex sm:items-center sm:justify-center sm:gap-10">

            <div class="flex cursor-pointer rounded-lg border bg-blue-500 px-4 py-2 text-xl text-white" onclick="saveVacaciones()">
                Enviar
            </div>
        </div>
    </div>

    <script>
        let inicio;
        let fin;

        document.getElementById('vacacionesFechas').value = "";
        document.getElementById('vacacionesSolicitados').value = "";


        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                mode: "range",
                dateFormat: "Y-m-d", // Formato de fecha
                locale: "es", // Idioma
                allowInput: true, // Con esto se puede validar
            });
        });

        // Dias Usados
        document.getElementById('vacacionesFechas').addEventListener('change', () => {
            const fechas = document.getElementById('vacacionesFechas').value;
            const dias = document.getElementById('vacacionesSolicitados');

            if (fechas.includes('a')) {
                let splitFechas = fechas.split(" a ");
                inicio = new Date(splitFechas[0]);
                fin = new Date(splitFechas[1]);

                let count = 0;
                let current = new Date(inicio);

                while (current <= fin) {
                    const day = current.getDay();
                    if (day !== 6 && day !== 5) {
                        count++;
                    }
                    current.setDate(current.getDate() + 1);
                }

                dias.value = count;
            }
        })

        function saveVacaciones() {
            const concepto = document.getElementById('vacacionesConcepto');
            const prima = document.getElementById('vacionesPrima');

            if (!inicio || !fin) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No se pudo enviar.',
                    html: 'Selecciona un rango de fechas valido',
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.6)'
                });
                return;
            }

            let formData = new FormData();
            formData.append('concepto', concepto.value);
            formData.append('fecha_inicio', inicio.toISOString().split('T')[0]);
            formData.append('fecha_final', fin.toISOString().split('T')[0]);
            formData.append('prima', prima.value);

            axios.post('/rh/solicitud/vacaciones/save', formData)
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitud enviada',
                        html: 'Tu solicitud se ha enviado a RH',
                        background: '#fff',
                        backdrop: 'rgba(0,0,0,0.6)'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.reload();
                        }
                    });

                }).catch(err => {
                    console.error(err);
                });

        }
    </script>

</x-app-layout>
