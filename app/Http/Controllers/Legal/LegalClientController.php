<?php

namespace App\Http\Controllers\Legal;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\StoreLegalClientRequest; // Lo crearemos después
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;


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

public function store(Request $request)
{
    $request->validate([
        'rfc_pdf' => 'required|mimes:pdf|max:5120', // Máx 5MB
    ]);

    try {
        // 1️⃣ Guardar PDF temporalmente
        $pdf = $request->file('rfc_pdf');
        $fileName = Str::uuid() . '.' . $pdf->getClientOriginalExtension();
        $pdfPath = $pdf->storeAs('clients/rfc_docs', $fileName, 'public');

        // 2️⃣ Convertir PDF a imagen (para OCR)
        $tempImage = storage_path('app/temp_' . Str::random(10) . '.png');
        $command = "pdftoppm " . storage_path('app/public/' . $pdfPath) . " " . $tempImage . " -png -singlefile";
        shell_exec($command);

        // 3️⃣ Extraer texto con Tesseract OCR
        $ocr = new TesseractOCR($tempImage);
        $ocr->lang('spa'); // idioma español
        $text = $ocr->run();

        // 4️⃣ Detectar tipo (persona física o moral)
        $type = 'unknown';
        if (preg_match('/PERSONAS\s+MORALES/i', $text)) {
            $type = 'moral';
        } elseif (preg_match('/PERSONAS\s+F[IÍ]SICAS/i', $text)) {
            $type = 'physical';
        }

        // 5️⃣ Extraer RFC y nombre
        preg_match('/RFC[:\s]+([A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3})/i', $text, $rfcMatch);
        preg_match('/Nombre[:\s]+(.+)/i', $text, $nameMatch);
        preg_match('/Domicilio[:\s]+(.+)/i', $text, $addressMatch);

        $rfc = $rfcMatch[1] ?? null;
        $name = $nameMatch[1] ?? 'No detectado';
        $address = $addressMatch[1] ?? 'No detectado';

        // 6️⃣ Crear cliente en base de datos
        $client = Client::create([
            'type' => $type,
            'name' => trim($name),
            'rfc' => trim($rfc),
            'address' => trim($address),
            'status' => 'pending',
            'document_status' => 'incomplete',
            'documents' => ['rfc_doc' => $pdfPath],
        ]);

        // 7️⃣ Eliminar imagen temporal
        if (file_exists($tempImage . '.png')) {
            unlink($tempImage . '.png');
        }

        return redirect()->route('legal.clients.index')->with('success', 'Cliente creado y analizado correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al procesar PDF: ' . $e->getMessage());
        return back()->with('error', 'Hubo un problema al analizar el documento. Verifica que sea legible.');
    }
}

public function extractRfc(Request $request)
{
    $request->validate([
        'rfc_pdf' => 'required|file|mimes:pdf|max:5120', // 5MB máximo
    ]);

    try {
        // Guardar temporalmente el PDF
        $path = $request->file('rfc_pdf')->store('temp');

        // Analizar texto del PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/' . $path));
        $text = strtoupper($pdf->getText());

        // Buscar RFC en el texto
        preg_match('/[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}/', $text, $matches);
        $rfc = $matches[0] ?? null;

        if (!$rfc) {
            return response()->json([
                'success' => false,
                'message' => 'No se detectó ningún RFC válido en el PDF.',
            ], 422);
        }

        // Determinar si es persona moral o física
        $type = strlen($rfc) === 12 ? 'moral' : 'physical';

        // Intentar extraer nombre o razón social
        $name = null;
        if ($type === 'moral') {
            // Buscar algo como "DENOMINACIÓN SOCIAL:" o "RAZÓN SOCIAL:"
            preg_match('/(DENOMINACIÓN|RAZ[ÓO]N SOCIAL)[:\s]+([A-Z\s]+)/', $text, $m);
            $name = $m[2] ?? null;
        } else {
            // Buscar nombre si es persona física
            preg_match('/NOMBRE[:\s]+([A-Z\s]+)/', $text, $m);
            $name = $m[1] ?? null;
        }

        // Limpieza temporal del archivo
        Storage::delete($path);

        return response()->json([
            'success' => true,
            'data' => [
                'rfc' => $rfc,
                'name' => trim($name),
                'type' => $type,
            ],
        ]);
    } catch (\Exception $e) {
        Log::error('Error al extraer RFC: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al procesar el documento.',
        ], 500);
    }
}

}
