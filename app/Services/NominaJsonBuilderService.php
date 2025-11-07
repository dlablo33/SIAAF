<?php

namespace App\Services;

use App\Models\Empleado;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NominaJsonBuilderService
{
    public function build($empleados, $periodo, $fechaPeriodo, $fechaNomina)
    {

        $compañia = 'ACCION ADMINISTRATIVA Y FISCAL';
        $compañia_domicilio = 'AVE EUGENIO GARZA SADA 4478';
        $compañia_rfc = 'AAF120210SG1';
        $tipo_nomina = 'SEMANAL';
    
        $reportes = [];

        foreach ($empleados as $empleadoId => $data) {
            $empleado = Empleado::find($empleadoId);
            // Fiscal
            $prestacionFiscal = $data['prestaciones']['FISCAL'] ?? [];
            $deduccionFiscal = $data['deducciones']['FISCAL'] ?? [];
            $prestacionesTotalFiscal = collect($prestacionFiscal)->sum(fn($p) => $p['cantidad'] ?? 0);
            $deduccionesTotalFiscal = collect($deduccionFiscal)->sum(fn($p) => $p['cantidad'] ?? 0);

            // Complemento
            $deduccionComplemento = $data['deducciones']['COMPLEMENTO'] ?? [];
            $prestacionComplemento = $data['prestaciones']['COMPLEMENTO'] ?? [];
            $prestacionesTotalComplemento = collect($prestacionComplemento)->sum(fn($p) => $p['cantidad'] ?? 0);
            $deduccionesTotalComplemento = collect($deduccionComplemento)->sum(fn($p) => $p['cantidad'] ?? 0);

            $total_fiscal = $prestacionesTotalFiscal - $deduccionesTotalFiscal;
            $total_complemento = $prestacionesTotalComplemento - $deduccionesTotalComplemento;
            $total_neto = $total_fiscal + $total_complemento;

            $reporte = [
                'empleado' => [
                    [
                        // Empleado
                        'compañia' => $compañia ?? '',
                        'compañia_domicilio' => $compañia_domicilio ?? '',
                        'compañia_rfc' => $compañia_rfc ?? '',
                        'fecha_pago' => $fechaNomina ?? '',
                        'empleado' => "$empleado->a_paterno $empleado->a_materno $empleado->nombre" ?? '',
                        'empleado_imss' => $empleado->nss ?? '',
                        'empleado_rfc' => $empleado->rfc ?? '',
                        'empleado_curp' => $empleado->curp ?? '',
                        'empleado_puesto' => $data['puesto'] ?? '',
                        'periodo' => $periodo,
                        'tipo_nomina' => $tipo_nomina ?? '',
                        'fecha_ingreso' => $empleado->fecha_ingreso ?? '',
                        'fecha_periodo' => $fechaPeriodo ?? '',

                        // Prestaciones Fiscal
                        'per_fis_sueldo' => $prestacionFiscal['1']['cantidad'] ?? '0',
                        'per_fis_7mo_dia' => $prestacionFiscal['2']['cantidad'] ?? '0',
                        'per_fis_bono_puntualidad' => $prestacionFiscal['3']['cantidad'] ?? '0',
                        'per_fis_bono_asistencia' => $prestacionFiscal['4']['cantidad'] ?? '0',
                        'per_fis_despensa' => $prestacionFiscal['5']['cantidad'] ?? '0',
                        'per_fis_bono_mensual' => $prestacionFiscal['6']['cantidad'] ?? '0',
                        'per_fis_asimilados' => '0',
                        'per_fis_vacaciones' => $prestacionFiscal['7']['cantidad'] ?? '0',
                        'per_fis_prima_vacacional' => $prestacionFiscal['8']['cantidad'] ?? '0',
                        'per_fis_caja_chica' => '0',
                        'per_fis_prestamos' => '0',
                        'per_fis_excedente' => '0',
                        'per_fis_total' => $prestacionesTotalFiscal,

                        // Deducciones Fiscal
                        'ded_fis_retardos' => $deduccionFiscal['3']['cantidad'] ?? '0',
                        'ded_fis_adelantos_nomina' => $deduccionFiscal['4']['cantidad'] ?? '0',
                        'ded_fis_prestamos' => $deduccionFiscal['5']['cantidad'] ?? '0',
                        'ded_fis_comedor' => $deduccionFiscal['6']['cantidad'] ?? '0',
                        'ded_fis_seguro' => $deduccionFiscal['7']['cantidad'] ?? '0',
                        'ded_fis_retencion_isr' => '0',
                        'ded_fis_isr_imss' => $deduccionFiscal['8']['cantidad'] ?? '0',
                        'ded_fis_seguro_infonavit' => '0',
                        'ded_fis_prestamo_infonavit' => '0',
                        'ded_fis_dias_vacaciones' => $deduccionFiscal['2']['cantidad'] ?? '0',
                        'ded_fis_pension_alimenticia' => '0',
                        'ded_fis_total' => $deduccionesTotalFiscal,

                        // Prestaciones Complemento
                        'per_comp_sueldo' => $prestacionComplemento['1']['cantidad'] ?? '0',
                        'per_comp_7mo_dia' => $prestacionComplemento['2']['cantidad'] ?? '0',
                        'per_comp_bono_puntualidad' => $prestacionComplemento['3']['cantidad'] ?? '0',
                        'per_comp_bono_asistencia' => $prestacionComplemento['4']['cantidad'] ?? '0',
                        'per_comp_despensa' => $prestacionComplemento['5']['cantidad'] ?? '0',
                        'per_comp_bono_mensual' => $prestacionComplemento['6']['cantidad'] ?? '0',
                        'per_comp_asimilados' => '0',
                        'per_comp_vacaciones' => $prestacionComplemento['7']['cantidad'] ?? '0',
                        'per_comp_prima_vacacional' => $prestacionComplemento['8']['cantidad'] ?? '0',
                        'per_comp_caja_chica' => '0',
                        'per_comp_prestamos' => '0',
                        'per_comp_excedente' => '0',
                        'per_comp_total' => $prestacionesTotalComplemento,

                        // Deducciones Complemento
                        'ded_comp_retardos' => $deduccionComplemento['3']['cantidad'] ?? '0',
                        'ded_comp_adelantos_nomina' => $deduccionComplemento['4']['cantidad'] ?? '0',
                        'ded_comp_prestamos' => $deduccionComplemento['5']['cantidad'] ?? '0',
                        'ded_comp_comedor' => $deduccionComplemento['6']['cantidad'] ?? '0',
                        'ded_comp_seguro' => $deduccionComplemento['7']['cantidad'] ?? '0',
                        'ded_comp_retencion_isr' => '0',
                        'ded_comp_isr_imss' => $deduccionComplemento['8']['cantidad'] ?? '0',
                        'ded_comp_seguro_infonavit' => '0',
                        'ded_comp_prestamo_infonavit' => '0',
                        'ded_comp_dias_vacaciones' => $deduccionComplemento['2']['cantidad'] ?? '0',
                        'ded_comp_pension_alimenticia' => '0',
                        'ded_comp_total' => $deduccionesTotalComplemento,

                        // Totales
                        'total_neto' => $total_neto ?? '0',
                        'total_fiscal' => $total_fiscal ?? '0',
                        'total_complemento' => $total_complemento ?? '0',

                        // Vacaciones / Retardos
                        'vacaciones' => '0',
                        'dias_vacaciones' => '0',
                        'prima_vacacional' => '0',
                        'retardos' => '0',
                        'tiempo' => '0',
                        'frecuencia' => '0',
                    ]
                ]
            ];
            $reportes[$empleadoId] = $reporte;
        }

        $path = "reports/nomina_{$periodo}.json";

        Storage::makeDirectory(dirname($path));
        Storage::put($path, json_encode($reportes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return storage_path("app/{$path}");
    }
}
