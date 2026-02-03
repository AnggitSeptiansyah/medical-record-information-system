<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'nik',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'blood_type',
        'payment_amount',
        'payment_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
