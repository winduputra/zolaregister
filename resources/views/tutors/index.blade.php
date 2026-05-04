@extends('layouts.app')

@section('title', 'Kelola Tutor - Zola Register')

@section('content')
    <div class="mb-5 lg:mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Kelola Tutor</h2>
            <p class="text-gray-500 mt-0.5 text-sm lg:text-[15px]">Daftar nama tutor yang tersedia di sistem.</p>
        </div>
        <a href="{{ route('tutors.create') }}" 
           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-semibold
                   shadow-md shadow-primary-500/20 hover:bg-primary-700 active:scale-[0.98] transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Tutor
        </a>
    </div>

    <div class="bg-white rounded-xl lg:rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Tutor</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Register</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tutors as $tutor)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900 text-[15px]">{{ $tutor->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
                                    {{ $tutor->registers_count }} data
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tutors.edit', $tutor) }}" 
                                       class="p-2 rounded-lg text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L11.707 15.207a1 1 0 01-.44.253l-3 .75a1 1 0 01-1.147-1.147l.75-3a1 1 0 01.253-.44L16.5 3.5z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('tutors.destroy', $tutor) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tutor ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-danger-600 hover:bg-danger-50 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    <p class="text-[15px] font-medium">Belum ada data tutor</p>
                                    <p class="text-sm text-gray-400 mt-1">Silakan tambahkan tutor baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
