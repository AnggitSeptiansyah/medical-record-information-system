<?php

namespace App\Http\Controllers;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        // Statistik
        $statistics = $this->dashboardService->getStatistics();
        $genderDistribution = $this->dashboardService->getGenderDistribution();
        $monthlyVisits = $this->dashboardService->getMonthlyVisits();
        $recentRecords = $this->dashboardService->getRecentRecords();
        $recentPatients = $this->dashboardService->getRecentPatients();
        $financialStats = $this->dashboardService->getFinancialStats();

        return view('dashboard', compact(
            'statistics',
            'genderDistribution',
            'monthlyVisits',
            'recentRecords',
            'recentPatients',
            'financialStats',
        ));
    }
}
