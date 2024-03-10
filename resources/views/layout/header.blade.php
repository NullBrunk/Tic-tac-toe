
<nav>
   <div class="flex-between header">
       <div class="title">
           <img src="/assets/img/logo.svg" class="m-auto" height="37" width="47">
           <a class="link" href="{{ route("index") }}">{{ config("app.name") }}</a>
       </div>

       <ul class="navbar">
           
           <li>
               <a id="header-play-button" class="link" href="{{ route("app.app") }}">
                   {{-- <i class='bx bx-play'></i>  --}}
                   Play
               </a>
           </li>

           @if(session() -> has("id"))
            <li>        
                  <a id="header-login-button" class="link" href="{{ route("auth.logout") }}">
                     {{-- <i class='bx bx-log-in-circle'></i> --}}
                     Logout
                  </a>
               </li>
            @else
           <li>        
               <a id="header-login-button" class="link" href="{{ route("auth.login") }}">
                   {{-- <i class='bx bx-log-in-circle'></i> --}}
                   Login
               </a>
           </li>
           <li>        
               <a id="header-signup-button" class="link" href="{{ route("auth.signup") }}">
                   {{-- <i class='bx bx-log-out-circle'></i> --}}
                   Signup
               </a>
           </li>
           @endif

           <li>
               <a class="link bigger m-auto" href="">
                   <i class='bx bxs-sun'></i>
                   <i class='bx bxs-moon none' ></i>
               </a>
           </li>
       </ul>
   </div>
</nav>
