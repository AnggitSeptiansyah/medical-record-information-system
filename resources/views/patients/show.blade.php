<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pasien') }}
            </h2>
            <div>
                <a href="{{ route('patients.edit', $patient) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('patients.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Data Pasien -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">NIK</p>
                            <p class="font-medium">{{ $patient->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Lengkap</p>
                            <p class="font-medium">{{ $patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Lahir</p>
                            <p class="font-medium">{{ $patient->birth_date->format('d F Y') }} ({{ $patient->birth_date->age }} tahun)</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Kelamin</p>
                            <p class="font-medium">{{ $patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Golongan Darah</p>
                            <p class="font-medium">{{ $patient->blood_type ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Telepon</p>
                            <p class="font-medium">{{ $patient->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $patient->email ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Alamat</p>
                            <p class="font-medium">{{ $patient->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Medical Record -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Medical Record</h3>
                    
                    @if($patient->medicalRecords->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kunjungan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($patient->medicalRecords as $record)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $record->visit_date->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 text-sm">{{ Str::limit($record->complaint, 50) }}</td>
                                            <td class="px-6 py-4 text-sm">{{ Str::limit($record->diagnosis, 50) }}</td>
                                            <td class="px-6 py-4 text-sm">{{ Str::limit($record->treatment, 50) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada riwayat medical record</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>