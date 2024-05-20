@extends('layout.base')

@section("title", "Not found")


@section("body")
    <section id="index" class="container index-page" style="margin-top: 0rem;">
        {{-- <div data-aos="zoom-in" data-aos-duration="1000" class="game main-img up-down">
            
        </div> --}}

            <div class="m-auto errors-page">
                <div class="error-code">
                    404
                </div>
                <div>
                    It looks like you're lost...
                </div>
            </div>
    </section>
@endsection
