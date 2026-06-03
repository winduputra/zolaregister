<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index()
    {
        $tutors = Tutor::withCount('registers')->orderBy('name')->get();
        return view('tutors.index', compact('tutors'));
    }

    public function create()
    {
        return view('tutors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tutors,name',
        ]);

        Tutor::create($request->all());

        return redirect()->route('tutors.index')->with('success', 'Tutor berhasil ditambahkan.');
    }

    public function edit(Tutor $tutor)
    {
        return view('tutors.edit', compact('tutor'));
    }

    public function update(Request $request, Tutor $tutor)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tutors,name,' . $tutor->id,
        ]);

        $tutor->update($request->all());

        return redirect()->route('tutors.index')->with('success', 'Tutor berhasil diperbarui.');
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->delete();

        return redirect()->route('tutors.index')->with('success', 'Tutor dan data register terkait berhasil dihapus.');
    }
}
