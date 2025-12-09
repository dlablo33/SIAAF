<!-- resources/views/rh/solicitudes/modal/vacaciones.blade.php -->
<!-- Modal Vacaciones -->

<!-- Backdrop -->
<div x-show="isModalVacacionesOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isModalVacacionesOpen = false" style="display: none;"></div>
<!-- Modal Contenido -->
<div x-show="isModalVacacionesOpen" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100" x-transition:leave="transition duration-150 ease-in"
    x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100" x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center p-4 sm:p-0" style="display: none;">
    <div
        class="relative transform overflow-hidden rounded-lg bg-white p-4 text-left align-bottom font-semibold shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-xl sm:px-6 sm:align-middle">
        <div x-model="nombre"></div>
        {{-- Header --}}
        <div class="mt-2">
            <div class="flex items-center justify-between">
                <div>
                    <input type="hidden" id="vacacionesId" x-model="id">
                    <label class="text-xl font-semibold text-gray-700 dark:text-gray-200" for="nombre">
                        Solicidud de Vacaciones
                    </label>
                </div>
                <button @click="isModalVacacionesOpen = false" type="button" onclick="clearVacacionesHistorial()" class="transform rounded-md px-4 py-2 text-sm">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.0303 8.96965C9.73741 8.67676 9.26253 8.67676 8.96964 8.96965C8.67675 9.26255 8.67675 9.73742 8.96964 10.0303L10.9393 12L8.96966 13.9697C8.67677 14.2625 8.67677 14.7374 8.96966 15.0303C9.26255 15.3232 9.73743 15.3232 10.0303 15.0303L12 13.0607L13.9696 15.0303C14.2625 15.3232 14.7374 15.3232 15.0303 15.0303C15.3232 14.7374 15.3232 14.2625 15.0303 13.9696L13.0606 12L15.0303 10.0303C15.3232 9.73744 15.3232 9.26257 15.0303 8.96968C14.7374 8.67678 14.2625 8.67678 13.9696 8.96968L12 10.9393L10.0303 8.96965Z"
                            fill="#1C274C" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 1.25C6.06294 1.25 1.25 6.06294 1.25 12C1.25 17.9371 6.06294 22.75 12 22.75C17.9371 22.75 22.75 17.9371 22.75 12C22.75 6.06294 17.9371 1.25 12 1.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75C17.1086 2.75 21.25 6.89137 21.25 12C21.25 17.1086 17.1086 21.25 12 21.25C6.89137 21.25 2.75 17.1086 2.75 12Z"
                            fill="#1C274C" />
                    </svg>
                </button>
            </div>
            <hr>
        </div>
        {{-- Body --}}
        <div class="mt-2 flex-col">
            <div class="mt-2 flex flex-col items-center justify-center">
                <label for="empleadoVacaciones" class="text-black">Empleado</label>
                <label for="empleadoVacaciones" class="rounded-lg border border-black px-2 py-1 text-black" id="empleadoVacaciones"></label>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesDisponibles" class="text-black">Dias Disponibles:</label>
                    <label for="vacacionesDisponibles" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesDisponibles"
                        class="block w-full"></label>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesRestantes" class="text-black">Dias Restante:</label>
                    <label for="vacacionesRestantes" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesRestantes"
                        class="block w-full"></label>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-1 items-center justify-center gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesSolicitados" class="text-black">Dias Solicitados:</label>
                    <label for="vacacionesSolicitados" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesSolicitados"></label>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesInicio" class="text-black">Fecha Inicio:</label>
                    <label for="vacacionesInicio" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesInicio"></label>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesFin" class="text-black">Fecha Fin:</label>
                    <label for="vacacionesFin" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesFin"></label>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="vacacionesConcepto" class="text-black">Concepto:</label>
                    <label for="vacacionesConcepto" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacacionesConcepto"></label>
                </div>
                <div class="flex flex-col items-center justify-center text-center">
                    <label for="vacionesPrima" class="text-black">Prima</label>
                    <label for="vacionesPrima" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="vacionesPrima"></label>
                </div>
            </div>

            <div class="mt-2 flex flex-col items-center justify-center text-center">
                <label for="observacionesVacaciones" class="text-black">Observaciones</label>
                <textarea name="observacionesVacaciones" id="observacionesVacaciones" cols="30" rows="2"></textarea>
            </div>

            <hr class="mt-4">
        </div>
        {{-- Footer --}}
        <div class="mt-2 sm:-mx-2 sm:mt-4 sm:flex sm:items-center sm:justify-center sm:gap-10">

            <div class="flex cursor-pointer rounded-lg border bg-red-700 px-4 py-2 text-white" onclick="buttonVacaciones('Rechazar')">
                Rechazar
            </div>
            <div class="flex cursor-pointer rounded-lg border bg-green-700 px-4 py-2 text-white" onclick="buttonVacaciones('Aceptar')">
                Aceptar
            </div>

        </div>
    </div>
</div>

<script>
    let vacacionesId;

    function fillVacacionesModal(data, tipo) {
        let vacaciones = data.empleado_vacaciones
        const empleado = `${vacaciones.empleado.nombre} ${vacaciones.empleado.a_paterno ?? ' '} ${vacaciones.empleado.a_materno ?? ' '}`;
        vacacionesId = data.id;


        // Fill each field safely
        document.getElementById('empleadoVacaciones').textContent = empleado ?? ' ';

        document.getElementById('vacacionesDisponibles').textContent = vacaciones.vacaciones_disponibles ?? ' ';
        document.getElementById('vacacionesRestantes').textContent = vacaciones.vacaciones_restantes ?? ' ';

        document.getElementById('vacacionesConcepto').textContent = data.concepto ?? ' ';

        const inicio = new Date(data.fecha_inicio);
        const fin = new Date(data.fecha_final);
        const solicitado = Math.floor((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;

        document.getElementById('vacacionesInicio').textContent = inicio.toISOString().split('T')[0] ?? ' ';
        document.getElementById('vacacionesFin').textContent = fin.toISOString().split('T')[0] ?? ' ';

        document.getElementById('vacacionesSolicitados').textContent = solicitado ?? ' ';
        document.getElementById('vacionesPrima').textContent = data.prima ?? ' ';

        document.getElementById('observacionesVacaciones').textContent = data.observaciones ?? ' ';
    }


    function clearVacacionesHistorial() {
        document.getElementById('empleadoVacaciones').textContent = ' ';
        document.getElementById('vacacionesDisponibles').value = ' ';
        document.getElementById('vacacionesRestantes').value = ' ';
        document.getElementById('vacacionesSolicitados').value = ' ';
        document.getElementById('vacacionesInicio').textContent = ' ';
        document.getElementById('vacacionesFin').textContent = ' ';
        document.getElementById('vacacionesConcepto').textContent = ' ';
        document.getElementById('vacionesPrima').value = ' ';
        document.getElementById('observacionesVacaciones').value = ' ';
    }

    function buttonVacaciones(tipo) {
        let msg = "Estas por " + tipo.toLowerCase() + " esta solicitud.";
        Swal.fire({
            title: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmar",
            backdrop: 'rgba(0,0,0,0.3)'
        }).then((result) => {
            if (result.isConfirmed) {
                const dias_solicitados = document.getElementById('vacacionesSolicitados').innerHTML;
                
                axios.post('/rh/solicitud/updateSolicitud', {
                    tipo: tipo,
                    solicitud: 'Vacaciones',
                    id: vacacionesId,
                    dias_solicitados: dias_solicitados
                }).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: `La solicitud fue ${tipo} correctamente`,
                        html: `<span class="font-semibold">${response.data}</span>`,
                        background: '#fff',
                        backdrop: 'rgba(0,0,0,0.6)'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.reload();
                        }
                    });
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al aceptar la solicitud.',
                        html: `<span class="font-semibold">${error.response.data}</span>`,
                        background: '#fff',
                        backdrop: 'rgba(0,0,0,0.6)'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.reload();
                        }
                    });
                });
            }
        });
    }
</script>
