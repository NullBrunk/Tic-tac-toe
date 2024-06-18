@extends('layout.base')

@section("title", "Login")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container">
        
        <form action="{{ route("auth.login") }}" method="post">
            @csrf
 
            <div class="icon">
                <span><i class='bx bxs-user-detail'></i></span>
            </div>

            @error("loginerror")
                <div class="bg-red msg-box">
                    {{ $message }}
                </div> 
            @enderror

            @if(session()->has("success"))
                <div class="bg-green msg-box">
                    {{ session("success") }}
                </div>    
            @endif

            {{-- Email input --}}
            <x-input type="email" name="email" placeholder="john@doe.fr" class="input-form" label="E-mail"></x-input>

            {{-- Password input --}}
            @php $label = ucfirst(__("validation.attributes.password")) @endphp
            <x-input type="password" name="password" placeholder="••••••••" class="input-form" :label="$label"></x-input>

            
            <span class="account-creation">
                {{ ucfirst(__("app.register_message")) }} 
                <a href="{{ route("auth.register") }}">
                    {{ ucfirst(__("app.register")) }} 
                </a>
            </span>
            <button>
                {{ ucfirst(
                    __("app.login")
                ) }}
            </button>
        </form>
    
    </section>
@endsection
