<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WingaTZ') }} — {{ __('ui.ingia') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-indigo-900 font-bold text-xl">W</div>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">WinGatz</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('ui.usimamizi') }}</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">{{ __('ui.ingia') }}</h2>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ $errors->first('email') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.barua_pepe') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white @error('email') border-red-300 @enderror"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.nywila') }}</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-indigo-600">
                    <label for="remember" class="text-sm text-gray-600">{{ __('ui.nikikumbuke') }}</label>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                    {{ __('ui.ingia') }}
                </button>
            </form>
        </div>

        <!-- Language switcher -->
        <div class="flex justify-center gap-3 mt-6">
            <a href="{{ route('lugha.badilisha', 'sw') }}"
               class="text-sm px-3 py-1 rounded transition {{ app()->getLocale() === 'sw' ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-400 hover:text-gray-600' }}">
                🇹🇿 Kiswahili
            </a>
            <a href="{{ route('lugha.badilisha', 'en') }}"
               class="text-sm px-3 py-1 rounded transition {{ app()->getLocale() === 'en' ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-400 hover:text-gray-600' }}">
                🇬🇧 English
            </a>
        </div>

    </div>
</body>
</html>
