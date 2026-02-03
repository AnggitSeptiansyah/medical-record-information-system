<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\MedicalRecord;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::all()->each(function ($patient) {
            MedicalRecord::factory(rand(1, 5))->create([
                'patient_id' => $patient->id,
            ]);
        });   
    }
}
