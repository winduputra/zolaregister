<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todayRegisters = Register::with(['tutor', 'classCode'])
            ->whereDate('register_date', $today)
            ->orderBy('start_time')
            ->get();

        $totalToday = $todayRegisters->count();
        $totalStudentsToday = $todayRegisters->sum('student_count');

        $totalAll = Register::count();
        $totalStudentsAll = Register::sum('student_count');

        return view('dashboard', compact(
            'todayRegisters',
            'totalToday',
            'totalStudentsToday',
            'totalAll',
            'totalStudentsAll'
        ));
    }
}
