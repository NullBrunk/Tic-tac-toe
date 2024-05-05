@extends('layout.base')

@section("title", "Signup")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container auth-form">
        
        <form>
            <div class="icon">
                <span>
                    <i class='bx bxs-user-plus'></i>
                </span>
            </div>

            <p>
                {{ ucfirst(
                    __("validation.attributes.2fa_body")
                ) }}
            </p>
            <img src="{{ $qrcode }}">
            <p>
                {{ ucfirst(
                    __("validation.attributes.2fa_or_secret")
                ) }} {{ $secret }}, 
                {{ 
                    __("validation.attributes.2fa_then_go")
                }}
            </p>
           
        </form>
    
    </section>
@endsection
