<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Jumpball Federation of India') | JFI</title>
    <meta name="description" content="@yield('meta_description', 'Jumpball Federation of India is the national body for the development, competition and governance of Jumpball in India.')"/>
    <meta name="theme-color" content="#0A2463"/>
    <link href="{{ url()->current() }}" rel="canonical"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Jumpball Federation of India"/>
    <meta property="og:title" content="@yield('title', 'Jumpball Federation of India')"/>
    <meta property="og:description" content="@yield('meta_description', 'Jumpball Federation of India is the national body for the development, competition and governance of Jumpball in India.')"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ asset('assets/images/jfi/og-default.jpg') }}"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Barlow:wght@500;600;700&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/jfi-theme.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/jfi-components.css') }}" rel="stylesheet"/>
    <link href="{{ asset('favicon.ico') }}" rel="icon" sizes="any"/>
    <link href="{{ asset('assets/images/jfi/favicon-32.png') }}" rel="icon" sizes="32x32" type="image/png"/>
    <link href="{{ asset('assets/images/jfi/apple-touch-icon.png') }}" rel="apple-touch-icon"/>
    <noscript><style>.animate-box{opacity:1}</style></noscript>
    @stack('styles')
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
@include('partials.header')
@include('partials.sidebar')
<main id="main-content" tabindex="-1">
@yield('content')
</main>
@include('partials.footer')
@include('partials.scripts')
@stack('scripts')
</body>
</html>
