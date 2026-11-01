<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Jumpball Federation of India') | JFI</title>
    <meta name="theme-color" content="#0A2463"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Barlow:wght@500;600;700&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/jfi-theme.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/images/jfi-logo.png') }}" rel="icon"/>
</head>
<body>
<main>
@yield('content')
</main>
@include('partials.scripts')
</body>
</html>
