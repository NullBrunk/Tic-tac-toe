@extends('layout.base')

@section("title", "Forbidden")


@section("body")
    <section id="index" class="container index-page" style="margin-top: 0rem;">
        {{-- <div data-aos="zoom-in" data-aos-duration="1000" class="game main-img up-down">
            
        </div> --}}

            <div class="m-auto errors-page">
                <div class="error-code">
                    403
                </div>
                <div>
                    You don't have permission to access this area !
                </div>
            </div>
    </section>
@endsection
