<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_patient()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/patients', [
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'address' => 'Jl. Test No. 123',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'blood_type' => 'A',
        ]);

        $response->assertRedirect('/patients');
        $this->assertDatabaseHas('patients', [
            'name' => 'John Doe',
            'nik' => '1234567890123456',
        ]);
    }

    /** @test */
    public function patient_nik_must_be_unique()
    {
        $user = User::factory()->create();
        Patient::factory()->create(['nik' => '1234567890123456']);

        $response = $this->actingAs($user)->post('/patients', [
            'name' => 'Jane Doe',
            'nik' => '1234567890123456', // Duplicate
            'birth_date' => '1990-01-01',
            'gender' => 'female',
            'address' => 'Jl. Test',
            'phone' => '081234567890',
        ]);

        $response->assertSessionHasErrors('nik');
    }
}