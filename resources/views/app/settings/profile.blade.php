@extends('layout.base')

@section("title", "Profile page")


@section("body")

    <section id="settings">
        <div class="banner" data-aos="fade-in" data-aos-duration="1000" ></div>

        <div class="absolute informations flex" data-aos="fade-in" data-aos-duration="1000">
            <div class="profile-name flex">
                <img src="https://ui-avatars.com/api/?background=1e1f30&color=fff&amp;size=300&amp;rounded=true&amp;length=1&amp;name={{ $user->name }}" alt="Profile">
            </div>
            <div class="profile-info">
                <p class="mail">
                    {{ mb_strtoupper($user->name) }}
                </p>
                <p class="joined" id="joined">
                    Created {{ $user->created_at->diffForHumans() }}
                </p>
            </div>    

            @if($user->email === session("email"))
                <div class="pro-buttons flex">
                    <span class="blur-round"></span>
                    <a class="glass-button" style="height: 34px;" href="{{ route("settings.settings") }}"><i class="bx bx-cog"></i></a>
                </div>
            @endif
        </div>

        <div class="pro-cards" data-aos="fade-up" data-aos-duration="1000">

            <div class="relative more-infos">
                <div class="commentbar-top">
                    <h5 class="">
                        <span>
                            {{ ucfirst(
                                __("app.settings.game_history")
                            ) }}
                        </span>
                    </h5>
                    <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">
                </div>

                <div class="scrollable">
                    @forelse($history as $battle)

                        @if($battle["winner"] === "draw")
                            @php($class = "transfer")
                        @elseif((
                                $battle["email_p1"] === $user->email &&
                                $battle["join_p1"] === $battle["winner"]
                            ) || (
                                $battle["email_p2"] === $user->email &&
                                $battle["join_p2"] === $battle["winner"]
                        ))
                            @php($class = "trophy")
                        @else
                            @php($class = "x-circle")
                        @endif

                        <div class="battle {{ $class }} flex-between"  >
                            <div>
                                <i class="bx bx bx-{{ $class }}"></i>
                            </div>

                            <div class="">
                                <a class="profile-link" href="{{ $battle["name_p1"] }}">{{ $battle["name_p1"] }}</a>

                                <span class="fg bolder">
                                    VS
                                </span>

                                <a class="profile-link" href="{{ $battle["name_p2"] }}">{{ $battle["name_p2"] }}</a>

                            </div>

                            <div>
                                @human_diff($battle["created_at"])
                                <i class="bx bx-revision" onclick='window.location.href = "{{ route("games.join", ["game" => $battle["game_id"] ] ) }}"' style="cursor: pointer; margin-left: 20px; color: var(--green)"></i>
                            </div>

                        </div>

                    @empty
                        <br>
                        <div>This user hasn't played any games yet.</div>
                    @endforelse
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


                    <div class="block-container">
                        <div class="btn-back btn-back-1"></div>
                        <div class="btn-front">
                            <span style="color: #0bb9cb">
                                <i class='bx bx-trophy'></i>
                                {{ mb_strtoupper(
                                    __("app.settings.won")
                                    ) }} 
                            </span>
                            <span id="won" class="stats">{{ $won_games }}</span>
                        </div>
                      </div>

                      <div class="block-container">
                        <div class="btn-back btn-back-2"></div>
                        <div class="btn-front">
                            <span style="color: #01beff;">
                                <i class='bx bx-transfer'></i>
                                {{ mb_strtoupper(
                                    __("app.settings.drawn")
                                ) }}
                            </span>
                            <span id="drawn" class="stats">{{ $drawn_games }}</span>
                        </div>
                      </div>

                      <div class="block-container">
                        <div class="btn-back btn-back-3"></div>
                        <div class="btn-front">
                            <span style="color: #e58133;">
                                <i class='bx bx-x-circle'></i>
                                {{ mb_strtoupper(
                                    __("app.settings.lost")
                                ) }}
                            </span>
                            <span id="lost" class="stats">{{ $lost_games }}</span>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </section>
@endsection
