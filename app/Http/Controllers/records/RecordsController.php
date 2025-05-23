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
          ->orderBy('patients.created_at  ', 'DESC')
          ->get();

      return view('content.records.medical-records', compact('appointments'));
    }
}
