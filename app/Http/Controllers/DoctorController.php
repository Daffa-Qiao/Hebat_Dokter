<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $specialization = $request->get('specialization');
        $query = User::where('role', 'dokter');

        if ($specialization) {
            $query->where('specialization', 'like', "%{$specialization}%");
        }

        $doctors = $query->orderBy('name')->get();
        return view('doctors.index', compact('doctors', 'specialization'));
    }

    public function show(User $doctor)
    {
        if ($doctor->role !== 'dokter') {
            abort(404);
        }

        return view('doctors.show', compact('doctor'));
    }
}
