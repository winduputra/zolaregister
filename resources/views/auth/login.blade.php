<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login - Zola Register">
    <title>Login - Zola Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        {{-- Decorative background --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-primary-100/40 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-primary-200/30 blur-3xl"></div>
        </div>

        {{-- Login Card --}}
        <div class="relative w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 shadow-xl shadow-primary-500/25 mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Zola Register</h1>
                <p class="text-gray-500 mt-2 text-base">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
                @if($errors->any())
                    <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-danger-50 border border-danger-500/20 text-danger-600 text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="contoh@zola.com"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-base text-gray-900 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200"
                        >
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-base text-gray-900 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200"
                        >
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="btn-login"
                            class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold text-base
                                   shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30
                                   hover:from-primary-700 hover:to-primary-800
                                   active:scale-[0.98] transition-all duration-200">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} Zola Register. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
