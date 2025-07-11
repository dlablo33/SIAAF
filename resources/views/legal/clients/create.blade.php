<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Cliente') }}
        </h2>
    </x-slot>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes shimmer {
            0% { background-position: -100% 0; }
            100% { background-position: 100% 0; }
        }
        .shimmer {
            background: linear-gradient(90deg, #e0e0e0 25%, #f8f8f8 50%, #e0e0e0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
        }
    </style>

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
                            primerApellido: null,
                            segundoApellido: null,
                            businessName: null,
                            taxRegime: null,
                            fechaEmision: null,
                            clientType: 'physical',
                            fileSelected: false,
                            requiredDocuments: [],

                            async uploadRFC(file) {
                                if (!file) {
                                    this.fileSelected = false;
                                    return;
                                }

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
                                    formData.append('Rfc', file);

                                    const response = await fetch('https://automation.geekcollector.mx/webhook/a09e988b-b3e0-4433-9ed9-3f0f06aad54a', {
                                        method: 'POST',
                                        body: formData
                                    });

                                    if (!response.ok) {
                                        throw new Error(`Error HTTP: ${response.status}`);
                                    }

                                    const data = await response.json();
                                    
                                    if (!data.success || !data.data.rfc) {
                                        throw new Error(data.message || 'No se pudo extraer el RFC');
                                    }

                                    this.rfc = data.data.rfc;
                                    this.curp = data.data.curp || '';
                                    this.nombre = data.data.nombre || '';
                                    this.primerApellido = data.data.primer_apellido || '';
                                    this.segundoApellido = data.data.segundo_apellido || '';
                                    this.businessName = data.data.businessName || data.data.nombre || '';
                                    this.taxRegime = data.data.taxRegime || '';
                                    this.fechaEmision = data.data.fecha_emision || '';
                                    this.clientType = this.determineClientType(data.data.rfc);
                                    this.requiredDocuments = this.getRequiredDocuments(this.clientType);
                                    this.success = true;

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
                                return rfc && rfc.length === 12 ? 'moral' : 'physical';
                            },

                            getRequiredDocuments(type) {
                                if (type === 'moral') {
                                    return [
                                        { key: 'actas_constitutivas', label: 'Actas Constitutivas', accept: '.pdf', required: true },
                                        { key: 'asambleas', label: 'Asambleas', accept: '.pdf', required: true },
                                        { key: 'opinion_cumplimiento', label: 'Opinión de Cumplimiento', accept: '.pdf', required: true },
                                        { key: 'ine_representante', label: 'INE Representante Legal', accept: 'image/*,.pdf', required: true },
                                        { key: 'fiel_zip', label: 'FIEL (Archivo ZIP)', accept: '.zip,.rar', required: true }
                                    ];
                                } else {
                                    return [
                                        { key: 'ine_frontal', label: 'INE (Frente)', accept: 'image/*,.pdf', required: true },
                                        { key: 'ine_reverso', label: 'INE (Reverso)', accept: 'image/*,.pdf', required: true },
                                        { key: 'opinion_cumplimiento', label: 'Opinión de Cumplimiento', accept: '.pdf', required: true },
                                        { key: 'fiel_zip', label: 'FIEL (Archivo ZIP)', accept: '.zip,.rar', required: true }
                                    ];
                                }
                            },

                            updateHiddenFields() {
                                document.getElementById('form_rfc').value = this.rfc || '';
                                document.getElementById('form_curp').value = this.curp || '';
                                document.getElementById('form_nombre').value = this.nombre || '';
                                document.getElementById('form_primer_apellido').value = this.primerApellido || '';
                                document.getElementById('form_segundo_apellido').value = this.segundoApellido || '';
                                document.getElementById('form_fecha_emision').value = this.fechaEmision || '';
                                document.getElementById('form_client_type').value = this.clientType || '';
                                document.getElementById('form_tax_regime').value = this.taxRegime || '';
                                document.getElementById('form_business_name').value = this.businessName || '';
                            },

                            resetForm() {
                                this.rfc = null;
                                this.curp = null;
                                this.nombre = null;
                                this.primerApellido = null;
                                this.segundoApellido = null;
                                this.businessName = null;
                                this.taxRegime = null;
                                this.fechaEmision = null;
                                this.success = false;
                                this.error = null;
                                this.fileSelected = false;
                                this.loading = false;
                                this.requiredDocuments = [];
                                
                                const fileInput = document.querySelector('input[type=file][name=rfc_pdf]');
                                if (fileInput) fileInput.value = '';
                                
                                this.updateHiddenFields();
                            },

                            getFullName() {
                                if (this.clientType === 'physical') {
                                    return `${this.nombre || ''} ${this.primerApellido || ''} ${this.segundoApellido || ''}`.trim();
                                }
                                return this.businessName || '';
                            }
                        }" x-init="loading = false">
                            <!-- Pantalla de carga -->
                            <div x-show="loading" class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-300">
                                <div class="w-[300px] space-y-4 animate-pulse">
                                    <div class="h-4 bg-gray-300 rounded w-3/4 shimmer"></div>
                                    <div class="flex space-x-4">
                                        <div class="rounded-full bg-gray-300 h-12 w-12 shimmer"></div>
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-gray-300 rounded shimmer"></div>
                                            <div class="h-4 bg-gray-300 rounded w-5/6 shimmer"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="h-4 bg-gray-300 rounded shimmer"></div>
                                        <div class="h-4 bg-gray-300 rounded shimmer"></div>
                                        <div class="h-4 bg-gray-300 rounded w-4/5 shimmer"></div>
                                    </div>
                                </div>
                            </div>

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
                                <p x-show="!fileSelected && !loading" class="text-sm text-gray-500 mt-2">No se eligió ningún archivo</p>
                                <p x-show="loading" class="text-sm text-gray-600 mt-2">Procesando RFC...</p>
                                <p x-show="error" class="text-sm text-red-600 mt-2" x-text="error"></p>
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
                                    <div>
                                        <label class="block text-sm font-bold mb-2" x-text="clientType === 'physical' ? 'Nombre Completo' : 'Razón Social'"></label>
                                        <p x-text="getFullName() || 'No disponible'" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Régimen Fiscal</label>
                                        <p x-text="taxRegime || 'No disponible'" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div x-show="clientType === 'physical'">
                                        <label class="block text-sm font-bold mb-2">CURP</label>
                                        <p x-text="curp || 'No disponible'" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Fecha de Emisión</label>
                                        <p x-text="fechaEmision || 'No disponible'" class="p-2 bg-gray-100 rounded"></p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex justify-end">
                                    <button type="button" @click="resetForm()" class="text-sm text-red-600 hover:text-red-800">
                                        Subir otro RFC
                                    </button>
                                </div>
                            </div>

                            <!-- Información básica del cliente -->
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

                            <!-- Documentación adicional dinámica -->
                            <div x-show="rfc && requiredDocuments.length > 0" class="mb-6 p-4 border rounded-lg bg-gray-50">
                                <h3 class="font-semibold text-lg text-gray-800 mb-4">
                                    Documentación adicional para <span x-text="clientType === 'physical' ? 'Persona Física' : 'Persona Moral'"></span> *
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <template x-for="doc in requiredDocuments" :key="doc.key">
                                        <div>
                                            <label class="block text-sm font-bold mb-2" x-text="doc.label + (doc.required ? ' *' : '')"></label>
                                            <input 
                                                type="file" 
                                                :name="doc.key" 
                                                :accept="doc.accept" 
                                                :required="doc.required"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                            <p class="text-sm text-gray-500 mt-2">No se eligió ningún archivo</p>
                                        </div>
                                    </template>
                                </div>
                            </div>

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