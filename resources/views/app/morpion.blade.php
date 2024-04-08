@extends('layout.base')

@section("title", "Index page")

@section("body")

    @php($k = 0)
    <section class="container">

        <div id="result" class="@if(!$isended) none @endif">
            <i class='bx bxs-check-circle'></i>
            <span class="@if($winner !== "draw") none @endif" id="draw">
                Draw
            </span>

            <span class="@if(!in_array($winner, ["O", "X"])) none @endif" id="winner"> 
                <span id="name">{{ $winner }}</span> wins !
            </span>
        </div>

        <section id="morpion" onclick="clicked(event)">
            @foreach($morpion as $line)
                <div class="col">
                    @foreach($line as $case)
                        <p id="{{ $k++ }}" class="case">{{ $case }}</p>
                    @endforeach
                </div>
            @endforeach
        </section>
        
    </section>

    @if($alone)
    <section class="container">
        <span id="share">
            Share this link with your friends :
            <a href="{{ url() -> current() }}">{{ url() -> current() }}</a> !
        </span>
    </section>
    @endif

    <script>
        function clicked(event) {
            
            let clicked = event.target;
            let result = document.getElementById("result");
            if(clicked.tagName === "P") {
                fetch("/move/{{ $gameid }}/" + clicked.id).then((req) => {
                    if(req.status === 200) {
                        clicked.innerHTML = "{{ session('symbol') }}"
                        req.json().then((data) => {
                            if(data.end === 0) {
                                result.classList.remove("none");
                                document.getElementById("draw").classList.remove("none");
                            } else if(data.end === 1) {
                                result.classList.remove("none");
                                document.getElementById("winner").classList.remove("none");
                                document.getElementById("name").innerHTML = data.winner;
                            }
                        });
                    } 
                });
            }

        }
    </script>
@endsection