@extends('layout.base')

@section("title", "Settings page")


@section("body")
    <section id="settings" style="margin-top: 4rem;">
        
        <div class="banner settings-banner flex-between" data-aos="fade-in" data-aos-duration="1000">
            <div>
                {{ ucfirst(
                    __("app.settings.settings")
                ) }} 

            </div>
            <div>
                <button class="mt-10 center bg-red">
                    {{ strtoupper(
                        __("app.settings.delete")
                    ) }} 
                </button>
            </div>
        </div>

        <div class="pro-cards w-100 mt-10 settings-div" style="margin-top: 30px;" data-aos="fade-up" data-aos-duration="1000">

            <div class="relative more-infos w-100 settings-container">
                <div class="commentbar-top">
                    <h5>
                        {{ mb_strtoupper(
                            __("app.settings.settings")
                        ) }} 
                    </h5>
                    <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">
                </div>
            
                <div id="settings-block" class="content flex column">
                    <div class="flex column h-100">
                        <div>
                            <button class="center glass-button">
                                <span class="blur-round"></span>

                                {{ strtoupper(
                                    __("app.settings.username")
                                ) }} 
                            </button>
                            <br>
                            <button class="mt-10 center  glass-button">
                                <span class="blur-round"></span>
                                {{ strtoupper(
                                    __("app.settings.password")
                                ) }} 
                            </button>
                        </div>
                        <div class="flex column">
                            <h5>
                                {{ strtoupper(
                                    __("app.settings.security")
                                ) }} 
                            </h5>
                            <hr style="background-color: #a14fd6; margin: 0px; height: 5px; margin-bottom: 20px;">

                            <button class="mt-10 center glass-button">
                                <span class="blur-round"></span>
                                @php                                
                                    $tfa_situation = session()->has("secret") 
                                        ? __("validation.attributes.2fa_disable") 
                                        : __("validation.attributes.2fa_enable")
                                @endphp
                                {{ strtoupper($tfa_situation) }} 
                            </button>
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
