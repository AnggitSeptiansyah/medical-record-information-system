<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Medical Record Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('medical-records.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Pilih Pasien *</label>
                            <select name="patient_id" id="patient_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Cari Pasien --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} - {{ $patient->nik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="visit_date" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan *</label>
                            <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('visit_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="complaint" class="block text-sm font-medium text-gray-700">Keluhan Pasien *</label>
                            <textarea name="complaint" id="complaint" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('complaint') }}</textarea>
                            @error('complaint')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis *</label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('diagnosis') }}</textarea>
                            @error('diagnosis')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="treatment" class="block text-sm font-medium text-gray-700">Tindakan/Pengobatan *</label>
                            <textarea name="treatment" id="treatment" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('treatment') }}</textarea>
                            @error('treatment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="prescription" class="block text-sm font-medium text-gray-700">Resep Obat</label>
                            <textarea name="prescription" id="prescription" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('prescription') }}</textarea>
                            @error('prescription')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_amount" class="block text-sm font-medium text-gray-700">Biaya Pembayaran (Rp) *</label>
                            <input type="number" name="payment_amount" id="payment_amount" value="{{ old('payment_amount', 0) }}" required min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('payment_amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Status Pembayaran *</label>
                            <select name="payment_status" id="payment_status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            </select>
                            @error('payment_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('medical-records.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.getElementById('patient_id');
            const choices = new Choices(element, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari nama atau NIK pasien...',
                noResultsText: 'Tidak ada pasien ditemukan',
                itemSelectText: 'Tekan untuk memilih',
                shouldSort: false,
                placeholder: true,
                placeholderValue: '-- Cari Pasien --'
            });
        });
    </script>
    @endpush

</x-app-layout>