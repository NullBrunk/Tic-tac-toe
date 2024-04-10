@extends('layout.base')

@section("title", "Index page")

@section("body")
    @livewireStyles
    @livewireScripts

    <section class="container">

        <section id="morpion" onclick="clicked(event)">
            @livewire('morpion', [ "id" => $gameid ])
        </section>
        
    </section>

@endsection