<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wymianka</title>
    @routes
    @vite('resources/js/app.js')
        @inertiaHead
</head>

<body class="bg-light-background-50 text-light-text">
    @inertia
</body>

</html>
