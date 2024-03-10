@extends('layout.base')

@section("title", "Login")


@section("body")
    <section class="container auth-form">
        
        <form action="{{ route("auth.login") }}" method="post">
            @csrf
 
            <div class="icon">
                <span>
                    <i class='bx bxs-user-detail'></i>
                </span>
            </div>

            @error("loginerror")
                {{ $message }}
            @enderror

            @if(session() -> has("success"))
                <div class="success">
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
            
            <button>Login</button>
        </form>
    
    </section>
@endsection