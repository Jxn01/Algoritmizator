<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algoritmizátor - @yield('title')</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<script>
    window.currentPage = '@yield('title')';
</script>
    @include('components.navbar')
    @yield('content')
    @include('components.footer')
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
