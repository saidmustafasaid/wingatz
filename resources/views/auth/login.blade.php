<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WingaTZ') }} — {{ __('ui.ingia') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(135deg, #0d0221 0%, #1a0845 40%, #2d1b69 70%, #0d0221 100%)" class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #1a0845, #2d1b69); box-shadow: 0 0 30px rgba(139,92,246,0.4), inset 0 1px 0 rgba(255,255,255,0.1);">
                <div class="logo-badge w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-xl">W</div>
            </div>
            <h1 class="text-2xl font-bold text-white">WinGatz</h1>
            <p class="text-sm text-purple-300 mt-1">{{ __('ui.usimamizi') }}</p>
        </div>

        <!-- Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8" style="box-shadow: 0 25px 60px rgba(13,2,33,0.5), 0 0 0 1px rgba(139,92,246,0.15);">
            <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('ui.ingia') }}</h2>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first('email') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('ui.barua_pepe') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 bg-gray-50 hover:border-purple-300 transition @error('email') border-red-300 @enderror"
                           style="--tw-ring-color: rgba(124,58,237,0.4);"/>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('ui.nywila') }}</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 bg-gray-50 hover:border-purple-300 transition"
                           style="--tw-ring-color: rgba(124,58,237,0.4);"/>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300">
                    <label for="remember" class="text-sm text-gray-600">{{ __('ui.nikikumbuke') }}</label>
                </div>

                <button type="submit" class="btn-primary w-full text-white py-2.5 rounded-xl text-sm font-bold">
                    {{ __('ui.ingia') }}
                </button>
            </form>
        </div>

        <!-- Language switcher -->
        <div class="flex justify-center gap-3 mt-6">
            <a href="{{ route('lugha.badilisha', 'sw') }}"
               class="text-sm px-4 py-1.5 rounded-lg transition font-medium {{ app()->getLocale() === 'sw' ? 'lang-active' : 'text-purple-300 hover:text-white hover:bg-white/10' }}">
                🇹🇿 Kiswahili
            </a>
            <a href="{{ route('lugha.badilisha', 'en') }}"
               class="text-sm px-4 py-1.5 rounded-lg transition font-medium {{ app()->getLocale() === 'en' ? 'lang-active' : 'text-purple-300 hover:text-white hover:bg-white/10' }}">
                🇬🇧 English
            </a>
        </div>

    </div>
</body>
</html>
