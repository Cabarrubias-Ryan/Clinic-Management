@extends('layouts/contentNavbarLayout')

@section('title', 'Appointment')

@section('page-script')
@vite('resources/assets/js/appointment.js')
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
    <div class="navbar-nav flex-row align-items-center ms-auto gap-5">
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddAccount">
        <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Appointment
      </button>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Patient Name</th>
          <th>Patient Email</th>
          <th>Patient Phone</th>
          <th>Appointment Date</th>
          <th>Status</th>
          <th>Doctor</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="appointmentlist">
      </tbody>
    </table>
  </div>
</div>
{{-- Add Account Modal --}}
<div class="modal fade" id="AddAccount" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- /Logo -->
        <div class="card-body mt-5">

          <form id="AddAccountData" class="mb-5">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your firstname" autofocus>
              <label for="firstname">Firstname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" autofocus>
              <label for="lastname">Lastname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              <label for="email">Email</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
              <label for="phone">Phone Number</label>
            </div>
             <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
              <label for="address">Address</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Enter your birthdate">
              <label for="birthdate">Birthdate</label>
            </div>
            <div class="form-floating form-floating-outline mb-6">
              <select class="form-select" id="gender" name="gender" aria-label="Default select example">
                <option value="" selected disabled>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Famale">Famale</option>
                <option value="Others">Others</option>
              </select>
              <label for="exampleFormControlSelect1">Gender</label>
            </div>
             <div class="form-floating form-floating-outline mb-5">
              <input type="date" class="form-control" id="appointment" name="appointment" placeholder="Enter your appointment">
              <label for="appointment">Appointment Date</label>
            </div>
             <div class="form-floating form-floating-outline mb-6">
              <select class="form-select" id="doctor_id" name="doctor_id" aria-label="Default select example">
                <option value="" selected disabled>Select Doctor</option>
                @foreach ($doctor as $item)
                    <option value="{{ $item->user_id }}">{{ $item->firstname}} {{ $item->lastname}}</option>
                @endforeach
              </select>
              <label for="exampleFormControlSelect1">Doctor</label>
            </div>
          </form>
        </div>
        <div>
          <button type="button" class="btn btn-primary d-grid w-100 mb-5" id="AddAcountBtn">Submit</button>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- Edit Account Modal --}}
<div class="modal fade" id="EditAppointment" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- /Logo -->
        <div class="card-body mt-5">
          <form id="EditAppointmentData" class="mb-5">
            @csrf
            <input type="hidden" class="form-control" id="Edit_appointment_id" name="appointment_id">
            <input type="hidden" class="form-control" id="Edit_patient_id" name="patient_id">
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_firstname" name="firstname" placeholder="Enter First Name">
              <label for="Edit_firstname">First Name</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_lastname" name="lastname" placeholder="Enter Last Name">
              <label for="Edit_lastname">Last Name</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="date" class="form-control" id="Edit_dob" name="dob" placeholder="Enter Date of Birth">
              <label for="Edit_dob">Date of Birth</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <select class="form-select" id="Edit_gender" name="gender">
                <option value="" selected disabled>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
              <label for="Edit_gender">Gender</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_phone" name="phone" placeholder="Enter Phone Number">
              <label for="Edit_phone">Phone</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="email" class="form-control" id="Edit_email" name="email" placeholder="Enter Email">
              <label for="Edit_email">Email</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_address" name="address" placeholder="Enter Address">
              <label for="Edit_address">Address</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="date" class="form-control" id="Edit_appointment_date" name="appointment_date" placeholder="Enter Appointment Date">
              <label for="Edit_appointment_date">Appointment Date</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <select class="form-select" id="Edit_appointment_status" name="appointment_status">
                <option value="" selected disabled>Select Appointment</option>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
              <label for="Edit_appointment_status">Status</label>
            </div>
          </form>
        </div>
        <div>
          <button type="button" class="btn btn-primary d-grid w-100 mb-5" id="SaveEditBtn">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>

@php
$appointments = collect($appointments)->map(function($appointment) {
    return [
        'appointment_id' => $appointment->appointment_id,
        'patient_id' => $appointment->patient_id,
        'doctor_id' => $appointment->doctor_id,
        'appointment_date' => $appointment->appointment_date,
        'appointment_status' => $appointment->appointment_status,
        'notes' => $appointment->notes,
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
        'doctor_firstname' => $appointment->doctor_firstname,     // Assuming a relationship with User model
        'doctor_lastname' => $appointment->doctor_lastname,       // Assuming a relationship with User model
        'doctor_email' => $appointment->email,             // Assuming a relationship with User model
    ];
})->values()->toArray();
@endphp

<script>
  window.appointments = @json($appointments);
</script>
@endsection
