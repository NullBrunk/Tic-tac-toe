@extends('layout.base')

@section("title", "Index page")


@section("body")
    <section class="container game">
        Launch a game !
        <button class="m-auto play-button" onclick="redirect('{{ route('app.generate') }}')">
            <i class="bx bx-play-circle"></i>
        </button>
    </section>
@endsection