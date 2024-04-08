@extends('layout.base')

@section("title", "Index page")

@section("body")

    @php($k=0)
    <section class="container">

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

            if(clicked.tagName === "P") {
                fetch("/move/{{ $gameid }}/" + clicked.id).then((status) => {
                    if(status.status === 200) {
                        clicked.innerHTML = "{{ session('symbol') }}"
                    } 
                });
            }

        }
    </script>
@endsection