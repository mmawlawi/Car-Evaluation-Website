<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @yield('styles')
</head>
<body>

@include('partials.header')

@include('partials.nav')

<main>
    @yield('content')
</main>

@include('partials.footer')

<script src="{{ asset('js/script.js') }}"></script>
@yield('scripts')

</body>
</html>
