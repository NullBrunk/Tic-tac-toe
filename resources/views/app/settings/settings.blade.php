@extends('layout.base')

@section("title", "Settings page")


@section("body")
    <section id="settings" style="margin-top: 4rem;">
        
        <div class="banner settings-banner" data-aos="fade-in" data-aos-duration="1000">
            {{ ucfirst(
                __("app.settings.settings")
            ) }} 
        </div>
        
        <div class="pro-cards w-100 mt-10" style="margin-top: 30px;" data-aos="fade-up" data-aos-duration="1000">

            <div class="relative more-infos w-100 settings-container">
                <div class="commentbar-top">
                    <h5>
                        {{ mb_strtoupper(
                            __("app.settings.settings")
                        ) }} 
                    </h5>
                    <hr style="background-color: #a14fd6; margin: 0px; height: 5px;">
                </div>
            
                <div class="content flex column">
                    <div class="flex column h-100">
                        <div>
                            <button class="center glass-button">
                                {{ strtoupper(
                                    __("app.settings.username")
                                ) }} 
                            </button>
                            <br>
                            <button class="mt-10 center  glass-button">
                                {{ strtoupper(
                                    __("app.settings.password")
                                ) }} 
                            </button>
                        </div>

                        <div class="mt-auto">
                            <h5>
                                {{ strtoupper(
                                    __("app.settings.deletion")
                                ) }} 
                            </h5>
                            <hr style="background-color: #a14fd6; margin: 0px; height: 5px; margin-bottom: 20px;">
                            <button class="mt-10 center bg-red">
                                {{ strtoupper(
                                    __("app.settings.delete")
                                ) }} 
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
