-<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Medical Record Terbaru</h3>
                <a href="{{ route('medical-records.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentRecords as $record)
                    <div class="border-l-4 border-blue-500 pl-4 py-2 bg-gray-50">
                        <p class="font-medium text-gray-900">{{ $record->patient->name }}</p>
                        <p class="text-sm text-gray-600">{{ Str::limit($record->diagnosis, 50) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $record->visit_date->format('d M Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada medical record</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pasien Terbaru</h3>
                <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPatients as $patient)
                    <div class="border-l-4 border-green-500 pl-4 py-2 bg-gray-50">
                        <p class="font-medium text-gray-900">{{ $patient->name }}</p>
                        <p class="text-sm text-gray-600">{{ $patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }} - {{ $patient->birth_date->age }} tahun</p>
                        <p class="text-xs text-gray-500 mt-1">Terdaftar: {{ $patient->created_at->format('d M Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada pasien</p>
                @endforelse
            </div>
        </div>
    </div>
</div>