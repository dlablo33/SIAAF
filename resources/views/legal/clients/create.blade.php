<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Cliente') }}
        </h2>
    </x-slot>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <h3 class="font-bold mb-2">Error en el formulario</h3>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('legal.clients.store') }}" enctype="multipart/form-data">
                        @csrf

<div x-data="{
    loading: false,
    error: null,
    success: false,
    rfc: null,
    curp: null,
    nombre: null,
    fechaEmision: null,
    clientType: 'physical',
    fileSelected: false,

    async uploadRFC(file) {
        if (!file) {
            this.fileSelected = false;
            return;
        }

        // Validaciones básicas
        if (file.size > 5 * 1024 * 1024) {
            this.error = 'El archivo es demasiado grande (máximo 5MB)';
            return;
        }

        if (file.type !== 'application/pdf') {
            this.error = 'Solo se aceptan archivos PDF';
            return;
        }

        this.loading = true;
        this.error = null;
        this.success = false;
        this.fileSelected = true;

        try {
            const formData = new FormData();
            formData.append('Rfc', file); // Nombre exacto del campo según tu webhook

            const response = await fetch('https://automation.geekcollector.mx/webhook/a09e988b-b3e0-4433-9ed9-3f0f06aad54a', {
                method: 'POST',
                body: formData
                // No incluir Content-Type header, FormData lo maneja automáticamente
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();
            
            if (!data.success || !data.data.rfc) {
                throw new Error(data.message || 'No se pudo extraer el RFC');
            }

            // Asignar valores de respuesta
            this.rfc = data.data.rfc;
            this.curp = data.data.curp || '';
            this.nombre = data.data.nombre || '';
            this.fechaEmision = data.data.fecha_emision || '';
            this.clientType = this.determineClientType(data.data.rfc);
            this.success = true;

            // Actualizar campos ocultos del formulario
            this.updateHiddenFields();

        } catch (err) {
            console.error('Error al procesar RFC:', err);
            this.error = err.message || 'Error al procesar el documento RFC';
            this.success = false;
        } finally {
            this.loading = false;
        }
    },

    determineClientType(rfc) {
        // Lógica simple para determinar si es persona moral (empresa)
        // Las personas morales suelen tener 12 caracteres en su RFC
        return rfc.length === 12 ? 'moral' : 'physical';
    },

    updateHiddenFields() {
        document.getElementById('form_rfc').value = this.rfc || '';
        document.getElementById('form_curp').value = this.curp || '';
        document.getElementById('form_nombre').value = this.nombre || '';
        document.getElementById('form_fecha_emision').value = this.fechaEmision || '';
        document.getElementById('form_client_type').value = this.clientType || '';
    },

    resetForm() {
        this.rfc = null;
        this.curp = null;
        this.nombre = null;
        this.fechaEmision = null;
        this.success = false;
        this.error = null;
        this.fileSelected = false;
        this.loading = false;
        
        // Limpiar input file
        const fileInput = document.querySelector('input[type=file][name=rfc_pdf]');
        if (fileInput) fileInput.value = '';
        
        this.updateHiddenFields();
    }
}">
                            <!-- Campos ocultos -->
                            <input type="hidden" id="form_rfc" name="rfc">
                            <input type="hidden" id="form_curp" name="curp">
                            <input type="hidden" id="form_nombre" name="nombre">
                            <input type="hidden" id="form_primer_apellido" name="primer_apellido">
                            <input type="hidden" id="form_segundo_apellido" name="segundo_apellido">
                            <input type="hidden" id="form_fecha_emision" name="fecha_emision">
                            <input type="hidden" id="form_client_type" name="client_type">
                            <input type="hidden" id="form_tax_regime" name="tax_regime">
                            <input type="hidden" id="form_business_name" name="business_name">

                            <!-- Campo para subir el RFC -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2">Subir documento del RFC (PDF) *</label>
                                <input 
                                    type="file" 
                                    name="rfc_pdf"
                                    accept=".pdf" 
                                    @change="uploadRFC($event.target.files[0])"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    x-bind:disabled="loading"
                                    required
                                />
                                <!-- Mensaje cuando no se ha seleccionado archivo -->
                                <p x-show="!fileSelected && !loading" class="text-sm text-gray-500 mt-2">No se eligió ningún archivo</p>
                                <!-- Mensaje de carga -->
                                <p x-show="loading" class="text-sm text-gray-600 mt-2">Procesando RFC...</p>
                                <!-- Mensaje de error -->
                                <p x-show="error" class="text-sm text-red-600 mt-2" x-text="error"></p>
                                <!-- Mensaje de éxito -->
                                <p x-show="success && !loading" class="text-sm text-green-600 mt-2">¡RFC procesado correctamente!</p>
                            </div>

                            <!-- Mostrar datos extraídos -->
                            <div x-show="rfc" x-transition class="mb-6 p-4 border rounded-lg bg-gray-50">
                                <h3 class="font-semibold text-lg text-gray-800 mb-4">Información extraída del RFC</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Tipo de Cliente</label>
                                        <p x-text="clientType === 'physical' ? 'Persona Física' : 'Persona Moral'" 
                                           class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2">RFC</label>
                                        <p x-text="rfc" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div x-show="clientType === 'physical'">
                                        <label class="block text-sm font-bold mb-2">Nombre Completo</label>
                                        <p x-text="`${nombre} ${primerApellido} ${segundoApellido || ''}`.trim()" 
                                           class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div x-show="clientType === 'moral'">
                                        <label class="block text-sm font-bold mb-2">Razón Social</label>
                                        <p x-text="businessName" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Régimen Fiscal</label>
                                        <p x-text="taxRegime" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div x-show="clientType === 'physical'">
                                        <label class="block text-sm font-bold mb-2">CURP</label>
                                        <p x-text="curp || 'No disponible'" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex justify-end">
                                    <button type="button" @click="resetForm()" class="text-sm text-red-600 hover:text-red-800">
                                        Subir otro RFC
                                    </button>
                                </div>
                            </div>

                            <!-- Información adicional requerida -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="email" class="block text-sm font-bold mb-2">Correo Electrónico *</label>
                                    <input id="email" name="email" type="email" required value="{{ old('email') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-bold mb-2">Teléfono *</label>
                                    <input id="phone" name="phone" type="text" required value="{{ old('phone') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="address" class="block text-sm font-bold mb-2">Dirección *</label>
                                <textarea id="address" name="address" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                            </div>

                            <!-- Documentación adicional según tipo de cliente -->
                            <template x-if="clientType === 'physical'">
                                <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Documentación adicional para Persona Física *</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold mb-2">INE (Frente) *</label>
                                            <input type="file" name="ine_front" accept="image/*,.pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">INE (Reverso) *</label>
                                            <input type="file" name="ine_back" accept="image/*,.pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Constancia de Situación Fiscal *</label>
                                            <input type="file" name="tax_situation" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Opinión de Cumplimiento *</label>
                                            <input type="file" name="compliance_opinion" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">FIEL (Archivo ZIP) *</label>
                                            <input type="file" name="fiel_zip" accept=".zip,.rar" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="clientType === 'moral'">
                                <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Documentación adicional para Persona Moral *</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Actas Constitutivas *</label>
                                            <input type="file" name="articles_of_incorporation" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Asambleas *</label>
                                            <input type="file" name="assemblies" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Opinión de Cumplimiento *</label>
                                            <input type="file" name="compliance_opinion_moral" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">Constancia Fiscal *</label>
                                            <input type="file" name="tax_constancy" accept=".pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">INE Representante Legal *</label>
                                            <input type="file" name="legal_representative_ine" accept="image/*,.pdf" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold mb-2">FIEL (Archivo ZIP) *</label>
                                            <input type="file" name="fiel_zip_moral" accept=".zip,.rar" required
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Notas -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-bold mb-2">Notas</label>
                                <textarea id="notes" name="notes" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Botones -->
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('legal.clients.index') }}" 
                                   class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    Guardar Cliente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>