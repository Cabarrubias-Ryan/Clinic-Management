<?php

namespace App\Http\Controllers\records;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function index() {
      return view('content.records.medical-records');
    }
}
