@extends('layout.base')

@section("title", "Profile page")


@section("body")
    <section class="profile-container" style="margin-top: 4rem;">
        <div class="banner"></div>
        
        <div class="absolute informations flex">
            <div class="profile-name flex">
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
                <div class="pro-buttons flex">
                    <a class="button" href="{{ route("profile.settings") }}"><i class="bx bx-cog"></i></a>
                    <a class="button" href="{{ route("auth.logout") }}"><i class='bx bx-log-out-circle'></i></a>
                </div>
            @endif
        </div>

        <div class="pro-cards">

            <div class="relative more-infos">
                <div class="commentbar-top">
                    <h5 class="patch-approximatif">Game history</h5>
                    <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">
                </div>
                
                <div>
                    @foreach($history as $battle)
                        
                    @if($battle["winner"] === "draw")                    
                            @php($class = "transfer")
                        @elseif((
                            $battle["email_p1"] === $email && 
                            $battle["join_p1"] === $battle["winner"]
                        ) || (
                            $battle["email_p2"] === $email && 
                            $battle["join_p2"] === $battle["winner"]
                        ))
                            @php($class = "trophy")
                        @else
                            @php($class = "x-circle")
                        @endif

                        <div class="battle {{ $class }}">
                            <div>
                                <i class="bx bx bx-{{ $class }}"></i>
                            </div>

                            <div style="margin-left: 35%;">
                                <a class="profile-link" href="{{ $battle["email_p1"] }}">{{ $battle["email_p1"] }}</a>
    
                                <span class="fg bolder">
                                    VS
                                </span>

                                <a class="profile-link" href="{{ $battle["email_p2"] }}">{{ $battle["email_p2"] }}</a>
                            </div>

                            <div style="margin-left: auto;">
                                {{ \Carbon\Carbon::parse($battle["created_at"]) -> diffForHumans() }}
                            </div>

                        </div>

                    @endforeach
                </div>
            </div>

            <div class="more-infos" style="overflow: hidden;">
                <h5>General informations</h5>
                <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">

                <div class="flex info">
                    <div class="card trophy">
                        <span>
                            <i class='bx bx-trophy'></i>
                            WON
                        </span>
                        <span class="stats">
                            {{ $won_games }}
                        </span>
                    </div>
                    <div class="card x-circle">
                        <span>
                            <i class='bx bx-x-circle'></i>
                            LOST
                        </span>
                        <span class="stats">
                            {{ $lost_games }}
                        </span>
                    </div>
                    <div class="card transfer">
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