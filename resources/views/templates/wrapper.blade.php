<!DOCTYPE html>
<html>
    <head>
        <title>Halex</title>

        @section('meta')
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="robots" content="noindex">
            <link rel="apple-touch-icon" sizes="180x180" href="https://cdn.discordapp.com/attachments/987734229469253674/1008833382957973675/Copy_of_untitled_29.png">
            <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/987734229469253674/1008833382957973675/Copy_of_untitled_29.png" sizes="32x32">
            <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/987734229469253674/1008833382957973675/Copy_of_untitled_29.png" sizes="16x16">
            <link rel="manifest" href="/favicons/manifest.json">
            <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
            <link rel="shortcut icon" href="/favicons/favicon.ico">
            <meta name="msapplication-config" content="/favicons/browserconfig.xml">
            <meta name="theme-color" content="#0e4688">
        @show

        @section('user-data')
            @if(!is_null(Auth::user()))
                <script>
                    window.JexactylUser = {!! json_encode(Auth::user()->toVueObject()) !!};
                </script>
            @endif
            @if(!empty($siteConfiguration))
                <script>
                    window.SiteConfiguration = {!! json_encode($siteConfiguration) !!};
                </script>
            @endif
            @if(!empty($storeConfiguration))
                <script>
                    window.StoreConfiguration = {!! json_encode($storeConfiguration) !!};
                </script>
            @endif
        @show
        <style>
           @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        </style>

        @yield('assets')

        @include('layouts.scripts')
    </head>
    <body style="font-family: 'Inter', sans-serif !important;">
        @section('content')
            @yield('above-container')
            @yield('container')
            @yield('below-container')
        @show
        @section('scripts')
            {!! $asset->js('main.js') !!}
        @show
    </body>
</html>
