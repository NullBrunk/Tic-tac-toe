<nav>
   <div class="flex-between header">
       <div class="title flex">
           <a href="{{ route("index") }}" class="flex">
                <img src="{{ asset("/assets/img/logo.svg") }}" class="m-auto" height="37" width="47">
                <span class="m-auto ml-10">{{ config("app.name") }}</span>
            </a>
       </div>

       <ul class="navbar">            
            @if(session()->has("id"))
                <li>
                    <div class="profile-button dropdown" id="dropdown">
                        <i class='bx bx-menu'></i>
                        
                        <div id="dropdown-content" class="dropdown-content">
                            <span class="blur-round"></span>
                            <a class="flex" href="{{ route("settings.profile", session("name")) }}">
                                <span class="flex">
                                    <i class='bx bx-user-circle m-auto' ></i>
                                    <span class="ml-10">
                                        {{ ucfirst(
                                            __("app.profile")
                                            ) }}
                                    </span>
                                </span>
                            </a>
                            <a class="flex" href="{{ route("auth.logout") }}">
                                <span class="flex">
                                    <i class='bx bx-log-out-circle m-auto'></i>
                                    <span class="ml-10">
                                        {{ ucfirst(
                                            __("app.logout")
                                        ) }}
                                    </span>
                                </span>
                            </a>
                        </div>
                    
                    </div>
                </li>
            @else
                <li>        
                    <a class="link header-login-button" href="{{ route("auth.login") }}">
                        <i class='bx bx-log-in-circle'></i> 
                        <span class="ml-10">
                            {{ ucfirst(
                                __("app.login")
                            ) }}
                        </span>
                    </a>
                </li>
           @endif

       </ul>
   </div>
</nav>
