<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Cliente') }}
        </h2>
    </x-slot>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul class="list-disc pl-6 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('legal.clients.store') }}" enctype="multipart/form-data" 
                    x-data="clientForm()" x-init="init()">
                    @csrf

                    {{-- RFC --}}
                    <div class="border rounded-lg p-4 bg-blue-50 mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-blue-700">📄 RFC del Cliente</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700">Subir RFC (PDF)</label>
                                <input type="file" name="rfc_pdf" accept=".pdf"
                                    @change="processRfcFile($event.target.files[0])"
                                    class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
                                           file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" />
                                <p class="text-xs text-gray-500 mt-1">Sube el PDF de tu RFC</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700">RFC Manual</label>
                                <input type="text" id="rfc_manual" name="rfc_manual"
                                    placeholder="Ingresa el RFC manualmente"
                                    maxlength="13" class="w-full border px-3 py-2 rounded-md"
                                    @input.debounce.500ms="onRfcInput($event.target.value)" />
                            </div>
                        </div>

                        <template x-if="loading">
                            <p class="text-blue-600 mt-3">Procesando RFC...</p>
                        </template>
                        <template x-if="error">
                            <p class="text-red-600 mt-3" x-text="error"></p>
                        </template>
                        <template x-if="rfcExists">
                            <p class="text-orange-600 mt-3 font-semibold">⚠️ Este RFC ya existe en el sistema.</p>
                        </template>
                    </div>

                    {{-- Info básica --}}
                    <div x-show="rfc" x-transition class="border rounded-lg p-4 bg-green-50 mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-700">Información del Cliente</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Tipo</label>
                                <input type="text" readonly class="w-full bg-gray-100 border px-3 py-2 rounded-md"
                                    x-bind:value="clientType === 'moral' ? 'Persona Moral' : 'Persona Física'">
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-2">RFC</label>
                                <input type="text" readonly class="w-full bg-gray-100 border px-3 py-2 rounded-md" x-model="rfc">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-2">
                                    <span x-text="clientType === 'moral' ? 'Razón Social' : 'Nombre Completo'"></span>
                                </label>
                                <input type="text" name="name" id="name" required
                                    class="w-full border px-3 py-2 rounded-md"
                                    x-model="clientType === 'moral' ? businessName : fullName">
                            </div>
                        </div>
                    </div>

                    {{-- Contacto --}}
                    <div class="border rounded-lg p-4 mb-6 bg-white">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">📞 Datos de Contacto</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Correo Electrónico *</label>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    class="w-full border px-3 py-2 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Teléfono *</label>
                                <input type="text" name="phone" required value="{{ old('phone') }}"
                                    class="w-full border px-3 py-2 rounded-md">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-bold mb-2">Dirección *</label>
                            <textarea name="address" rows="3" required
                                class="w-full border px-3 py-2 rounded-md">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    {{-- Documentos requeridos --}}
                    <div x-show="requiredDocuments.length > 0" x-transition class="border rounded-lg p-4 bg-yellow-50 mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-yellow-700">
                            Documentos Requeridos (<span x-text="clientType === 'moral' ? 'Persona Moral' : 'Persona Física'"></span>)
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="doc in requiredDocuments" :key="doc.key">
                                <div class="p-3 border rounded bg-white">
                                    <label class="block text-sm font-bold mb-1" x-text="doc.label"></label>
                                    <input type="file" :name="doc.key" :accept="doc.accept" :required="doc.required"
                                        class="block w-full text-sm text-gray-700 file:py-2 file:px-4 file:rounded-md 
                                               file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Notas --}}
                    <div class="border rounded-lg p-4 bg-white mb-6">
                        <label class="block text-sm font-bold mb-2">📝 Notas</label>
                        <textarea name="notes" rows="3"
                            class="w-full border px-3 py-2 rounded-md">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Hidden --}}
                    <input type="hidden" name="rfc" x-model="rfc">
                    <input type="hidden" name="type" x-model="clientType">
                    <input type="hidden" name="document_status" value="pending">

                    {{-- Botones --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('legal.clients.index') }}"
                            class="px-5 py-2 bg-gray-300 rounded-md hover:bg-gray-400 transition">Cancelar</a>
                        <button type="submit" 
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                            x-bind:disabled="!rfc || rfcExists">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
