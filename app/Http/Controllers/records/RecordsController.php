<?php

namespace App\Http\Controllers\records;

use App\Models\User;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function show() {
      $appointments = Patient::leftjoin('medical_records', 'patients.patient_id', '=', 'medical_records.patient_id')
                          ->whereNull('patients.deleted_at')
                          ->where('medical_records.record_date', '!=', null)
                          ->where('medical_records.diagnosis', '!=', null)
                          ->where('medical_records.treatment', '!=', null)
                          ->orderBy('medical_records.record_date', 'DESC')
                          ->get();
      return view('content.records.medical-record-view', compact('appointments'));
    }
    public function generateReceipt(Request $request)
    {
        // Fetch reservation, payment, and venue details
        $records = Patient::leftjoin('medical_records', 'patients.patient_id', '=', 'medical_records.patient_id')
                          ->whereNull('patients.deleted_at')
                          ->where('medical_records.record_date', '!=', null)
                          ->where('medical_records.diagnosis', '!=', null)
                          ->where('medical_records.treatment', '!=', null)
                          ->orderBy('medical_records.record_date', 'DESC')
                          ->get();

        $pdf = Pdf::loadView('pdf.medicalRecords', compact('records'));
        $pdf->setPaper('A4', 'portrait');

        // Stream the generated PDF to the browser
        return $pdf->stream('medical_records_data.pdf');
    }
}
