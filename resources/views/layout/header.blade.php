
<nav>
   <div class="flex-between header">
       <div class="title flex">
           <a href="{{ route("index") }}" class="flex">
                <img src="/assets/img/logo.svg" class="m-auto" height="37" width="47">
                <span class="m-auto ml-10">{{ config("app.name") }}</span>
            </a>
       </div>

       <ul class="navbar">            
            @if(session() -> has("id"))

                <li>
                    <a class="link bigger m-auto" href="{{ route("profile.show", session("email")) }}">
                        <i class='bx bx-user-circle' ></i>
                    </a>
               </li>
            @else
                <li>        
                    <a id="header-login-button" class="link" href="{{ route("auth.login") }}">
                        <i class='bx bx-log-in-circle'></i> 
                        <span class="ml-10">Login</span>
                    </a>
                </li>
           @endif

       </ul>
   </div>
</nav>
