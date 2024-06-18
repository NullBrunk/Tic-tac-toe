@extends('layout.base')

@section("title", "Signup")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container auth-form">
        
        <form action="{{ route("auth.register") }}" method="post">
            @csrf
 
            <div class="icon">
                <span><i class='bx bxs-user-plus'></i></span>
            </div>

            {{-- Username input --}}
            @php $label = ucfirst(__("validation.attributes.name")) @endphp
            <x-input type="text" name="name" placeholder="John Doe" class="input-form" :label="$label"></x-input>

            {{-- Email input --}}
            <x-input type="email" name="email" placeholder="john@doe.fr" class="input-form" label="E-mail"></x-input>

            {{-- Password input --}}
            @php $label = ucfirst(__("validation.attributes.password")) @endphp
            <x-input type="password" name="password" placeholder="••••••••" class="input-form" :label="$label"></x-input>

            {{-- Password confirmatopn input --}}
            @php $label = ucfirst(__("validation.attributes.password_confirmation")) @endphp
            <x-input type="password" name="password_confirmation" placeholder="••••••••" class="input-form" :label="$label"></x-input>


            <div>
                <span class="checkbox-wrapper">
                    <label for="2fa_token">
                        {{ ucfirst(
                            __("validation.attributes.2fa_token")
                        ) }}
                    </label>
                    <input class="checkbox" type="checkbox" name="2fa_token" id="2fa_token">
                </span>
            </div>
            <br>

             <span class="account-creation">
                {{ ucfirst(__("app.login_message")) }} 
                <a href="{{ route("auth.login") }}">
                    {{ ucfirst(__("app.login")) }} 
                </a>
            </span>
            <button>
                {{ ucfirst(
                    __("app.register")
                ) }}
            </button>
        </form>
    
    </section>
@endsection
