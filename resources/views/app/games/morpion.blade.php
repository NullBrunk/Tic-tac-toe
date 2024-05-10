@extends('layout.base')

@section("title", "Index page")

@section("body")
    @livewireStyles
    @livewireScripts

    <section class="container" data-aos="zoom-in-up" data-aos-duration="1000">

        <section id="morpion" onclick="clicked(event)">
            <livewire:morpion :id="$game_id" />
        </section>
        
    </section>

@endsection