@extends('layout.base')

@section("title", "Profile page")


@section("body")
    <section class="profile-container" style="margin-top: 4rem;">
        <div class="banner"></div>
        
        <div class="absolute informations title ">
            <div class="profile-name title ">
                <img src="https://ui-avatars.com/api/?background=a14fd6&color=fff&amp;size=300&amp;rounded=true&amp;length=1&amp;name={{ $email }}" alt="Profile picture">
            </div>
            <div class="profile-info">
                <p class="mail">
                    {{ strtoupper($email) }}
                </p>
                <p class="joined" id="joined">
                    {{ $created_at }}
                </p>
            </div>    

            @if($email === session("email"))
                <div class="pro-buttons">
                    <a class="button" href="http://127.0.0.1/settings"><i class="bx bx-cog"></i></a>
                </div>
            @endif
        </div>

        <div class="pro-cards">

            <div class="relative more-infos">
                <div class="commentbar-top">
                    <h5>Game history</h5>
                    <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">
                </div>
                
                <div>
                    @dump($history)
                    @foreach($history as $battle)
                        <p class="battle">
                            @dump(sizeof($history))
                            @dump($battle)
                        </p>
                    @endforeach
                </div>
            </div>

            <div class="more-infos">
                <h5>General informations</h5>
                <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">

                <div class="flex info">
                    <div class="card">
                        <span>
                            <i class='bx bx-joystick'></i>
                            PLAYED
                        </span>
                        <span class="stats">
                            {{ $played_games }}
                        </span>
                    </div>
                    <div class="card">
                        <span>
                            <i class='bx bx-trophy'></i>
                            WON
                        </span>
                        <span class="stats">
                            {{ $won_games }}
                        </span>
                    </div>
                    <div class="card">
                        <span>
                            <i class='bx bx-x-circle'></i>
                            LOST
                        </span>
                        <span class="stats">
                            {{ $lost_games }}
                        </span>
                    </div>
                    <div class="card">
                        <span>
                            <i class='bx bx-transfer'></i>
                            DRAWN
                        </span>
                        <span class="stats">
                            {{ $drawn_games }}
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection