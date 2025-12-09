<!-- resources/views/rh/solicitudes/modal/data.blade.php -->
<!-- Modal Sugerencias -->

<!-- Backdrop -->
<div x-show="isModalSugerenciasOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 bg-gray-700 bg-opacity-75 transition-opacity" @click="isModalSugerenciasOpen = false" style="display: none;"></div>
<!-- Modal Contenido -->
<div x-show="isModalSugerenciasOpen" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
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
                    <input type="hidden" id="sugerenciasId" x-model="id">
                    <label class="text-xl font-semibold text-gray-700 dark:text-gray-200" for="nombre">
                        Sugerencias
                    </label>
                </div>
                <button @click="isModalSugerenciasOpen = false" type="button" onclick="clearSugerenciasHistorial()" class="transform rounded-md px-4 py-2 text-sm">
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
                <label for="empleadoSugerencias" class="text-black">Empleado</label>
                <label for="empleadoSugerencias" class="rounded-lg border border-black px-2 py-1 text-black" id="empleadoSugerencias"></label>
            </div>

            <div class="mt-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="sugerenciasSugerencias" class="text-black">Sugerencia:</label>
                    <label for="sugerenciasSugerencias" class="min-h-8 min-w-60 rounded-lg border border-black px-2 py-1 text-black" id="sugerenciasSugerencias"
                        class="block w-full"></label>
                </div>

            </div>

            <hr class="mt-4">
        </div>
        {{-- Footer --}}
        <div class="mt-2 sm:-mx-2 sm:mt-4 sm:flex sm:items-center sm:justify-center sm:gap-10">

            <div class="flex cursor-pointer rounded-lg border bg-blue-500 px-4 py-2 text-white" @click="isModalSugerenciasOpen = false" type="button"
                onclick="clearSugerenciasHistorial()">
                Confirmar
            </div>

        </div>
    </div>
</div>

<script>
    function fillSugerenciasModal(data, tipo) {
        // Some models (like Sugerencias) have nested empleado

        const empleado = `${data.empleado.nombre} ${data.empleado.a_paterno ?? ' '} ${data.empleado.a_materno ?? ' '}`;

        // Fill each field safely
        document.getElementById('empleadoSugerencias').textContent = empleado || ' ';

        document.getElementById('sugerenciasSugerencias').textContent = data.sugerencia || ' ';

    }


    function clearSugerenciasHistorial() {
        document.getElementById('empleadoSugerencias').textContent = ' ';
        document.getElementById('sugerenciasSugerencias').value = ' ';
    }
</script>
