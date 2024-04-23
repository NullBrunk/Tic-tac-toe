<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title", config("app.name"))</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>       
        <link rel="shortcut icon" href="{{ asset("/favicon.svg") }}" type="image/x-icon">

        
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

        @vite(['resources/css/style.css', 'resources/js/app.js'])
    </head>

    <body>
        @include("layout.partials._header")
        <main role="main">
            @yield("body")
        </main>
    
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    </body>


</html>
