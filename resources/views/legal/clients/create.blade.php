<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Cliente') }}
        </h2>
    </x-slot>

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

                        <!-- Tipo de Cliente -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Cliente *</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="physical" checked 
                                           class="form-radio h-5 w-5 text-blue-600" x-model="clientType">
                                    <span class="ml-2 text-gray-700">Persona Física</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="moral" 
                                           class="form-radio h-5 w-5 text-blue-600" x-model="clientType">
                                    <span class="ml-2 text-gray-700">Persona Moral</span>
                                </label>
                            </div>
                        </div>

                        <!-- Información Básica -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-bold mb-2">Nombre/Razón Social *</label>
                                <input id="name" name="name" type="text" required value="{{ old('name') }}" 
                                       class="form-input w-full rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label for="rfc" class="block text-sm font-bold mb-2">RFC *</label>
                                <input id="rfc" name="rfc" type="text" required value="{{ old('rfc') }}" 
                                       class="form-input w-full rounded-md shadow-sm" />
                            </div>
                        </div>

                        <!-- Contacto y Dirección -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="email" class="block text-sm font-bold mb-2">Correo Electrónico *</label>
                                <input id="email" name="email" type="email" required value="{{ old('email') }}" 
                                       class="form-input w-full rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-bold mb-2">Teléfono *</label>
                                <input id="phone" name="phone" type="text" required value="{{ old('phone') }}" 
                                       class="form-input w-full rounded-md shadow-sm" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="address" class="block text-sm font-bold mb-2">Dirección *</label>
                            <textarea id="address" name="address" rows="3" required
                                      class="form-textarea w-full rounded-md shadow-sm">{{ old('address') }}</textarea>
                        </div>

                        <!-- Documentación Persona Física -->
                        <div x-show="clientType === 'physical'" class="mb-6 p-4 border rounded-lg bg-gray-50">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Documentación Persona Física *</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-document-input 
                                    name="ine_front" 
                                    label="INE (Frente) *" 
                                    accept="image/*,.pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="ine_back" 
                                    label="INE (Reverso) *" 
                                    accept="image/*,.pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="rfc_document" 
                                    label="RFC *" 
                                    accept="image/*,.pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="tax_situation" 
                                    label="Constancia de Situación Fiscal *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="compliance_opinion" 
                                    label="Opinión de Cumplimiento *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="fiel_zip" 
                                    label="FIEL (Archivo ZIP) *" 
                                    accept=".zip,.rar"
                                    required />
                            </div>
                        </div>

                        <!-- Documentación Persona Moral -->
                        <div x-show="clientType === 'moral'" class="mb-6 p-4 border rounded-lg bg-gray-50" style="display: none;">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Documentación Persona Moral *</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-document-input 
                                    name="articles_of_incorporation" 
                                    label="Actas Constitutivas *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="assemblies" 
                                    label="Asambleas *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="compliance_opinion_moral" 
                                    label="Opinión de Cumplimiento *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="tax_constancy" 
                                    label="Constancia Fiscal *" 
                                    accept=".pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="legal_representative_ine" 
                                    label="INE Representante Legal *" 
                                    accept="image/*,.pdf"
                                    required />
                                    
                                <x-document-input 
                                    name="fiel_zip_moral" 
                                    label="FIEL (Archivo ZIP) *" 
                                    accept=".zip,.rar"
                                    required />
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-bold mb-2">Notas</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="form-textarea w-full rounded-md shadow-sm">{{ old('notes') }}</textarea>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clientForm', () => ({
                clientType: 'physical',
                
                init() {
                    // Establecer el tipo de cliente si hay un valor antiguo
                    this.clientType = @json(old('type', 'physical'));
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>