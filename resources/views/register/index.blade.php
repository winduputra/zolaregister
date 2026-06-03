@extends('layouts.app')

@section('title', 'Data Register - Zola Register')

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Data Register</h2>
            <p class="text-gray-500 mt-1 text-[15px]">Semua data register tutor</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="openExportModal()" id="btn-export-pdf"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-semibold
                            hover:bg-gray-50 hover:border-gray-300 active:scale-[0.98] transition-all duration-200">
                <svg class="w-4 h-4 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </button>
            <a href="{{ route('register.create') }}" id="btn-add-register"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-semibold
                       shadow-md shadow-primary-500/20 hover:bg-primary-700 active:scale-[0.98] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Register
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 mb-6">
        <form method="GET" action="{{ route('register.index') }}" id="form-filter" class="flex flex-col lg:flex-row items-end gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                <div class="w-full">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" id="filter-date"
                           class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50/50 text-base text-gray-900 font-semibold
                                   focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                </div>
                <div class="w-full">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Tutor</label>
                    <select name="tutor_id" id="filter-tutor"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50/50 text-base text-gray-900 font-semibold
                                    focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <option value="">Semua Tutor</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ request('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Program</label>
                    <select name="program" id="filter-program"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50/50 text-base text-gray-900 font-semibold
                                    focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <option value="">Semua Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>
                                {{ $program }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <button type="submit" id="btn-filter"
                        class="flex-1 lg:flex-none px-6 py-3 rounded-xl bg-primary-600 text-white font-bold text-sm
                                shadow-md shadow-primary-500/20 hover:bg-primary-700 active:scale-[0.98] transition-all">
                    Filter
                </button>
                <a href="{{ route('register.index') }}" id="btn-reset-filter"
                   class="px-6 py-3 rounded-xl bg-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-200 active:scale-[0.98] transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Data List --}}
    <div class="space-y-4">
        @if($registers->count() > 0)
            {{-- Table (Desktop Only) --}}
            <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left" id="table-registers">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Tutor</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Jam</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Siswa</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($registers as $index => $reg)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-400">{{ $registers->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $reg->register_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $reg->tutor->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-primary-50 text-primary-700 text-xs font-black">
                                            {{ $reg->classCode->code }}
                                        </span>
                                        <span class="text-gray-400 text-xs ml-1 font-medium">{{ $reg->classCode->program }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-600">{{ $reg->time_range }}</td>
                                    <td class="px-6 py-4 text-center font-black text-gray-900 text-lg">{{ $reg->student_count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $reg->notes ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('register.edit', $reg) }}"
                                               class="p-2 rounded-lg bg-warning-50 text-warning-600 hover:bg-warning-500 hover:text-white transition-all"
                                               title="Edit">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <button type="button"
                                                    onclick="openDeleteModal({{ $reg->id }}, '{{ $reg->tutor->name }}', '{{ $reg->register_date->format('d M Y') }}')"
                                                    class="p-2 rounded-lg bg-danger-50 text-danger-500 hover:bg-danger-500 hover:text-white transition-all"
                                                    title="Hapus">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Cards (Mobile Only) --}}
            <div class="lg:hidden space-y-3">
                @foreach($registers as $reg)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 relative overflow-hidden">
                        <div class="absolute top-0 right-0 px-3 py-1 rounded-bl-xl bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-wider">
                            {{ $reg->classCode->code }}
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-100 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-black text-gray-400 uppercase leading-none">{{ $reg->register_date->format('M') }}</span>
                                <span class="text-lg font-black text-gray-900 leading-none mt-0.5">{{ $reg->register_date->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-black text-gray-900 truncate">{{ $reg->tutor->name }}</h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-sm font-bold text-gray-500">{{ $reg->time_range }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm font-bold text-primary-600">{{ $reg->classCode->program }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="block text-2xl font-black text-gray-900">{{ $reg->student_count }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Siswa</span>
                            </div>
                        </div>
                        @if($reg->notes)
                            <div class="mt-3 px-3 py-2 rounded-xl bg-gray-50 text-sm text-gray-600 italic truncate">
                                "{{ $reg->notes }}"
                            </div>
                        @endif
                        <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium italic">Input oleh {{ explode(' ', $reg->user->name)[0] }}</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('register.edit', $reg) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-warning-50 text-warning-700 text-sm font-bold hover:bg-warning-100 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <button type="button"
                                        onclick="openDeleteModal({{ $reg->id }}, '{{ $reg->tutor->name }}', '{{ $reg->register_date->format('d M Y') }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-danger-50 text-danger-500 text-sm font-bold hover:bg-danger-100 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($registers->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $registers->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-[15px] font-medium">Tidak ada data register</p>
                <p class="text-gray-400 text-sm mt-1">Ubah filter atau tambahkan register baru</p>
            </div>
        @endif
    </div>

    @php
        $selectedExportMonth = request('date') ? \Carbon\Carbon::parse(request('date'))->format('Y-m') : now()->format('Y-m');
        $exportYear = \Carbon\Carbon::createFromFormat('Y-m', $selectedExportMonth)->year;
    @endphp

    {{-- Export PDF Month Modal --}}
    <div id="export-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        {{-- Backdrop --}}
        <div id="export-modal-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeExportModal()"></div>
        {{-- Modal Content --}}
        <div id="export-modal-content" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 transform scale-95 opacity-0 transition-all duration-200">
            <div class="flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-2xl bg-danger-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Export PDF Bulanan</h3>
                <p class="text-sm text-gray-500 mb-5">Pilih salah satu bulan {{ $exportYear }}, lalu klik Download PDF.</p>

                <form id="export-form" method="GET" action="{{ route('register.export-pdf') }}" class="w-full text-left">
                    @if(request('program'))
                        <input type="hidden" name="program" value="{{ request('program') }}">
                    @endif

                    <p class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Bulan</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach(range(1, 12) as $monthNumber)
                            @php
                                $monthDate = \Carbon\Carbon::create($exportYear, $monthNumber, 1);
                                $monthValue = $monthDate->format('Y-m');
                            @endphp
                            <label class="cursor-pointer">
                                <input type="radio" name="month" value="{{ $monthValue }}" class="sr-only"
                                       {{ $selectedExportMonth === $monthValue ? 'checked' : '' }} required>
                                <span data-export-month-option
                                      class="block rounded-xl border border-gray-100 bg-gray-50/50 px-3 py-3 text-center text-sm font-bold text-gray-700
                                             transition-all duration-200 hover:border-danger-200 hover:bg-danger-50/60"
                                      style="{{ $selectedExportMonth === $monthValue ? 'border-color: #fa5252; background-color: #fff5f5; color: #f03e3e; box-shadow: 0 0 0 2px rgba(250, 82, 82, 0.12);' : '' }}">
                                    {{ $monthDate->translatedFormat('F') }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-3 w-full mt-5">
                        <button type="button" onclick="closeExportModal()"
                                class="flex-1 py-3 px-4 rounded-xl bg-gray-100 text-gray-700 font-bold text-sm hover:bg-gray-200 active:scale-[0.98] transition-all">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 py-3 px-4 rounded-xl bg-danger-500 text-white font-bold text-sm hover:bg-danger-600 shadow-lg shadow-danger-500/25 active:scale-[0.98] transition-all">
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        {{-- Backdrop --}}
        <div id="delete-modal-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        {{-- Modal Content --}}
        <div id="delete-modal-content" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform scale-95 opacity-0 transition-all duration-200">
            <div class="flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-2xl bg-danger-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Hapus Register?</h3>
                <p class="text-sm text-gray-500 mb-1">Data ini akan dihapus secara permanen:</p>
                <p class="text-sm font-bold text-gray-700 mb-5" id="delete-modal-info">-</p>

                <form id="delete-form" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center gap-3 w-full">
                        <button type="button" onclick="closeDeleteModal()"
                                class="flex-1 py-3 px-4 rounded-xl bg-gray-100 text-gray-700 font-bold text-sm hover:bg-gray-200 active:scale-[0.98] transition-all">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 py-3 px-4 rounded-xl bg-danger-500 text-white font-bold text-sm hover:bg-danger-600 shadow-lg shadow-danger-500/25 active:scale-[0.98] transition-all">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function updateExportMonthSelection() {
        document.querySelectorAll('input[name="month"]').forEach((input) => {
            const option = input.closest('label')?.querySelector('[data-export-month-option]');

            if (!option) {
                return;
            }

            if (input.checked) {
                option.style.borderColor = '#fa5252';
                option.style.backgroundColor = '#fff5f5';
                option.style.color = '#f03e3e';
                option.style.boxShadow = '0 0 0 2px rgba(250, 82, 82, 0.12)';
                return;
            }

            option.style.borderColor = '';
            option.style.backgroundColor = '';
            option.style.color = '';
            option.style.boxShadow = '';
        });
    }

    function openExportModal() {
        const modal = document.getElementById('export-modal');
        const content = document.getElementById('export-modal-content');
        const selectedMonth = document.querySelector('input[name="month"]:checked');

        updateExportMonthSelection();

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
            selectedMonth?.focus();
        });
    }

    function closeExportModal() {
        const modal = document.getElementById('export-modal');
        const content = document.getElementById('export-modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }

    function openDeleteModal(id, tutorName, date) {
        const modal = document.getElementById('delete-modal');
        const content = document.getElementById('delete-modal-content');
        const info = document.getElementById('delete-modal-info');
        const form = document.getElementById('delete-form');

        info.textContent = tutorName + ' — ' + date;
        form.action = '/register/' + id;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        const content = document.getElementById('delete-modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
            closeDeleteModal();
        }
    });

    document.querySelectorAll('input[name="month"]').forEach((input) => {
        input.addEventListener('change', updateExportMonthSelection);
    });

    updateExportMonthSelection();
</script>
@endpush
