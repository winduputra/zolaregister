@extends('layouts.app')

@section('title', 'Edit Register - Zola Register')

@section('content')
    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-1">
            <a href="{{ route('register.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Edit Register</h2>
        </div>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('register.update', $register) }}" id="form-edit-register">
            @csrf
            @method('PUT')

            {{-- Row 1: Jadwal + Jumlah Siswa side by side --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                {{-- Jadwal --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <label class="block text-sm font-bold text-gray-900 mb-2">
                        📅 Jadwal (Hari & Jam)
                    </label>
                    @php
                        $editDateVal = old('datetime_picker') ? \Carbon\Carbon::parse(old('datetime_picker'))->format('Y-m-d') : $register->register_date->format('Y-m-d');
                        $editTimeVal = old('datetime_picker') ? \Carbon\Carbon::parse(old('datetime_picker'))->format('H:i') : \Carbon\Carbon::parse($register->start_time)->format('H:i');
                    @endphp
                    <input type="hidden" name="datetime_picker" id="datetime_picker" value="{{ $editDateVal }}T{{ $editTimeVal }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Date --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" id="input_date"
                                   value="{{ $editDateVal }}"
                                   required
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/30 text-base font-bold text-gray-900
                                           focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all cursor-pointer
                                           hover:bg-white hover:border-gray-200">
                        </div>
                        {{-- Time (24h select) --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <select id="input_time" required
                                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/30 text-base font-bold text-gray-900
                                            focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all cursor-pointer
                                            hover:bg-white hover:border-gray-200 appearance-none">
                                @for($h = 7; $h <= 21; $h++)
                                    @foreach(['00', '30'] as $m)
                                        @php $timeVal = sprintf('%02d:%s', $h, $m); @endphp
                                        <option value="{{ $timeVal }}" {{ $editTimeVal === $timeVal ? 'selected' : '' }}>
                                            {{ $timeVal }}
                                        </option>
                                    @endforeach
                                @endfor
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @error('datetime_picker')
                        <p class="mt-1.5 text-sm text-danger-500 font-medium">{{ $message }}</p>
                    @enderror

                    {{-- Time Preview (inline) --}}
                    <div id="time-preview" class="mt-3">
                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary-50/70 border border-primary-100">
                            <svg class="w-4 h-4 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-semibold text-primary-700">Estimasi:</span>
                            <span class="text-sm font-extrabold text-primary-800" id="time-range-display">-</span>
                        </div>
                    </div>
                </div>

                {{-- Jumlah Siswa --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col">
                    <label for="student_count" class="block text-sm font-bold text-gray-900 mb-2">
                        👨‍🎓 Jumlah Siswa
                    </label>
                    <div class="flex items-center gap-3 flex-1">
                        <button type="button" onclick="adjustCount(-1)" class="w-12 h-12 rounded-xl border-2 border-gray-100 flex items-center justify-center text-xl font-bold text-gray-500 hover:bg-gray-50 active:scale-95 transition-all shrink-0">−</button>
                        <input type="number" name="student_count" id="student_count" min="1" max="100"
                               value="{{ old('student_count', $register->student_count) }}" required
                               class="flex-1 h-12 text-center rounded-xl border-2 border-gray-100 bg-gray-50/50 text-2xl font-black text-gray-900
                                       focus:outline-none focus:border-primary-500 transition-all">
                        <button type="button" onclick="adjustCount(1)" class="w-12 h-12 rounded-xl border-2 border-gray-100 flex items-center justify-center text-xl font-bold text-gray-500 hover:bg-gray-50 active:scale-95 transition-all shrink-0">+</button>
                    </div>
                    @error('student_count')
                        <p class="mt-1.5 text-sm text-danger-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Row 2: Tutor + Kode Kelas side by side --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                {{-- Tutor --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <label class="block text-sm font-bold text-gray-900 mb-2">
                        👩‍🏫 Pilih Tutor
                    </label>
                    <div class="grid grid-cols-2 gap-2" id="tutor-selection">
                        @foreach($tutors as $tutor)
                            <label class="tutor-option relative cursor-pointer">
                                <input type="radio" name="tutor_id" value="{{ $tutor->id }}" class="sr-only peer"
                                       {{ old('tutor_id', $register->tutor_id) == $tutor->id ? 'checked' : '' }} required>
                                <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border-2 border-gray-100 bg-white
                                            peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:shadow-md peer-checked:shadow-primary-500/10
                                            hover:border-gray-200 hover:bg-gray-50 transition-all duration-200">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($tutor->name, 4, 1)) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-800 leading-tight truncate">{{ $tutor->name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('tutor_id')
                        <p class="mt-1.5 text-sm text-danger-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Kelas --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <label class="block text-sm font-bold text-gray-900 mb-2">
                        📚 Pilih Kelas
                    </label>
                    <div class="space-y-4" id="class-selection">
                        @foreach($groupedCodes as $program => $codes)
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-[0.08em] mb-2 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                                    {{ $program }}
                                    <span class="ml-auto text-[10px] bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $program === 'Mengaji' ? '60 min' : '90 min' }}
                                    </span>
                                </p>
                                <div class="grid grid-cols-5 gap-1.5">
                                    @foreach($codes as $code)
                                        <label class="class-option cursor-pointer">
                                            <input type="radio" name="class_code_id" value="{{ $code->id }}" class="sr-only peer"
                                                   data-duration="{{ $code->duration_minutes }}" data-program="{{ $code->program }}" data-code="{{ $code->code }}"
                                                   {{ old('class_code_id', $register->class_code_id) == $code->id ? 'checked' : '' }} required>
                                            <div class="py-2.5 rounded-lg border-2 border-gray-100 bg-gray-50/50 text-center
                                                        peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-700
                                                        hover:border-gray-200 transition-all">
                                                <span class="text-sm font-bold">{{ $code->code }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('class_code_id')
                        <p class="mt-1.5 text-sm text-danger-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Row 3: Keterangan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-4">
                <label for="notes" class="block text-sm font-bold text-gray-900 mb-2">
                    📝 Keterangan <span class="text-xs font-normal text-gray-400">(opsional)</span>
                </label>
                <textarea name="notes" id="notes" rows="2" placeholder="Tulis keterangan tambahan..."
                          class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50/50 text-sm text-gray-900
                                  focus:outline-none focus:border-primary-500 transition-all resize-none">{{ old('notes', $register->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-sm text-danger-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center gap-3">
                <button type="submit" id="btn-update-register"
                        class="flex-1 py-3.5 px-6 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold text-base
                                shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30
                                hover:from-primary-700 hover:to-primary-800
                                active:scale-[0.98] transition-all duration-200">
                    ✏️ Update Register
                </button>
                <a href="{{ route('register.index') }}" id="btn-cancel-edit"
                   class="py-3.5 px-6 rounded-xl bg-gray-100 text-gray-600 font-semibold text-base
                           hover:bg-gray-200 active:scale-[0.98] transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function adjustCount(amount) {
        const input = document.getElementById('student_count');
        let val = parseInt(input.value) || 0;
        val = Math.max(1, Math.min(100, val + amount));
        input.value = val;
    }

    function combineDatetime() {
        const dateVal = document.getElementById('input_date').value;
        const timeVal = document.getElementById('input_time').value;
        if (dateVal && timeVal) {
            document.getElementById('datetime_picker').value = dateVal + 'T' + timeVal;
        }
    }

    function updateTimePreview() {
        combineDatetime();

        const timeVal = document.getElementById('input_time').value;
        if (!timeVal) return;

        const [hours, minutes] = timeVal.split(':').map(Number);

        // Get selected class duration
        const selectedClass = document.querySelector('input[name="class_code_id"]:checked');
        let duration = 90;
        if (selectedClass) {
            duration = parseInt(selectedClass.dataset.duration);
        }

        const totalMinutes = hours * 60 + minutes + duration;
        const endH = Math.floor(totalMinutes / 60) % 24;
        const endM = totalMinutes % 60;

        const startStr = timeVal;
        const endStr = String(endH).padStart(2, '0') + ':' + String(endM).padStart(2, '0');

        document.getElementById('time-range-display').textContent = startStr + ' — ' + endStr;
    }

    // Listen for changes
    document.getElementById('input_date').addEventListener('change', updateTimePreview);
    document.getElementById('input_time').addEventListener('change', updateTimePreview);
    document.querySelectorAll('input[name="class_code_id"]').forEach(input => {
        input.addEventListener('change', updateTimePreview);
    });

    // Initialize
    updateTimePreview();
</script>
@endpush
