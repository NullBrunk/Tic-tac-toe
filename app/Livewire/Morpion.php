<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Models\User_join;
use Illuminate\View\View;
use App\Http\Controllers\GamesController;
use App\Services\MorpionService;

class Morpion extends Component
{
    public int $k = 0;
    public string|int $id;
    public array $morpion;
    public bool $alone = true;
    
    public ?int $position = null;
    public ?string $ended = null;

    public ?string $symbol = null;

    /**
     * Store the symbol when the component is rendered for the first time
     *
     * @return void
     */
    public function mount(): void {
        $this->symbol = \App\Models\User_join::where("game_id", $this->id)->where("user_id", session("id"))->first()->symbol;
    }

    /**
     * Méthode permettant à l'utilisateur de jouer un coup
     * 
     * @param int $position     Position oû placer le pion du joueur
     *                          sur le morpion
     * 
     * @return void
     */
    public function play(int $position): void
    {
        // If the game is ended do not play
        if($this->ended !== null) return;
        
        // Stock the position in an attribute
        $this->position = $position;

        // Play the turn of the player
        GamesController::move(Game::findOrFail($this->id), $this->position);
        
        // Update the morpion
        $this->update_morpion();
    }


    /**
     * Vérifier si l'utilisateur est seul
     * 
     * @return void
     */
    public function is_alone(): void
    {
        
        $joined_players = User_join::where("game_id", $this->id)->count();
        
        if($joined_players !== 1) {
            $this->alone = false;
        }
    }

    /**
     * Update the morpion
     *
     * @return void
     */
    public function update_morpion(): void
    {
        // If the game is ended do not reload anything
        if($this->ended !== null) return;

        // Check if you are alone or not
        if($this->alone === true) $this->is_alone();

        $this->ended = Game::where("id", $this->id)->first()->winner;

        // Get the morpion from the model via the controller
        $this->morpion = MorpionService::get_morpion($this->id);
        
        // Si la variable position n'existe pas, alors le joueur n'a pas encore joué, donc pas besoin de 
        // vérifier si quelqu'un a gagné
        if($this->position !== null)
            // Check if someone has winned
            GamesController::check_win($this->morpion, $this->position, $this->id);
    }


    public function render(): View
    {
        $this->update_morpion();        
        return view('livewire.morpion');
    }

}
