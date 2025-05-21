<?php

namespace App\Http\Controllers\diagnosis;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\MedicalRecords;
use App\Http\Controllers\Controller;

class DiagnosisController extends Controller
{
    public function index() {

      $appointments = Patient::leftJoin('appointments', 'appointments.patient_id', '=', 'patients.patient_id')
          ->leftJoin('users', 'appointments.doctor_id', '=', 'users.user_id')
          ->where('users.role', 'doctor')
          ->where('appointments.appointment_status', 'Scheduled')
          ->whereNull('appointments.deleted_at')
          ->select(
              'appointments.*',
              'patients.*',
              'users.firstname as doctor_firstname',
              'users.lastname as doctor_lastname',
              'users.email as doctor_email'
          )
          ->orderBy('appointments.appointment_date', 'DESC')
          ->get();

      return view('content.diagnosis.patient-diagnosis-schedule', compact('appointments'));
    }
    public function add(Request $request) {

      $diagnosisData = [
          'patient_id' => $request->patient_id,
          'doctor_id' => $request->doctor_id,
          'record_date' => now(),
          'diagnosis' => $request->diagnosis,
          'treatment' => $request->treatment,
      ];

      $diagnosis = MedicalRecords::insert($diagnosisData);

      $appointments = Appointment::where('patient_id', $request->patient_id)->update([
          'appointment_status' => 'Completed',
          'notes' => $request->notes,
      ]);

      return redirect()->back()->with('success', 'Diagnosis added successfully.'); //
    }
    public function complete() {

      $appointments = Patient::leftJoin('appointments', 'appointments.patient_id', '=', 'patients.patient_id')
          ->leftJoin('users', 'appointments.doctor_id', '=', 'users.user_id')
          ->where('users.role', 'doctor')
          ->where('appointments.appointment_status', 'Completed')
          ->whereNull('appointments.deleted_at')
          ->select(
              'appointments.*',
              'patients.*',
              'users.firstname as doctor_firstname',
              'users.lastname as doctor_lastname',
              'users.email as doctor_email'
          )
          ->orderBy('appointments.appointment_date', 'DESC')
          ->get();

      return view('content.diagnosis.patient-diagnosis-complete', compact('appointments'));
    }
    public function cancel() {

      $appointments = Patient::leftJoin('appointments', 'appointments.patient_id', '=', 'patients.patient_id')
          ->leftJoin('users', 'appointments.doctor_id', '=', 'users.user_id')
          ->where('users.role', 'doctor')
          ->where('appointments.appointment_status', 'Cancelled')
          ->whereNull('appointments.deleted_at')
          ->select(
              'appointments.*',
              'patients.*',
              'users.firstname as doctor_firstname',
              'users.lastname as doctor_lastname',
              'users.email as doctor_email'
          )
          ->orderBy('appointments.appointment_date', 'DESC')
          ->get();

      return view('content.diagnosis.patient-diagnosis-cancel', compact('appointments'));
    }
}
