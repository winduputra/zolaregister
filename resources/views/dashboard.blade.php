@extends('layouts.app')

@section('title', 'Dashboard - Zola Register')

@section('content')
    {{-- Page Header --}}
    <div class="mb-5 lg:mb-8">
        <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-500 mt-0.5 text-sm lg:text-[15px]">Selamat datang, {{ auth()->user()->name }}! 👋</p>
    </div>

    {{-- Stats Grid - 2 columns on mobile, compact --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5 mb-6 lg:mb-10">
        {{-- Today's Registers --}}
        <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 p-3.5 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 lg:w-6 lg:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="hidden lg:inline text-xs font-semibold text-primary-600 bg-primary-50 px-2.5 py-1 rounded-full">Hari Ini</span>
            </div>
            <p class="text-2xl lg:text-3xl font-extrabold text-gray-900">{{ $totalToday }}</p>
            <p class="text-xs lg:text-sm text-gray-500 mt-0.5">Register hari ini</p>
        </div>

        {{-- Today's Students --}}
        <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 p-3.5 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-success-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 lg:w-6 lg:h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <span class="hidden lg:inline text-xs font-semibold text-success-600 bg-success-50 px-2.5 py-1 rounded-full">Hari Ini</span>
            </div>
            <p class="text-2xl lg:text-3xl font-extrabold text-gray-900">{{ $totalStudentsToday }}</p>
            <p class="text-xs lg:text-sm text-gray-500 mt-0.5">Siswa hari ini</p>
        </div>

        {{-- Total Registers --}}
        <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 p-3.5 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-warning-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 lg:w-6 lg:h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="hidden lg:inline text-xs font-semibold text-warning-600 bg-warning-50 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <p class="text-2xl lg:text-3xl font-extrabold text-gray-900">{{ $totalAll }}</p>
            <p class="text-xs lg:text-sm text-gray-500 mt-0.5">Total register</p>
        </div>

        {{-- Total Students --}}
        <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 p-3.5 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 lg:w-6 lg:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="hidden lg:inline text-xs font-semibold text-primary-600 bg-primary-50 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <p class="text-2xl lg:text-3xl font-extrabold text-gray-900">{{ $totalStudentsAll }}</p>
            <p class="text-xs lg:text-sm text-gray-500 mt-0.5">Total siswa</p>
        </div>
    </div>

    {{-- Today's Schedule --}}
    <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-4 py-3.5 lg:px-6 lg:py-5 border-b border-gray-100">
            <div>
                <h3 class="text-base lg:text-lg font-bold text-gray-900">Register Hari Ini</h3>
                <p class="text-xs lg:text-sm text-gray-500 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <a href="{{ route('register.create') }}" id="btn-quick-add"
               class="inline-flex items-center gap-1.5 px-3 py-2 lg:px-4 lg:py-2.5 rounded-lg lg:rounded-xl bg-primary-600 text-white text-sm font-semibold
                       shadow-md shadow-primary-500/20 hover:bg-primary-700 active:scale-[0.98] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Tambah</span>
            </a>
        </div>

        @if($todayRegisters->count() > 0)
            {{-- Mobile Card View --}}
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($todayRegisters as $reg)
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-semibold text-gray-900 text-sm">{{ $reg->tutor->name }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-primary-50 text-primary-700 text-xs font-semibold">
                                {{ $reg->classCode->code }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $reg->time_range }}
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $reg->student_count }} siswa
                            </span>
                            <span class="text-gray-400">{{ $reg->classCode->program }}</span>
                        </div>
                        @if($reg->notes)
                            <p class="text-xs text-gray-400 mt-1 truncate">{{ $reg->notes }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left" id="table-today-registers">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tutor</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($todayRegisters as $reg)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900 text-[15px]">{{ $reg->tutor->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-sm font-semibold">
                                        {{ $reg->classCode->code }}
                                    </span>
                                    <span class="text-gray-500 text-sm ml-1">{{ $reg->classCode->program }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[15px] font-medium text-gray-700">{{ $reg->time_range }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[15px] font-bold text-gray-900">{{ $reg->student_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">{{ $reg->notes ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-4 py-12 lg:px-6 lg:py-16 text-center">
                <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-xl lg:rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-3 lg:mb-4">
                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm lg:text-[15px] font-medium">Belum ada register hari ini</p>
                <p class="text-gray-400 text-xs lg:text-sm mt-1">Klik "+" untuk mulai menginput register</p>
            </div>
        @endif
    </div>
@endsection
