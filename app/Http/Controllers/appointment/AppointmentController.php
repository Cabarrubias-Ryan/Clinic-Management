<?php

namespace App\Http\Controllers\appointment;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class AppointmentController extends Controller
{
  public function index()
  {
    $doctor = User::orderBy('user_id', 'DESC')->where('role', '=', 'Doctor')->whereNull('deleted_at')->get();

    $appointments = Patient::leftJoin('appointments', 'appointments.patient_id', '=', 'patients.patient_id')
        ->leftJoin('users', 'appointments.doctor_id', '=', 'users.user_id')
        ->where('users.role', 'doctor')
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

    return view('content.appointment.patient-appointment', compact('appointments', 'doctor'));
  }
  public function store(Request $request)
  {
      // Step 1: Store the patient data
      $patientData = [
          'first_name' => $request->firstname,
          'last_name' => $request->lastname,
          'date_of_birth' => $request->birthdate,
          'gender' => $request->gender,
          'phone_number' => $request->phone,
          'email' => $request->email,
          'address' => $request->address,
      ];

      // Insert the patient data into the database
      $patient = Patient::create($patientData);

      // Step 2: Store the appointment data
      $appointmentData = [
          'patient_id' => $patient->id,  // Link to the newly created patient
          'doctor_id' => $request->doctor_id,
          'appointment_date' => $request->appointment,
          'appointment_status' => 'Scheduled',  // You can set the default status
      ];

      $appointment = Appointment::create($appointmentData);

      // Step 3: Return response
      if ($appointment) {
          return response()->json([
              'Error' => 0,
              'Message' => 'Patient appointment successfully added.'
          ]);
      }

      return response()->json([
          'Error' => 1,
          'Message' => 'Failed to add appointment.'
      ]);
  }
  public function update(Request $request)
  {
      // Step 1: Update the patient data
      $patientData = [
          'first_name' => $request->firstname,
          'last_name' => $request->lastname,
          'date_of_birth' => $request->dob,
          'gender' => $request->gender,
          'phone_number' => $request->phone,
          'email' => $request->email,
          'address' => $request->address,
      ];

      // Find the patient associated with the appointment
      $patient = Patient::where('patient_id', '=', $request->patient_id)->update($patientData);


      // Step 2: Update the appointment data
      $appointmentData = [
          'appointment_date' => $request->appointment_date,
          'appointment_status' => $request->appointment_status,
      ];

      $appointment = Appointment::where('appointment_id', '=', $request->appointment_id)->update($appointmentData); // The appointment id is provided

      // Step 3: Return success response
      if($appointment){
        return response()->json([
            'Error' => 0,
            'Message' => 'Patient appointment successfully updated.'
        ]);
      }
  }

  public function delete(Request $request){

    $userData = [
      'deleted_at' => now()
    ];
    $appointment = Appointment::where('appointment_id', '=', $request->id)->update($userData);

    if($appointment){
      return response()->json(['Error' => 0, 'Message' => 'Patient appointment successfully deleted.']);
    }
  }
}
