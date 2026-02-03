<!-- Financial Stats Section -->
<div class="mb-6">
    <div class="flex items-center mb-4">
        <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Ringkasan Keuangan</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- Pendapatan Hari Ini -->
        <x-financial-card 
            title="Pendapatan Hari Ini" 
            :amount="'Rp ' . number_format($financialStats['total_revenue_today'], 0, ',', '.')" 
            :subtitle="'Tanggal ' . now()->format('d M Y')"
            color="green">
            <x-slot name="icon">
                <svg class="h-8 w-8 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-slot>
        </x-financial-card>

        <!-- Pendapatan Bulan Ini -->
        <x-financial-card 
            title="Pendapatan Bulan Ini" 
            :amount="'Rp ' . number_format($financialStats['total_revenue_this_month'], 0, ',', '.')" 
            :subtitle="now()->format('F Y')"
            color="emerald">
            <x-slot name="icon">
                <svg class="h-8 w-8 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </x-slot>
        </x-financial-card>

        <!-- Pendapatan Tahun Ini -->
        <x-financial-card 
            title="Pendapatan Tahun Ini" 
            :amount="'Rp ' . number_format($financialStats['total_revenue_this_year'], 0, ',', '.')" 
            :subtitle="'Tahun ' . now()->year"
            color="teal">
            <x-slot name="icon">
                <svg class="h-8 w-8 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-slot>
        </x-financial-card>

        <!-- Tagihan Belum Lunas (Count) -->
        <x-financial-card 
            title="Tagihan Belum Lunas" 
            :amount="$financialStats['unpaid_records_count'] . ' Record'" 
            :subtitle="'Perlu Follow-up'"
            color="orange">
            <x-slot name="icon">
                <svg class="h-8 w-8 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </x-slot>
        </x-financial-card>

        <!-- Total Tagihan Belum Lunas (Amount) -->
        <x-financial-card 
            title="Nilai Belum Lunas" 
            :amount="'Rp ' . number_format($financialStats['unpaid_total_amount'], 0, ',', '.')" 
            :subtitle="$financialStats['unpaid_records_count'] . ' transaksi'"
            color="red">
            <x-slot name="icon">
                <svg class="h-8 w-8 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-slot>
        </x-financial-card>
    </div>
</div>