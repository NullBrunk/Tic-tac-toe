@extends('layout.base')

@section("title", "Login")


@section("body")
    <section data-aos="zoom-in" data-aos-duration="1000" class="container auth-form">
        
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
                @error("email") <div class="error">{{ $message }}</div> @enderror 
                <label for="email">E-mail: </label> <br>
                <input type="email" name="email" id="email" value="{{ old("email") }}" placeholder="john@doe.fr" class="@error("email" || "loginerror" ) error-border @enderror input-form">
            </div>
            
            <div>
                @error("password") <div class="error">{{ $message }}</div> @enderror 
                <label for="password">Password: </label> <br>
                <input type="password" name="password" id="password" placeholder="••••••••" class="@error("password" || "loginerror") error-border @enderror input-form">
            </div>
            
            <span class="account-creation">
                Don't have an account yet ? <a href="{{ route("auth.signup") }}">Signup</a>
            </span>
            <button>Login</button>
        </form>
    
    </section>
@endsection