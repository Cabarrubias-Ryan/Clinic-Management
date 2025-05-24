<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index()
  {
    $appointments = Patient::leftJoin('appointments', 'appointments.patient_id', '=', 'patients.patient_id')
        ->leftJoin('users', 'appointments.doctor_id', '=', 'users.user_id')
        ->where('users.role', 'doctor')
        ->whereNull('appointments.deleted_at')
        ->orderBy('appointments.appointment_date', 'DESC')
        ->limit(10)
        ->get();

    $appointmentCounts = Appointment::selectRaw("
        COUNT(CASE WHEN appointment_status = 'Cancelled' THEN 1 END) as appointmentCancelled,
        COUNT(CASE WHEN appointment_status = 'Completed' THEN 1 END) as appointmentCompleted,
        COUNT(CASE WHEN appointment_status = 'Scheduled' THEN 1 END) as appointmentScheduled
    ")->first();

    return view('content.dashboard.dashboards-analytics', compact('appointments', 'appointmentCounts'));
  }
}
