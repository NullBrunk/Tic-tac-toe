@extends('layout.base')

@section("title", "Index page")


@section("body")

    <section id="index" class="container index-page" style="margin-top: 0;">
            <div class="index-title transparent" data-aos="fade-down" data-aos-duration="1000">
                <div class="card">
                    <span class="number"><i class='bx bx-joystick' style="color: #01beff"></i> {{ $games }}</span>
                    <span>Played games</span>
                </div>
                <div class="card">
                    <span class="number"><i class='bx bx-trophy' style="color: #0bb9cb;"></i> {{ $users }}</span>
                    <span>Active users</span>
                </div>
                <div class="card">
                    <span class="number"><i class='bx bx-play-circle' style="color: #07deaf;"></i> {{ $today_games }}</span>
                    <span>Played games today</span>
                </div>
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
