<template>
    <div>
        <v-card>
            <v-tabs color="#00404a" v-model="tab" align-tabs="center" grow>

                <v-tab>
                    Nómina Fiscal
                </v-tab>

                <v-tab>Complemento</v-tab>
                <v-tab>Total</v-tab>
            </v-tabs>
        </v-card>

        <v-tabs-window v-model="tab">
            <v-tabs-window-item>
                <div class="mt-2 p-4 bg-gray-50">
                    <table class="w-full text-left">
                        <thead class="text-white-100 bg-gray-50">
                            <tr>
                                <th class="px-2 py-1">Empleado</th>
                                <th class="px-2 py-1">Sueldo</th>
                                <th class="px-2 py-1">7mo Dia</th>
                                <th class="px-2 py-1">Puntualidad</th>
                                <th class="px-2 py-1">Asistencia</th>
                                <th class="px-2 py-1">Despensa</th>
                                <th class="px-2 py-1">Extras</th>
                                <th class="px-2 py-1">Vacaciones</th>
                                <th class="px-2 py-1">Prima Vacacional</th>
                                <th class="px-2 py-1">Devoluciones</th>
                                <th class="px-2 py-1">Total</th>
                                <th class="px-2 py-1">Dias</th>
                                <th class="px-2 py-1">Cotizados</th>
                                <th class="px-2 py-1">Pagados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-1200 whitespace-nowrap">Acosta Leal Cesar
                                    Agusto
                                </td>
                                <td class="px-2 py-2">$5000</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">6100</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Alexander Guerra
                                    Pamela
                                </td>
                                <td class="px-2 py-2">$5000</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">6100</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Burciaga Ruiz
                                    Norma
                                    Patricia</td>
                                <td class="px-2 py-2">$5000</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$200</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">6100</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </v-tabs-window-item>

            <v-tabs-window-item>
                <div class="mt-2 p-4 bg-gray-50">
                    <table class="w-full text-left">
                        <thead class="text-white-100 bg-gray-50">
                            <tr>
                                <th class="px-2 py-1">Empleado</th>
                                <th class="px-2 py-1">Sueldo</th>
                                <th class="px-2 py-1">7mo Dia</th>
                                <th class="px-2 py-1">Puntualidad</th>
                                <th class="px-2 py-1">Asistencia</th>
                                <th class="px-2 py-1">Despensa</th>
                                <th class="px-2 py-1">Extras</th>
                                <th class="px-2 py-1">Vacaciones</th>
                                <th class="px-2 py-1">Prima Vacacional</th>
                                <th class="px-2 py-1">Devoluciones</th>
                                <th class="px-2 py-1">Total</th>
                                <th class="px-2 py-1">Dias</th>
                                <th class="px-2 py-1">Cotizados</th>
                                <th class="px-2 py-1">Pagados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-1200 whitespace-nowrap">Acosta Leal Cesar
                                    Agusto
                                </td>
                                <td class="px-2 py-2">$2000</td>
                                <td class="px-2 py-2">$250</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">2750</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Alexander Guerra
                                    Pamela
                                </td>
                                <td class="px-2 py-2">$2000</td>
                                <td class="px-2 py-2">$250</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">2750</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Burciaga Ruiz
                                    Norma
                                    Patricia</td>
                                <td class="px-2 py-2">$2000</td>
                                <td class="px-2 py-2">$250</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$100</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">$0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">2750</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                                <td class="px-2 py-2">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </v-tabs-window-item>

            <v-tabs-window-item>
                <div class=" mt-2 p-4 bg-gray-50">
                    <table class="w-full text-left">
                        <thead class="text-white-100 bg-gray-50">
                            <tr>
                                <th class="px-2 py-1">Empleado</th>
                                <th class="px-2 py-1">Total Percepciones</th>
                                <th class="px-2 py-1">Total Deducciones</th>
                                <th class="px-2 py-1">Neto Real Percepciones</th>
                                <th class="px-2 py-1">Total Fiscal Percepciones</th>
                                <th class="px-2 py-1">ISR e IMSS</th>
                                <th class="px-2 py-1">Complemento Neto a Pagar</th>
                                <th class="px-2 py-1">Neto Fiscal a Pagar</th>
                                <th class="px-2 py-1">Recibo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-1200 whitespace-nowrap">Acosta Leal Cesar
                                    Agusto
                                </td>
                                <td class="px-2 py-2">$11700</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$5600</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-2">$350</td>
                                <td class="px-2 py-2">$2750</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-1">
                                    <button class="items-center justify-center px-3 bg-blue-600 rounded-xl select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#e3e3e3">
                                            <path
                                                d="M280-280h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm-80 480q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Alexander Guerra
                                    Pamela
                                </td>
                                <td class="px-2 py-2">$11700</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$5600</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-2">$350</td>
                                <td class="px-2 py-2">$2750</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-1">
                                    <button class="items-center justify-center px-3 bg-blue-600 rounded-xl select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#e3e3e3">
                                            <path
                                                d="M280-280h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm-80 480q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white ">
                                <td class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap">Burciaga Ruiz
                                    Norma
                                    Patricia</td>
                                <td class="px-2 py-2">$11700</td>
                                <td class="px-2 py-2">$500</td>
                                <td class="px-2 py-2">$5600</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-2">$350</td>
                                <td class="px-2 py-2">$2750</td>
                                <td class="px-2 py-2">$6100</td>
                                <td class="px-2 py-1">
                                    <button type="button" class="">
                                        <button
                                            class="items-center justify-center px-3 bg-blue-600 rounded-xl select-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#e3e3e3">
                                                <path
                                                    d="M280-280h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm-80 480q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                            </svg>
                                        </button>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </v-tabs-window-item>
        </v-tabs-window>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tab: 0,
        }
    }
}
</script>

<style>
v-tab:active {
    background-color: #c1611a;
}
</style>
