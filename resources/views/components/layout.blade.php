<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@php $title = $title ?? 'Wheely Good Cars!'; echo $title; @endphp </title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
</head>
<style>
</style>

<body class="bg-slate-100">
    <x-header />
    <main>
        {{ $slot }}
    </main>
</body>

</html>