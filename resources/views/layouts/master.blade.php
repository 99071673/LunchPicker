<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunchpicker</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body>

    <header>
        <div class="font-bold text-2xl">Lunchpicker</div>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer>
        &copy; 2025 Lunchpicker
    </footer>

</body>
</html>
