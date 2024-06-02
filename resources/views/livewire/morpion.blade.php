<div>
    @if(!$ended)
        <div wire:poll.1s="update_morpion">
    @else
        <div>
    @endif

        <div id="result" class="@if($ended === null && $alone === false) bg-margin @else bg-goofy @endif">
            @if($ended === "draw")
                <span id="draw">
                     {{ strtoupper(
                            __("app.game.draw")
                        ) }} !
                </span>
            @endif

            @if($ended !== null && $ended !== "draw")
                <span id="winner">
                    @if($ended === $symbol)
                         {{ mb_strtoupper(
                                __("app.game.won")
                            ) }} !
                    @else
                         {{ strtoupper(
                                __("app.game.lost")
                            ) }} !
                    @endif
                </span>
            @endif


            @if($alone)
                <span>
                    {{ strtoupper(
                            __("app.game.waiting")
                        ) }}
                </span>
                <span class="loader"></span>
            @endif
        </div>


        <div>

            @php($k=0)
            @php($styles = [
                "right-bottom", "right-left-bottom", "left-bottom",
                "top-right-bottom", "", "top-left-bottom",
                "top-right", "top-right-left", "top-left",
            ])
            @foreach($morpion as $line)
                <form class="col">
                    @foreach($line as $case)
                        <input
                            type="button"
                            class="case fg-{{$case}} border-all {{ $styles[$k] }}"
                            value="{{ $case }}"
                            wire:click="play({{ $k++ }})"
                        />
                    @endforeach
                </form>
            @endforeach
        </div>

    </div>
</div>
