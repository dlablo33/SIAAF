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
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                Solicitude de Prestamo
            </h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl">
        <div class="mt-2 flex-col font-semibold">
            <div class="m-2 flex flex-col items-center justify-center">
                <label for="prestamoEmpleado" class="text-xl text-black">Empleado</label>
                <input type="text" id="prestamoEmpleado" name="prestamoEmpleado" class="py1 mt-1 rounded-lg border border-black bg-gray-100 px-4 text-lg text-black"
                    value="{{ $user->empleado->nombre . ' ' . $user->empleado->a_paterno . ' ' . $user->empleado->a_materno }}" readonly>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <label for="prestamoFecha" class="text-xl text-black">Fecha</label>
                    <input id="prestamoFecha" name="prestamoFecha" value="" placeholder="Escoge la fecha de entrega..."
                        class="datepicker mt-1 block min-h-8 min-w-60 rounded-lg border border-black bg-gray-100 px-4 py-1 text-lg text-black">
                </div>
                <div class="flex flex-col items-center justify-center">
                    <label for="prestamoCantidad" class="text-xl text-black">Cantidad Pedida</label>
                    <div class="flex items-center">
                        <div class="flex min-h-8 items-center rounded-l-xl border border-r-0 border-black bg-gray-100 px-2 py-1 text-lg font-semibold">
                            $
                        </div>
                        <input type="text" id="prestamoCantidad" name="prestamoCantidad"
                            class="min-h-8 min-w-60 rounded-r-xl border border-black bg-gray-100 px-4 py-1 text-lg text-black">
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-2 sm:-mx-2 sm:mt-4 sm:flex sm:items-center sm:justify-center sm:gap-10">
                <div class="flex cursor-pointer rounded-lg border bg-blue-500 px-4 py-2 text-xl text-white" onclick="savePrestamo()">
                    Enviar
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                locale: "es",
                allowInput: true,
            })
        })

        function savePrestamo() {

            let fecha = document.getElementById('prestamoFecha').value;
            let cantidad = document.getElementById('prestamoCantidad').value;

            const formData = new FormData();
            formData.append('fecha', fecha);
            formData.append('monto_pedido', cantidad);

            axios.post('/rh/solicitud/prestamo/save', formData)
                .then(response => {
                    console.log(response.status);

                    if (response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Solicitud Enviada',
                            html: '<span class="font-semibold">Tu solicitud se ha enviado a RH</span>',
                            background: '#fff',
                            backdrop: 'rgba(0,0,0,0.6)'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.reload();
                            }
                        });
                    } else if (response.status == 202) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: `<span class="font-semibold">${response.data}</span>`,
                            background: '#fff',
                            backdrop: 'rgba(0,0,0,0.6)'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.reload();
                            }
                        });
                    }
                }).catch(err => {
                    console.error(err);
                })
        }
    </script>
</x-app-layout>
