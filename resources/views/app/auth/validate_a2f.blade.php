@extends('layout.base')

@section("title", "Login")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container">
        
        <form action="{{ route("auth.validate_a2f") }}" method="post" class="otp-Form">
            @csrf
 
            <div class="icon">
                <span>
                    <i class='bx bx-dialpad-alt'></i>
                </span>
            </div>

            <label for="name">
                    {{ ucfirst(
                        __("validation.attributes.totp_code")
                        ) }}:
            </label> 
            
            <div class="inputContainer">
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp1" id="totp1">
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp2" id="totp2">
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp3" id="totp3">
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp4" id="totp4"> 
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp5" id="totp5"> 
                <input required="required" maxlength="1" type="text" class="otp-input @if($errors->has("2fa_code")) error-border-red @endif" name="totp6" id="totp6"> 
            </div>              
            
            <br>
            @error("2fa_code")
                <div class="error">
                    {{ $message }}
                </div>
            @enderror
            

            <button>
                {{ ucfirst(
                    __("app.verify")
                ) }}
            </button>
        </form>
    
    </section>

    <script>

        // Ce bout de code permet d'automatiquement focus l'input suivant une fois qu'on en a rempli un
        let totp_inputs = [];

        for(let i = 1; i <= 6; i++) {
            // On met tous les inputs dans un tableau
            totp_inputs[i] = document.getElementById(`totp${i}`);

            // On écoute l'événement input
            totp_inputs[i].addEventListener("input", (e) => {
                // Si il est de type ajout de texte
                if(e.inputType === "insertText") {
                    // On récupère le next input
                    let next_input = totp_inputs[i+1];

                    // Si il existe
                    if(next_input) {
                        // On le focus
                        next_input.focus();
                    }
                } 
            });
        }
    </script>
@endsection
