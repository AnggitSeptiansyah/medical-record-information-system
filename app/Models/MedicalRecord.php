<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    /** @use HasFactory<\Database\Factories\MedicalRecordFactory> */
    use HasFactory;

        protected $fillable = [
        'patient_id',
        'visit_date',
        'complaint',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
        'payment_amount',
        'payment_status',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'payment_amount' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
