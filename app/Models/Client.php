<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'rfc',
        'email',
        'phone',
        'address',
        'status',
        'notes',
        'empleado_id',
        'document_status',
        'documents'
    ];

    protected $casts = [
        'documents' => 'array',
        'document_status' => 'string'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function legalAdvices()
    {
        return $this->hasMany(LegalAdvice::class);
    }

    public function legalProcedures()
    {
        return $this->hasMany(LegalProcedure::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Documentos requeridos
    public static function requiredDocuments(string $type): array
    {
        return $type === 'physical' ? [
            'ine_front' => 'INE (Frente)',
            'ine_back' => 'INE (Reverso)',
            'rfc_doc' => 'RFC',
            'tax_situation' => 'Constancia de Situación Fiscal',
            'compliance_opinion' => 'Opinión de Cumplimiento',
            'fiel_zip' => 'FIEL (Archivo ZIP)'
        ] : [
            'articles_of_incorporation' => 'Actas Constitutivas',
            'assemblies' => 'Asambleas',
            'compliance_opinion' => 'Opinión de Cumplimiento',
            'tax_constancy' => 'Constancia Fiscal',
            'legal_representative_ine' => 'INE Representante Legal',
            'fiel_zip' => 'FIEL (Archivo ZIP)'
        ];
    }

    // Verificar estado de documentos
    public function checkDocumentStatus(): void
    {
        $required = self::requiredDocuments($this->type);
        $uploaded = $this->documents ?: [];

        $missing = array_diff_key($required, $uploaded);
        $this->document_status = empty($missing) ? 'complete' : 'incomplete';
        $this->save();
    }

    // Obtener documentos faltantes
    public function missingDocuments(): array
    {
        $required = self::requiredDocuments($this->type);
        $uploaded = $this->documents ?: [];

        return array_diff_key($required, $uploaded);
    }
}
