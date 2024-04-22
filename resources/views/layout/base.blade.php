<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title", config("app.name"))</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>        
        
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        {{-- <link rel="stylesheet" href="{{ asset("/assets/css/style.min.css") }}"> --}}
        @vite(['resources/css/style.css', 'resources/js/app.js'])

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        {{-- <script src="{{ asset("/assets/js/app.min.js") }}"></script> --}}

        <link rel="shortcut icon" href="{{ asset("/favicon.svg") }}" type="image/x-icon">
    </head>

    <body>
        @include("layout.partials._header")
        @yield("body")
    </body>

</html>