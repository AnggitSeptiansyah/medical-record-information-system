<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getStatistics(): array
    {
        return [
            'total_patients' => Patient::count(),
            'total_records_this_month' => MedicalRecord::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->count(),
            'today_visits' => MedicalRecord::whereDate('visit_date', today())->count(),
            'new_patients_this_month' => Patient::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    public function getGenderDistribution(): array
    {
        return Patient::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get()
            ->toArray();
    }

    public function getMonthlyVisits(): array
    {
         // Database agnostic - works with both MySQL and SQLite
    $records = MedicalRecord::where('visit_date', '>=', now()->subMonths(6))
        ->get(['visit_date'])
        ->groupBy(function($record) {
            return $record->visit_date->format('Y-m');
        })
        ->map(function($group, $key) {
            $date = Carbon::createFromFormat('Y-m', $key);
            return [
                'month' => (int) $date->format('m'),
                'year' => (int) $date->format('Y'),
                'total' => $group->count(),
                'sort_key' => $key, // Tambahkan ini untuk sorting
            ];
        })
        ->sortBy('sort_key') // Sort by year-month string (2025-08, 2025-09, dst)
        ->values()
        ->map(function($item) {
            unset($item['sort_key']); // Remove sort_key sebelum return
            return $item;
        })
        ->toArray();

    return $records;
    }

    public function getRecentRecords(int $limit = 5)
    {
        return MedicalRecord::with('patient')
            ->latest('visit_date')
            ->limit($limit)
            ->get();
    }

    public function getRecentPatients(int $limit = 5)
    {
        return Patient::latest()
            ->limit($limit)
            ->get();
    }

    public function getFinancialStats(): array
    {
        return [
            'total_revenue_today' => MedicalRecord::whereDate('visit_date', today())
                ->where('payment_status', 'paid')
                ->sum('payment_amount'),
            'total_revenue_this_month' => MedicalRecord::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->where('payment_status', 'paid')
                ->sum('payment_amount'),
            'total_revenue_this_year' => MedicalRecord::whereYear('visit_date', now()->year)
                ->where('payment_status', 'paid')
                ->sum('payment_amount'),
            'unpaid_records_count' => MedicalRecord::where('payment_status', 'unpaid')->count(),
            'unpaid_total_amount' => MedicalRecord::where('payment_status', 'unpaid')
                ->sum('payment_amount'),
        ];
    }
}