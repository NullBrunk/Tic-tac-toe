@extends('layout.base')

@section("title", "Login")


@section("body")
    <section id="auth" data-aos="fade-down" data-aos-duration="500" class="container">
        
        <form action="{{ route("auth.login_2fa") }}" method="post" class="otp-Form">
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
        let totp_inputs = [];

        for(let i = 1; i <= 6; i++) {
            // On met tous les inputs dans un tableau
            totp_inputs[i] = document.getElementById(`totp${i}`);

            /* ------- Focus l'input suivant quand on a mis un nombre dans l'input courant ------- */
            totp_inputs[i].addEventListener("input", (e) => {
                // Si il n'est pas de type ajout de texte, on quitte la fonction
                if(e.inputType !== "insertText")
                    return;

                // Si il est de type ajout de texte, on ne prevent pas le comportement par défaut (ajouter du texte dans l'input)

                // On récupère le next input
                let next_input = totp_inputs[i+1];


                // Si il existe on le focus
                next_input && next_input.focus();
            });

            /* ------- Focus l'input précédent quand on efface un nombre dans un input vide ------- */
            totp_inputs[i].addEventListener("keydown", (e) => {

                // Si l'utilisateur presse la touche effacter
                if(e.key === "Backspace") {

                    // Si l'input sur lequel l'utilisateur est est vide
                    if(e.target.value === "") {
                        let new_input = totp_inputs[i-1];

                        // On focus le précédent si il existe
                        if(new_input) {
                            new_input.focus();
                            // et on efface son contenu
                            new_input.value = '';
                        }
                    }
                }
            });
        }
    </script>
@endsection
