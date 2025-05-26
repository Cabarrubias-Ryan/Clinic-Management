@extends('layouts/contentNavbarLayout')

@section('title', 'Medical Records')

@section('page-script')
@vite('resources/assets/js/medicalRecordsViews.js')
@endsection

@section('content')
<div class="card">
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">
      </div>
    </div>
     <div class="navbar-nav align-items-end ms-auto">
      <div class="nav-item d-flex align-items-center">
        <a class="btn btn-primary" href="{{ route('record-basic-pdf')}}" target="_blank">Download PFD</a>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Patient Name</th>
          <th>Patient Email</th>
          <th>Patient Phone</th>
          <th>Patient Address</th>
          <th>Diagnosis</th>
          <th>Medication</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="appointmentlist">
      </tbody>
    </table>
  </div>
</div>

@php
$appointments = collect($appointments)->map(function($appointment) {
    return [
        'patient_id' => $appointment->patient_id,
        'created_at' => $appointment->created_at,
        'updated_at' => $appointment->updated_at,
        'deleted_at' => $appointment->deleted_at,
        'patient_first_name' => $appointment->first_name,  // Assuming a relationship with Patient model
        'patient_last_name' => $appointment->last_name,    // Assuming a relationship with Patient model
        'patient_dob' => $appointment->date_of_birth,
        'patient_gender' => $appointment->gender,
        'patient_phone_number' => $appointment->phone_number,
        'patient_email' => $appointment->email,
        'patient_address' => $appointment->address,
        'doctor_email' => $appointment->email,
        'record_date' => $appointment->record_date,
        'diagnosis' => $appointment->diagnosis,
        'treatment' => $appointment->treatment  // Assuming a relationship with User model
    ];
})->values()->toArray();
@endphp

<script>
  window.appointments = @json($appointments);
</script>
@endsection
