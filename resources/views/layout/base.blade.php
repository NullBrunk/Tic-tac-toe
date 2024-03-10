<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title", config("app.name"))</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        
        {{-- Uncomment this line if you prefer to use bootstrap icons --}}
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
        
        <link rel="stylesheet" href="/assets/css/style.min.css">
        <script src="/assets/js/app.min.js"></script>
    </head>

    <body>
        @include("layout.header")
        @yield("body")
    </body>

</html>