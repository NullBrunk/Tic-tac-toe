<div wire:poll.1s="update_morpion">

    <div id="result" class="@if($ended === null && $alone === false) none @else bg-green @endif">
        
        @if($ended === "draw")
            <span id="draw">
                IT'S A DRAW
            </span>
        @endif

        @if($ended !== null && $ended !== "draw")
            <span id="winner">
                @if($ended === session("symbol")) 
                    <span id="name">YOU</span> WON !
                @elseif($ended !== session("symbol"))
                    <span id="name">YOU</span> LOST !
                @endif
            </span>
        @endif

    
        @if($alone)
            <span>WAITING FOR YOUR OPPONENT</span>
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
