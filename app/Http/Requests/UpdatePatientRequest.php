<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
        $patientId = $this->route('patient')->id;
        
        return [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:patients,nik,' . $patientId,
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'blood_type' => 'nullable|in:A,B,AB,O',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pasien wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'address.required' => 'Alamat wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
        ];
    }

}
