<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            @include('layouts.navbar')
        </nav>
        
        @auth
        @if(Auth::user()->email_verified_at === null)
        <x-alert type="warning" :showCloseButton=false>
            <form action="{{route('verification.send')}}" method="post">
                @csrf
                <span>Your email have not been verified yet. Please click </span><button type="submit" class="alert-link btn btn-link p-0 align-baseline">here</button><span> to resend your verification email.</span>
            </form>
        </x-alert>
        @endif
        @endauth

        @if (session('status'))
            <x-alert type="{{ session('status') }}">
                {{ session('message') }}
            </x-alert>
        @endif
        
        <main class="py-4">
            @yield('content')
        </main>
        
    </div>
</body>
</html>
