@extends('layout.base')

@section("title", "Service Unavailable")


@section("body")
    <section id="index" class="container index-page" style="margin-top: 0rem;">
        {{-- <div data-aos="zoom-in" data-aos-duration="1000" class="game main-img up-down">
            
        </div> --}}

            <div class="m-auto errors-page">
                <div class="error-code">
                    503
                </div>
                <div>
                    Woops! Something went wrong ...
                </div>
            </div>
    </section>
@endsection
