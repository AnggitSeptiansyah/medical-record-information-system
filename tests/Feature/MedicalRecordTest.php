<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $patient;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup user dan patient untuk semua test
        $this->user = User::factory()->create();
        $this->patient = Patient::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_medical_records_list()
    {
        MedicalRecord::factory()->count(5)->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->actingAs($this->user)->get('/medical-records');

        $response->assertStatus(200);
        $response->assertViewIs('medical-records.index');
        $response->assertViewHas('medicalRecords');
    }

    /** @test */
    public function guest_cannot_view_medical_records()
    {
        $response = $this->get('/medical-records');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_medical_record()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Demam tinggi sejak 2 hari',
            'diagnosis' => 'Tifus',
            'treatment' => 'Antibiotik dan istirahat',
            'prescription' => 'Paracetamol 3x1',
            'notes' => 'Kontrol 3 hari lagi',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertRedirect('/medical-records');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('medical_records', [
            'patient_id' => $this->patient->id,
            'diagnosis' => 'Tifus',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);
    }

    /** @test */
    public function medical_record_requires_patient_id()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => null, // Missing
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('patient_id');
    }

    /** @test */
    public function medical_record_requires_valid_patient_id()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => 99999, // Non-existent
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('patient_id');
    }

    /** @test */
    public function medical_record_requires_visit_date()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => null, // Missing
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('visit_date');
    }

    /** @test */
    public function medical_record_requires_complaint()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => '', // Empty
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('complaint');
    }

    /** @test */
    public function medical_record_requires_diagnosis()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => '', // Empty
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('diagnosis');
    }

    /** @test */
    public function medical_record_requires_treatment()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => '', // Empty
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('treatment');
    }

    /** @test */
    public function medical_record_requires_payment_amount()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => null, // Missing
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('payment_amount');
    }

    /** @test */
    public function payment_amount_must_be_integer()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 'not-a-number', // Invalid
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('payment_amount');
    }

    /** @test */
    public function payment_amount_must_be_non_negative()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => -5000, // Negative
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasErrors('payment_amount');
    }

    /** @test */
    public function payment_status_must_be_valid()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'payment_amount' => 150000,
            'payment_status' => 'invalid-status', // Invalid
        ]);

        $response->assertSessionHasErrors('payment_status');
    }

    /** @test */
    public function prescription_and_notes_are_optional()
    {
        $response = $this->actingAs($this->user)->post('/medical-records', [
            'patient_id' => $this->patient->id,
            'visit_date' => now()->format('Y-m-d'),
            'complaint' => 'Test complaint',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Test treatment',
            'prescription' => null, // Optional
            'notes' => null, // Optional
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response->assertRedirect('/medical-records');
        $this->assertDatabaseHas('medical_records', [
            'patient_id' => $this->patient->id,
            'prescription' => null,
            'notes' => null,
        ]);
    }

    /** @test */
    public function authenticated_user_can_view_medical_record_detail()
    {
        $medicalRecord = MedicalRecord::factory()->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->actingAs($this->user)
            ->get("/medical-records/{$medicalRecord->id}");

        $response->assertStatus(200);
        $response->assertViewIs('medical-records.show');
        $response->assertSee($medicalRecord->diagnosis);
        $response->assertSee($this->patient->name);
    }

    /** @test */
    public function authenticated_user_can_update_medical_record()
    {
        $medicalRecord = MedicalRecord::factory()->create([
            'patient_id' => $this->patient->id,
            'diagnosis' => 'Old Diagnosis',
            'payment_amount' => 100000,
        ]);

        $response = $this->actingAs($this->user)
            ->put("/medical-records/{$medicalRecord->id}", [
                'patient_id' => $this->patient->id,
                'visit_date' => now()->format('Y-m-d'),
                'complaint' => 'Updated complaint',
                'diagnosis' => 'Updated Diagnosis',
                'treatment' => 'Updated treatment',
                'prescription' => 'Updated prescription',
                'notes' => 'Updated notes',
                'payment_amount' => 200000,
                'payment_status' => 'unpaid',
            ]);

        $response->assertRedirect('/medical-records');
        $this->assertDatabaseHas('medical_records', [
            'id' => $medicalRecord->id,
            'diagnosis' => 'Updated Diagnosis',
            'payment_amount' => 200000,
            'payment_status' => 'unpaid',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_medical_record()
    {
        $medicalRecord = MedicalRecord::factory()->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/medical-records/{$medicalRecord->id}");

        $response->assertRedirect('/medical-records');
        $this->assertDatabaseMissing('medical_records', [
            'id' => $medicalRecord->id,
        ]);
    }

    /** @test */
    public function medical_record_is_deleted_when_patient_is_deleted()
    {
        $patient = Patient::factory()->create();
        $medicalRecord = MedicalRecord::factory()->create([
            'patient_id' => $patient->id
        ]);

        $patient->delete();

        $this->assertDatabaseMissing('medical_records', [
            'id' => $medicalRecord->id,
        ]);
    }
}