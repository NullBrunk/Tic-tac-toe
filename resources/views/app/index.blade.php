@extends('layout.base')

@section("title", "Index page")


@section("body")

    <section id="index" class="container index-page" style="margin-top: 0rem;">
        {{-- <div data-aos="zoom-in" data-aos-duration="1000" class="game main-img up-down">
            
        </div> --}}

            <div class="index-title">
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" fill="#f9faff" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M504.4 115.8a5.7 5.7 0 0 0 -.3-.7 8.5 8.5 0 0 0 -.5-1.3 6 6 0 0 0 -.5-.7 9.4 9.4 0 0 0 -.7-.9c-.2-.2-.5-.4-.8-.6a8.8 8.8 0 0 0 -.9-.7L404.4 55.6a8 8 0 0 0 -8 0L300.1 111h0a8.1 8.1 0 0 0 -.9 .7 7.7 7.7 0 0 0 -.8 .6 8.2 8.2 0 0 0 -.7 .9c-.2 .2-.4 .5-.5 .7a9.7 9.7 0 0 0 -.5 1.3c-.1 .2-.2 .4-.3 .7a8.1 8.1 0 0 0 -.3 2.1V223.2l-80.2 46.2V63.4a7.8 7.8 0 0 0 -.3-2.1c-.1-.2-.2-.5-.3-.7a8.4 8.4 0 0 0 -.5-1.2c-.1-.3-.4-.5-.5-.7a9.4 9.4 0 0 0 -.7-.9 9.5 9.5 0 0 0 -.8-.6 9.8 9.8 0 0 0 -.9-.7h0L115.6 1.1a8 8 0 0 0 -8 0L11.3 56.5h0a6.5 6.5 0 0 0 -.9 .7 7.8 7.8 0 0 0 -.8 .6 8.2 8.2 0 0 0 -.7 .9c-.2 .3-.4 .5-.6 .7a7.9 7.9 0 0 0 -.5 1.2 6.5 6.5 0 0 0 -.3 .7 8.2 8.2 0 0 0 -.3 2.1v329.7a8 8 0 0 0 4 7l192.5 110.8a8.8 8.8 0 0 0 1.3 .5c.2 .1 .4 .2 .6 .3a7.9 7.9 0 0 0 4.1 0c.2-.1 .4-.2 .6-.2a8.6 8.6 0 0 0 1.4-.6L404.4 400.1a8 8 0 0 0 4-7V287.9l92.2-53.1a8 8 0 0 0 4-7V117.9A8.6 8.6 0 0 0 504.4 115.8zM111.6 17.3h0l80.2 46.2-80.2 46.2L31.4 63.4zm88.3 60V278.6l-46.5 26.8-33.7 19.4V123.5l46.5-26.8zm0 412.8L23.4 388.5V77.3L57.1 96.7l46.5 26.8V338.7a6.9 6.9 0 0 0 .1 .9 8 8 0 0 0 .2 1.2h0a5.9 5.9 0 0 0 .4 .9 6.4 6.4 0 0 0 .4 1v0a8.5 8.5 0 0 0 .6 .8 7.6 7.6 0 0 0 .7 .8l0 0c.2 .2 .5 .4 .8 .6a8.9 8.9 0 0 0 .9 .7l0 0 0 0 92.2 52.2zm8-106.2-80.1-45.3 84.1-48.4 92.3-53.1 80.1 46.1-58.8 33.6zm184.5 4.6L215.9 490.1V397.8L346.6 323.2l45.8-26.2zm0-119.1L358.7 250l-46.5-26.8V131.8l33.7 19.4L392.4 178zm8-105.3-80.2-46.2 80.2-46.2 80.2 46.2zm8 105.3V178L455 151.2l33.7-19.4v91.4h0z"/></svg>
                </p>
            </div>
    
            <div data-aos="fade-up" data-aos-duration="1000" class="buttons">
                <div class="index-button">
                    <div class="button-wrapper" onclick="window.location.href = '{{ route('games.create') }}'">
                        <div class="text">
                            {{ strtoupper(
                            __("app.game.play")
                            ) }}
                        </div>
                        <span class="game-icon">
                            <i style="font-weight: bold !important;" class="bx bx-joystick"></i> 
                        </span>
                    </div>
                </div>            
            </div>
    </section>
@endsection
