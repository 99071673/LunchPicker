<!DOCTYPE html>
<html lang="nl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunchpicker</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body class="min-h-screen m-0 font-sans bg-gray-300 flex flex-col">

    <header class="bg-[#00333f] text-white p-5 grid grid-cols-3 items-center">
        <div class="font-bold text-4xl">Lunchpicker</div>

        <div class="font-bold text-4xl text-center">@yield('pagetitle')</div>

        <div class="flex justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-14">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 
                        0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 
                        9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
        </div>
    </header>

    <main class="flex-1 p-10 px-5 flex justify-center gap-10 flex-wrap">
        @yield('content')
    </main>

    <footer class="bg-[#00333f] text-white text-center p-2.5">
        &copy; 2025 Lunchpicker
    </footer>

</body>
</html>
