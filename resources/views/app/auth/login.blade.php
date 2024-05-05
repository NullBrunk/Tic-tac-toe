@extends('layout.base')

@section("title", "Login")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container">
        
        <form action="{{ route("auth.login") }}" method="post">
            @csrf
 
            <div class="icon">
                <span>
                    <i class='bx bxs-user-detail'></i>
                </span>
            </div>
            @error("loginerror")
                <div class="bg-red msg-box">
                    {{ $message }}
                </div> 
            @enderror

            @if(session() -> has("success"))
                <div class="bg-green msg-box">
                    {{ session("success") }}
                </div>    
            @endif

            <div>
                <label for="email">E-mail: </label> <br>
                <input type="email" name="email" id="email" placeholder="john@doe.fr" class="@if($errors -> has("email") || $errors -> has("loginerror")) error-border @endif input-form">
                @error("email") <div class="error">{{ $message }}</div> @enderror 
            </div>
            
            <div>
                <label for="password">
                    {{ ucfirst(
                        __("validation.attributes.password")
                    ) }}: 
                </label> 
                <br>
                <input type="password" name="password" id="password" placeholder="••••••••" class="@if($errors -> has("password") || $errors -> has("loginerror")) error-border @endif input-form">
                @error("password") <div class="error">{{ $message }}</div> @enderror 
            </div>

            <div>
                <label for="2fa_code">
                    {{ ucfirst(
                        __("validation.attributes.2fa")
                    ) }}:
                </label> 
                <br>
                <span class="fa-explanation">
                    {{ ucfirst(
                        __("validation.attributes.2fa_explanation")
                    ) }} 
                </span>
                <br>
                <input type="text" name="2fa_code" id="2fa_code" placeholder="XXXXXX" class="@if($errors -> has("2fa_code") || $errors -> has("loginerror")) error-border @endif input-form">
                @error("2fa_code") <div class="error">{{ $message }}</div> @enderror 
            </div>
            
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
