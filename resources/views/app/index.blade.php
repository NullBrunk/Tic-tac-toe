@extends('layout.base')

@section("title", "Index page")


@section("body")

    <section id="index" class="container index-page" style="margin-top: 0rem;">
        <div data-aos="zoom-in" data-aos-duration="1000" class="game main-img up-down">
            
        </div>

        <div data-aos="fade-up" data-aos-duration="1000" class="flex buttons m-auto" style="margin-top: 50px;">
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
