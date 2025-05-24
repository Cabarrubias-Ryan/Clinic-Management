<?php

namespace App\Http\Controllers\records;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function index() {

      $appointments = Patient::whereNull('patients.deleted_at')
          ->leftjoin('medical_records', 'patients.patient_id', '=', 'medical_records.patient_id')
          ->where('medical_records.record_date', '!=', null)
          ->where('medical_records.diagnosis', '!=', null)
          ->where('medical_records.treatment', '!=', null)
          ->orderBy('patients.created_at', 'DESC')
          ->get();

      return view('content.records.medical-records', compact('appointments'));
    }
    public function show($id) {
      $appointments = Patient::leftjoin('medical_records', 'patients.patient_id', '=', 'medical_records.patient_id')
                          ->where('patients.patient_id', $id)
                          ->whereNull('patients.deleted_at')
                          ->orderBy('medical_records.record_date', 'DESC')
                          ->get();

      return view('content.records.medical-record-view', compact('appointments'));
    }
}
