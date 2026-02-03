<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <x-stat-card 
                    title="Total Pasien" 
                    :value="$statistics['total_patients']" 
                    color="blue">
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    title="Record Bulan Ini" 
                    :value="$statistics['total_records_this_month']" 
                    color="green">
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    title="Kunjungan Hari Ini" 
                    :value="$statistics['today_visits']" 
                    color="yellow">
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    title="Pasien Baru Bulan Ini" 
                    :value="$statistics['new_patients_this_month']" 
                    color="purple">
                    <x-slot name="icon">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

             <!-- Financial Stats Section (TAMBAHKAN INI) -->
            @include('dashboard.partials.financial-stats', ['financialStats' => $financialStats])

            @include('dashboard.partials.quick-actions')
            @include('dashboard.partials.charts', ['monthlyVisits' => $monthlyVisits, 'genderDistribution' => $genderDistribution])
            @include('dashboard.partials.recent-data', ['recentRecords' => $recentRecords, 'recentPatients' => $recentPatients])

        </div>
    </div>

    @push('scripts')
    @vite(['resources/js/dashboard-charts.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyVisits = @json($monthlyVisits);
            const genderDistribution = @json($genderDistribution);
            window.initializeCharts(monthlyVisits, genderDistribution);
        });
    </script>
    @endpush
</x-app-layout>