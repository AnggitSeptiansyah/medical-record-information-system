<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test; // TAMBAHKAN INI

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
    }

    #[Test] // GANTI dari /** @test */
    public function authenticated_user_can_view_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    #[Test]
    public function guest_cannot_view_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function dashboard_displays_total_patients_correctly()
    {
        Patient::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['total_patients'] === 15;
        });
    }

    #[Test]
    public function dashboard_displays_total_records_this_month_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create records this month
        MedicalRecord::factory()->count(5)->create([
            'patient_id' => $patient->id,
            'visit_date' => now(),
        ]);

        // Create records last month (should not be counted)
        MedicalRecord::factory()->count(3)->create([
            'patient_id' => $patient->id,
            'visit_date' => now()->subMonth(),
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['total_records_this_month'] === 5;
        });
    }

    #[Test]
    public function dashboard_displays_today_visits_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create records today
        MedicalRecord::factory()->count(3)->create([
            'patient_id' => $patient->id,
            'visit_date' => today(),
        ]);

        // Create records yesterday (should not be counted)
        MedicalRecord::factory()->count(2)->create([
            'patient_id' => $patient->id,
            'visit_date' => today()->subDay(),
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['today_visits'] === 3;
        });
    }

    #[Test]
    public function dashboard_displays_new_patients_this_month_correctly()
    {
        // Create patients this month
        Patient::factory()->count(7)->create([
            'created_at' => now(),
        ]);

        // Create patients last month (should not be counted)
        Patient::factory()->count(4)->create([
            'created_at' => now()->subMonth(),
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['new_patients_this_month'] === 7;
        });
    }

    #[Test]
    public function dashboard_calculates_total_revenue_today_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create paid records today
        MedicalRecord::factory()->count(3)->create([
            'patient_id' => $patient->id,
            'visit_date' => today(),
            'payment_amount' => 100000,
            'payment_status' => 'paid',
        ]);

        // Create unpaid record today (should not be counted)
        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'visit_date' => today(),
            'payment_amount' => 50000,
            'payment_status' => 'unpaid',
        ]);

        // Create paid record yesterday (should not be counted)
        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'visit_date' => today()->subDay(),
            'payment_amount' => 100000,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('financialStats', function ($stats) {
            return $stats['total_revenue_today'] === 300000; // 3 * 100000
        });
    }

    #[Test]
    public function dashboard_calculates_total_revenue_this_month_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create paid records this month
        MedicalRecord::factory()->count(5)->create([
            'patient_id' => $patient->id,
            'visit_date' => now(),
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        // Create unpaid record this month (should not be counted)
        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'visit_date' => now(),
            'payment_amount' => 100000,
            'payment_status' => 'unpaid',
        ]);

        // Create paid record last month (should not be counted)
        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'visit_date' => now()->subMonth(),
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('financialStats', function ($stats) {
            return $stats['total_revenue_this_month'] === 750000; // 5 * 150000
        });
    }

    #[Test]
    public function dashboard_calculates_total_revenue_this_year_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create paid records this year
        MedicalRecord::factory()->count(10)->create([
            'patient_id' => $patient->id,
            'visit_date' => now(),
            'payment_amount' => 200000,
            'payment_status' => 'paid',
        ]);

        // Create paid record last year (should not be counted)
        MedicalRecord::factory()->create([
            'patient_id' => $patient->id,
            'visit_date' => now()->subYear(),
            'payment_amount' => 200000,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('financialStats', function ($stats) {
            return $stats['total_revenue_this_year'] === 2000000; // 10 * 200000
        });
    }

    #[Test]
    public function dashboard_counts_unpaid_records_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create unpaid records
        MedicalRecord::factory()->count(4)->create([
            'patient_id' => $patient->id,
            'payment_status' => 'unpaid',
        ]);

        // Create paid records (should not be counted)
        MedicalRecord::factory()->count(6)->create([
            'patient_id' => $patient->id,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('financialStats', function ($stats) {
            return $stats['unpaid_records_count'] === 4;
        });
    }

    #[Test]
    public function dashboard_calculates_unpaid_total_amount_correctly()
    {
        $patient = Patient::factory()->create();
        
        // Create unpaid records
        MedicalRecord::factory()->count(3)->create([
            'patient_id' => $patient->id,
            'payment_amount' => 100000,
            'payment_status' => 'unpaid',
        ]);

        // Create paid records (should not be counted)
        MedicalRecord::factory()->count(2)->create([
            'patient_id' => $patient->id,
            'payment_amount' => 150000,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('financialStats', function ($stats) {
            return $stats['unpaid_total_amount'] === 300000; // 3 * 100000
        });
    }

    #[Test]
    public function dashboard_displays_gender_distribution_correctly()
    {
        // Create male patients
        Patient::factory()->count(6)->create(['gender' => 'male']);

        // Create female patients
        Patient::factory()->count(4)->create(['gender' => 'female']);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('genderDistribution', function ($distribution) {
            $maleCount = collect($distribution)->where('gender', 'male')->first()['total'] ?? 0;
            $femaleCount = collect($distribution)->where('gender', 'female')->first()['total'] ?? 0;
            
            return $maleCount === 6 && $femaleCount === 4;
        });
    }

    #[Test]
    public function dashboard_displays_monthly_visits_for_last_6_months()
    {
        $patient = Patient::factory()->create();

        // Create records for different months
        for ($i = 0; $i < 6; $i++) {
            MedicalRecord::factory()->count(2)->create([
                'patient_id' => $patient->id,
                'visit_date' => now()->subMonths($i),
            ]);
        }

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('monthlyVisits', function ($visits) {
            return count($visits) <= 6; // Should have max 6 months of data
        });
    }

    #[Test]
    public function dashboard_displays_recent_medical_records()
    {
        $patient = Patient::factory()->create();
        
        MedicalRecord::factory()->count(10)->create([
            'patient_id' => $patient->id,
        ]);

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('recentRecords', function ($records) {
            return $records->count() === 5; // Should show only 5 recent
        });
    }

    #[Test]
    public function dashboard_displays_recent_patients()
    {
        Patient::factory()->count(10)->create();

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertViewHas('recentPatients', function ($patients) {
            return $patients->count() === 5; // Should show only 5 recent
        });
    }

    #[Test]
    public function dashboard_works_with_empty_database()
    {
        // No data in database
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['total_patients'] === 0
                && $statistics['total_records_this_month'] === 0
                && $statistics['today_visits'] === 0
                && $statistics['new_patients_this_month'] === 0;
        });
    }
}