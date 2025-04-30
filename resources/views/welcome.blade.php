<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Library</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-200">
    <div id="app"></div>

    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}">
        window.user = @json(auth()->user());
    </script>
</body>
</html>