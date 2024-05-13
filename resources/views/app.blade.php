<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/algoritmizator/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/algoritmizator/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/algoritmizator/favicon-16x16.png">
    <link rel="manifest" href="/algoritmizator/site.webmanifest">
    <link rel="mask-icon" href="/algoritmizator/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
