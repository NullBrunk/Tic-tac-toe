<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title", config("app.name"))</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="shortcut icon" href="{{ asset("/favicon.svg") }}" type="image/x-icon">

        
        <link rel="stylesheet" href="{{ asset("/assets/vendor/aos.css") }}" />
        <script src="{{ asset("/assets/vendor/sweetalert.js") }}"></script>

        @vite(['resources/css/style.css', 'resources/js/app.js'])
    </head>

    <body>
        <div class="grid">
            <svg class="grid-svg" xmlns="http://www.w3.org/2000/svg" width="982" height="786" viewBox="0 0 982 786" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M490 401V537H348.5V401H490ZM490 785.5V676H348.5V785.5H347.5V676H206V785.5H205V676H63.5V785.5H62.5V676H0V675H62.5V538H0V537H62.5V401H0V400H62.5V258H0V257H62.5V116H0V115H62.5V0H63.5V115L205 115V0H206V115L347.5 115V0H348.5V115H490V0H491V115L627.5 115V0H628.5V115H765V0H766V115L902.5 115V0H903.5V115H982V116H903.5V257H982V258H903.5V400H982V401H903.5V537H982V538H903.5V675H982V676H903.5V785.5H902.5V676H766V785.5H765V676H628.5V785.5H627.5V676H491V785.5H490ZM902.5 675V538H766V675H902.5ZM902.5 537V401H766V537H902.5ZM902.5 400V258H766V400H902.5ZM902.5 257V116L766 116V257H902.5ZM627.5 675H491V538H627.5V675ZM765 675H628.5V538H765V675ZM348.5 675H490V538H348.5V675ZM347.5 538V675H206V538H347.5ZM205 538V675H63.5V538H205ZM765 537V401H628.5V537H765ZM765 400V258H628.5V400H765ZM765 257V116H628.5V257H765ZM347.5 401V537H206V401H347.5ZM205 401V537H63.5V401H205ZM627.5 401V537H491V401H627.5ZM627.5 116L491 116V257H627.5V116ZM627.5 258H491V400H627.5V258ZM63.5 257V116L205 116V257H63.5ZM63.5 400V258H205V400H63.5ZM206 116V257H347.5V116L206 116ZM348.5 116V257H490V116H348.5ZM206 400V258H347.5V400H206ZM348.5 258V400H490V258H348.5Z" fill="url(#paint0_radial_1_8)" />
              <defs>
                <radialGradient id="paint0_radial_1_8" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(491 392.75) rotate(90) scale(513.25 679.989)">
                  <stop stop-color="white" stop-opacity="0.2" />
                  <stop offset="1" stop-color="#000" stop-opacity="0" />
                </radialGradient>
              </defs>
            </svg>
            <div class="blur"></div>
        </div>

        @include("layout.partials._header")
        <main role="main">
            @yield("body")
        </main>
    
        <script src="{{ asset("/assets/vendor/aos.js") }}"></script>
    </body>


</html>
