<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Tutor;
use App\Models\ClassCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $query = Register::with(['tutor', 'classCode', 'user']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('register_date', $request->date);
        }

        // Filter by tutor
        if ($request->filled('tutor_id')) {
            $query->where('tutor_id', $request->tutor_id);
        }

        // Filter by program
        if ($request->filled('program')) {
            $query->whereHas('classCode', function ($q) use ($request) {
                $q->where('program', $request->program);
            });
        }

        $registers = $query->orderBy('register_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $tutors = Tutor::orderBy('name')->get();
        $programs = ClassCode::select('program')->distinct()->orderBy('program')->pluck('program');

        return view('register.index', compact('registers', 'tutors', 'programs'));
    }

    public function create()
    {
        $tutors = Tutor::orderBy('name')->get();
        $classCodes = ClassCode::orderBy('program')->orderBy('code')->get();

        // Group class codes by program for the dropdown
        $groupedCodes = $classCodes->groupBy('program');

        return view('register.create', compact('tutors', 'classCodes', 'groupedCodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
            'class_code_id' => 'required|exists:class_codes,id',
            'datetime_picker' => 'required',
            'student_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        // Parse datetime picker
        $datetime = Carbon::parse($validated['datetime_picker']);
        $registerDate = $datetime->toDateString();
        $startTime = $datetime->format('H:i');

        // Calculate end time based on class duration
        $classCode = ClassCode::findOrFail($validated['class_code_id']);
        $endTime = $datetime->copy()->addMinutes($classCode->duration_minutes);

        Register::create([
            'user_id' => auth()->id(),
            'tutor_id' => $validated['tutor_id'],
            'class_code_id' => $validated['class_code_id'],
            'register_date' => $registerDate,
            'start_time' => $startTime,
            'end_time' => $endTime->format('H:i'),
            'student_count' => $validated['student_count'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('register.index')
            ->with('success', 'Register berhasil ditambahkan!');
    }

    public function edit(Register $register)
    {
        $tutors = Tutor::orderBy('name')->get();
        $classCodes = ClassCode::orderBy('program')->orderBy('code')->get();
        $groupedCodes = $classCodes->groupBy('program');

        return view('register.edit', compact('register', 'tutors', 'classCodes', 'groupedCodes'));
    }

    public function update(Request $request, Register $register)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
            'class_code_id' => 'required|exists:class_codes,id',
            'datetime_picker' => 'required',
            'student_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        // Parse datetime picker
        $datetime = Carbon::parse($validated['datetime_picker']);
        $registerDate = $datetime->toDateString();
        $startTime = $datetime->format('H:i');

        // Recalculate end time
        $classCode = ClassCode::findOrFail($validated['class_code_id']);
        $endTime = $datetime->copy()->addMinutes($classCode->duration_minutes);

        $register->update([
            'tutor_id' => $validated['tutor_id'],
            'class_code_id' => $validated['class_code_id'],
            'register_date' => $registerDate,
            'start_time' => $startTime,
            'end_time' => $endTime->format('H:i'),
            'student_count' => $validated['student_count'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('register.index')
            ->with('success', 'Register berhasil diperbarui!');
    }

    public function destroy(Register $register)
    {
        $register->delete();

        return redirect()->route('register.index')
            ->with('success', 'Register berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $validated = $request->validate([
            'month' => 'nullable|date_format:Y-m',
            'program' => 'nullable|string',
        ]);

        $period = Carbon::createFromFormat('Y-m', $validated['month'] ?? now()->format('Y-m'))->startOfMonth();
        $periodLabel = $period->translatedFormat('F Y');
        $tutors = Tutor::all();
        $tutorData = [];

        foreach ($tutors as $tutor) {
            $query = Register::where('tutor_id', $tutor->id)
                ->with(['classCode', 'user'])
                ->whereBetween('register_date', [
                    $period->copy()->startOfMonth()->toDateString(),
                    $period->copy()->endOfMonth()->toDateString(),
                ]);

            if ($request->filled('program')) {
                $query->whereHas('classCode', function ($q) use ($request) {
                    $q->where('program', $request->program);
                });
            }

            $registers = $query->orderBy('register_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

            // Calculate summary
            $totalStudents = $registers->sum('student_count');
            $classCounts = [];
            foreach ($registers as $reg) {
                $program = $reg->classCode->program;
                $classCounts[$program] = ($classCounts[$program] ?? 0) + 1;
            }

            $tutorData[] = [
                'tutor' => $tutor,
                'registers' => $registers,
                'totalStudents' => $totalStudents,
                'classCounts' => $classCounts,
            ];
        }

        $filterInfo = [];
        $filterInfo[] = 'Bulan: ' . $periodLabel;
        if ($request->filled('program')) {
            $filterInfo[] = 'Program: ' . $request->program;
        }

        $pdf = Pdf::loadView('register.pdf', compact('tutorData', 'filterInfo', 'periodLabel'));
        $pdf->setPaper('A4', 'portrait'); // Change to portrait for better readability per tutor

        $filename = 'laporan-register-' . $period->format('Y-m') . '.pdf';

        return $pdf->download($filename);
    }
}
