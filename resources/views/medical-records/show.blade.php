<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Medical Record') }}
            </h2>
            <div>
                <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('medical-records.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informasi Pasien -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Informasi Pasien</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama Pasien</p>
                            <p class="font-medium">
                                <a href="{{ route('patients.show', $medicalRecord->patient) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $medicalRecord->patient->name }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NIK</p>
                            <p class="font-medium">{{ $medicalRecord->patient->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Umur</p>
                            <p class="font-medium">{{ $medicalRecord->patient->birth_date->age }} tahun</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Kelamin</p>
                            <p class="font-medium">{{ $medicalRecord->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Medical Record -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Detail Kunjungan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Tanggal Kunjungan</p>
                            <p class="font-medium">{{ $medicalRecord->visit_date->format('d F Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Keluhan Pasien</p>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p class="text-gray-800">{{ $medicalRecord->complaint }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Diagnosis</p>
                            <div class="bg-blue-50 p-4 rounded-md border-l-4 border-blue-500">
                                <p class="text-gray-800">{{ $medicalRecord->diagnosis }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Tindakan/Pengobatan</p>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p class="text-gray-800">{{ $medicalRecord->treatment }}</p>
                            </div>
                        </div>

                        @if($medicalRecord->prescription)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Resep Obat</p>
                            <div class="bg-green-50 p-4 rounded-md border-l-4 border-green-500">
                                <p class="text-gray-800">{{ $medicalRecord->prescription }}</p>
                            </div>
                        </div>
                        @endif

                        @if($medicalRecord->notes)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Catatan Tambahan</p>
                            <div class="bg-yellow-50 p-4 rounded-md">
                                <p class="text-gray-800">{{ $medicalRecord->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Biaya Pembayaran</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($medicalRecord->payment_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Status Pembayaran</p>
                                @if($medicalRecord->payment_status == 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        ✓ Sudah Dibayar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        ✗ Belum Dibayar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <p class="text-xs text-gray-500">
                                Dibuat: {{ $medicalRecord->created_at->format('d F Y, H:i') }} | 
                                Terakhir diupdate: {{ $medicalRecord->updated_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>