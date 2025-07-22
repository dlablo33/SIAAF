<?php

namespace App\Http\Controllers\Legal;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LegalClientController extends Controller
{
    // Mostrar lista de clientes
    public function index()
    {
        $clients = Client::with('user')->latest()->paginate(15);
        return view('legal.clients.index', compact('clients'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('legal.clients.create');
    }

    // Almacenar nuevo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:physical,moral',
            'name' => 'required|string|max:255',
            'rfc' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'notes' => 'nullable|string'
        ]);

        $client = Client::create($validated + ['user_id' => auth()->id()]);

        // Procesar documentos
        $this->processDocuments($request, $client);

        return redirect()->route('legal.clients.show', $client)
            ->with('success', 'Cliente creado correctamente');
    }

    // Mostrar detalles del cliente
    public function show(Client $client)
    {
        $documentTypes = Client::requiredDocuments($client->type);
        return view('legal.clients.show', compact('client', 'documentTypes'));
    }

    // Mostrar formulario de edición
    public function edit(Client $client)
    {
        $documentTypes = Client::requiredDocuments($client->type);
        return view('legal.clients.edit', compact('client', 'documentTypes'));
    }

    // Actualizar cliente
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rfc' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email,'.$client->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'notes' => 'nullable|string'
        ]);

        $client->update($validated);

        // Procesar documentos
        $this->processDocuments($request, $client);

        return redirect()->route('legal.clients.show', $client)
            ->with('success', 'Cliente actualizado correctamente');
    }

    // Eliminar cliente
    public function destroy(Client $client)
    {
        // Eliminar documentos primero
        if ($client->documents) {
            foreach ($client->documents as $file) {
                Storage::delete($file);
            }
        }

        $client->delete();
        return redirect()->route('legal.clients.index')
            ->with('success', 'Cliente eliminado correctamente');
    }

    // Mostrar documentos
    public function showDocuments(Client $client)
    {
        $documentTypes = Client::requiredDocuments($client->type);
        return view('legal.clients.documents', compact('client', 'documentTypes'));
    }

    // Procesar documentos subidos
    private function processDocuments(Request $request, Client $client)
    {
        $documents = $client->documents ?: [];
        $requiredDocs = array_keys(Client::requiredDocuments($client->type));

        foreach ($requiredDocs as $docKey) {
            $requestKey = $client->type.'_'.$docKey;

            if ($request->hasFile($requestKey)) {
                // Eliminar documento anterior si existe
                if (isset($documents[$docKey])) {
                    Storage::delete($documents[$docKey]);
                }

                // Almacenar nuevo documento
                $file = $request->file($requestKey);
                $filename = Str::slug($client->name).'_'.$docKey.'.'.$file->extension();
                $path = $file->storeAs('client_docs/'.$client->id, $filename);

                $documents[$docKey] = $path;
            }
        }

        $client->documents = $documents;
        $client->checkDocumentStatus();
    }
}
