<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicalRecords = MedicalRecord::with('patient')->latest()->paginate(15);
        return view('medical-records.index', compact('medicalRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        return view('medical-records.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        MedicalRecord::create($request->validated());
        return redirect()->route('medical-records.index')
            ->with('success', 'Medical Record berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');
        return view('medical-records.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::orderBy('name')->get();
        return view('medical-records.edit', compact('medicalRecord', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->validated());
        return redirect()->route('medical-records.index')
            ->with('success', 'Medical Record berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical Record berhasil dihapus!');
    }
}
