@extends('layout.base')

@section("title", "Signup")


@section("body")
    <section id="auth" data-aos="zoom-in" data-aos-duration="1000" class="container auth-form">
        
        <form action="{{ route("auth.register") }}" method="post">
            @csrf
 
            <div class="icon">
                <span>
                    <i class='bx bxs-user-plus'></i>
                </span>
            </div>

            <div>
                @error("name") <div class="error">{{ $message }}</div> @enderror 
                <label for="name">
                    {{ ucfirst(
                        __("validation.attributes.name")
                    ) }}:
                </label> <br>
                <input type="text" name="name" id="name" value="{{ old("name") }}" placeholder="John Doe" class="@error("name") error-border @enderror input-form">
            </div>
            
            <div>
                @error("email") <div class="error">{{ $message }}</div> @enderror 
                <label for="email">E-mail: </label> <br>
                <input type="email" name="email" id="email" value="{{ old("email") }}" placeholder="john@doe.fr" class="@error("email") error-border @enderror input-form">
            </div>
            
            <div>
                @error("password") <div class="error">{{ $message }}</div> @enderror 
                <label for="password">
                    {{ ucfirst(
                        __("validation.attributes.password")
                    ) }}:
                </label> <br>
                <input type="password" name="password" id="password" placeholder="••••••••" class="@error("password") error-border @enderror input-form">
            </div>
            
            <div>
                @error("password_confirmation") <div class="error">{{ $message }}</div> @enderror 
                <label for="password_confirmation">
                    {{ ucfirst(
                        __("validation.attributes.password_confirmation")
                    ) }}:
                </label> <br>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="@error("password_confirmation") error-border @enderror input-form">
            </div>

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
