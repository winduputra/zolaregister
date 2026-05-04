@extends('layouts.app')

@section('title', 'Edit Tutor - Zola Register')

@section('content')
    <div class="mb-5 lg:mb-8">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('tutors.index') }}" class="hover:text-primary-600 transition-colors">Kelola Tutor</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">Edit</span>
        </div>
        <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Edit Tutor</h2>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
            <form action="{{ route('tutors.update', $tutor) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tutor</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $tutor->name) }}" required autofocus
                               class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary-500 focus:ring-primary-500 transition-all duration-200 
                                      @error('name') border-danger-500 ring-danger-500 @enderror"
                               placeholder="Masukkan nama lengkap tutor">
                        @error('name')
                            <p class="mt-2 text-sm text-danger-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" 
                                class="flex-1 px-6 py-3.5 rounded-xl bg-primary-600 text-white font-bold shadow-lg shadow-primary-500/25 hover:bg-primary-700 active:scale-[0.99] transition-all duration-200">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('tutors.index') }}" 
                           class="px-6 py-3.5 rounded-xl bg-gray-50 text-gray-600 font-bold hover:bg-gray-100 transition-all duration-200">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
