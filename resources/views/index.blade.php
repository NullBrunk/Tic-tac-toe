@extends('layout.base')

@section("title", "Index page")


@section("body")
    <section class="container index-page" style="margin-top: 4rem;">
            <h1 class="body-title">
                A<span class="text-gradient"> multiplayer</span> <br> tic-tac-toe 
            </h1>

            <div class="flex buttons">
                <a class="button purple-button" href="{{ env('GITHUB_URL') }}" target="_blank">
                    <i class='bx bxl-github'></i>
                    See on github
                </a>
                
                <a class="button green-button" href="{{ env('PORTFOLIO_URL') }}" target="_blank">
                    <i class='bx bx-bookmark' ></i>
                    Read the doc
                </a>
            </div>            
    </section>
@endsection