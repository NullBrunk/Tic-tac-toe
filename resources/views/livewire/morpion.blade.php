<div wire:poll.1s="update_morpion">

    <div id="result" class="@if($ended === null) none @endif">
        <span class="@if($ended !== "draw") none @endif" id="draw">
            IT'S A DRAW
        </span>

        <span class="@if($ended === null || $ended === "draw") none @endif" id="winner"> 
            <span id="name">{{ $ended }}</span> WINS !
        </span>
    </div>

    @php($k=0)

    @foreach($morpion as $line)
        <form class="col">
            @foreach($line as $case)
                <input type="button" class="case" value="{{ $case }}" wire:click="play({{ $k++ }})">
            @endforeach
        </form>
    @endforeach
</div>
