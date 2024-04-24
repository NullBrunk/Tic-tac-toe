@extends('layout.base')

@section("title", "Profile page")


@section("body")

    <section id="settings">
        <div class="banner" data-aos="fade-in" data-aos-duration="1000" ></div>
        
        <div class="absolute informations flex" data-aos="fade-in" data-aos-duration="1000">
            <div class="profile-name flex">
                <img src="https://ui-avatars.com/api/?background=a14fd6&color=fff&amp;size=300&amp;rounded=true&amp;length=1&amp;name={{ $name }}" alt="Profile picture">
            </div>
            <div class="profile-info">
                <p class="mail">
                    {{ mb_strtoupper($name) }}
                </p>
                <p class="joined" id="joined">
                    {{ $created_at }}
                </p>
            </div>    

            @if($email === session("email"))
                <div class="pro-buttons flex">
                    <a class="button" href="{{ route("settings.profile") }}"><i class="bx bx-cog"></i></a>
                </div>
            @endif
        </div>

        <div class="pro-cards" data-aos="fade-up" data-aos-duration="1000">

            <div class="relative more-infos">
                <div class="commentbar-top">
                    <h5 class="patch-approximatif">
                        {{ ucfirst(
                            __("app.settings.game_history")
                        ) }} 
                    </h5>
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
                                <a class="profile-link" href="{{ $battle["name_p1"] }}">{{ $battle["name_p1"] }}</a>
    
                                <span class="fg bolder">
                                    VS
                                </span>

                                <a class="profile-link" href="{{ $battle["name_p2"] }}">{{ $battle["name_p2"] }}</a>
                            </div>

                            <div style="margin-left: auto;">
                                {{ \Carbon\Carbon::parse($battle["created_at"]) -> diffForHumans() }}
                            </div>

                        </div>

                    @endforeach
                </div>
            </div>

            <div class="more-infos" style="overflow: hidden;">
                <h5>
                    {{ ucfirst(
                        __("app.settings.general_info")
                    ) }} 
                </h5>
                <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">

                <div class="flex info">
                    <div class="card trophy">
                        <span>
                            <i class='bx bx-trophy'></i>
                            {{ mb_strtoupper(
                                __("app.settings.won")
                            ) }} 
                        </span>
                        <span id="won" data-stat="{{ $won_games }}" class="stats">
                    </div>
                    <div class="card x-circle">
                        <span>
                            <i class='bx bx-x-circle'></i>
                            {{ mb_strtoupper(
                                __("app.settings.lost")
                            ) }}
                        </span>
                        <span id="lost" data-stat="{{ $lost_games }}" class="stats">

                    </div>
                    <div class="card transfer">
                        <span>
                            <i class='bx bx-transfer'></i>
                            {{ mb_strtoupper(
                                __("app.settings.drawn")
                            ) }}
                        </span>
                        <span id="drawn" data-stat="{{ $drawn_games }}" class="stats">
                            
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <script src="{{ asset("/assets/specific_js/profile.min.js") }}"></script>
@endsection
