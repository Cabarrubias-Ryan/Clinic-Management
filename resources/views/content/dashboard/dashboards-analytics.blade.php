@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="row gy-6">
  <!-- Dashboard Cards -->
  <div class="col-xl-4 col-md-6">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Scheduled Appointments</h5>
        <p class="fs-3 text-primary">{{ $appointmentCounts->appointmentScheduled }}</p> <!-- Replace 120 with dynamic data -->
        <small class="text-muted">Appointments pending</small>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Completed Appointments</h5>
        <p class="fs-3 text-success">{{ $appointmentCounts->appointmentCompleted }}</p> <!-- Replace 85 with dynamic data -->
        <small class="text-muted">Appointments completed</small>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6">
    <div class="card shadow-sm">
      <div class="card-body text-center">
        <h5 class="card-title">Cancelled Appointments</h5>
        <p class="fs-3 text-danger">{{ $appointmentCounts->appointmentCancelled }}</p> <!-- Replace 15 with dynamic data -->
        <small class="text-muted">Appointments canceled</small>
      </div>
    </div>
  </div>
  <!--/ Dashboard Cards -->

  <!-- Data Tables -->
  <div class="col-12">
    <div class="card overflow-hidden">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-truncate">Patient Name</th>
              <th class="text-truncate">Address</th>
              <th class="text-truncate">Gender</th>
              <th class="text-truncate">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($appointments as $item)
                <tr>
                  <th>{{$item->first_name}} {{$item->last_name}}</th>
                  <th>{{ $item->address}}</th>
                  <th>{{ $item->gender }}</th>
                  <th>{{ $item->appointment_status }}</th>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!--/ Data Tables -->
</div>
@endsection
