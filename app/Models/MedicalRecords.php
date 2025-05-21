<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecords extends Model
{
    protected $table = 'medical_records';
    protected $fillable = [
      'record_id',
      'patient_id',
      'doctor_id',
      'record_date',
      'diagnosis',
      'treatment'
    ];
}
