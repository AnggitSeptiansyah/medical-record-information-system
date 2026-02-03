<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_amount' => 'required|integer|min:0',
            'payment_status' => 'required|in:unpaid,paid',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Pasien wajib dipilih',
            'patient_id.exists' => 'Pasien tidak ditemukan',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi',
            'complaint.required' => 'Keluhan pasien wajib diisi',
            'diagnosis.required' => 'Diagnosis wajib diisi',
            'treatment.required' => 'Tindakan/pengobatan wajib diisi',
            'payment_amount.min' => 'Biaya minimal 0',
            'payment_status.required' => 'Status pembayaran wajib dipilih',
        ];
    }
}
