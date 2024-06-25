<?php
declare(strict_types=1);

namespace App\Services;

class MorpionLogicService {
    
    /**
     * Responsible for doing the logic
     *
     * @param array $morpion
     * @param integer $x
     * @param integer $y
     */
    public function __construct(public array $morpion, public int $x, public int $y) {}
    
    /**
     * Test si il y a 3 pions alignés en ligne sur la par rapport au pion de coordonées x,y
     *
     * @return boolean
     */
    public function check_line(): bool {
        $new_x = $this->x;
        $new_y = $this->y;

        $points = 0;

        while($new_y > 0 && $this->morpion[$new_x][$new_y] === $this->morpion[$new_x][$new_y-1]) {
            $new_y--;
            $points++;
        }

        $new_y = $this->y;

        while($new_y < 2 && $this->morpion[$new_x][$new_y] === $this->morpion[$new_x][$new_y+1]) {
            $new_y++;
            $points++;
        }

        return $points === 2;
    }


    /**
     * Test si il y a trois pions alignés en colonne par rapport au pion de coordonées x,y
     *
     * @return boolean
     */
    public function check_col(): bool {
        $new_x = $this->x;
        $new_y = $this->y;
        
        $points = 0;

        while($new_x > 0 && $this->morpion[$new_x-1][$new_y] === $this->morpion[$new_x][$new_y]) {
            $new_x--;
            $points++;
        }

        $new_x = $this->x;

        while($new_x < 2 && $this->morpion[$new_x+1][$new_y] === $this->morpion[$new_x][$new_y]) {
            $new_x++;
            $points++;
        }

        return $points === 2;
    }


    /**
     * Check si il y a trois pions alignés en diagonale (gauche droite) par rapport au pion de coordonées
     * x,y
     *
     * @return boolean
     */
    public function check_diagonale_gd(): bool {
        $new_x = $this->x;
        $new_y = $this->y;

        $points = 0;

        while($new_x > 0 && $new_y > 0 && $this->morpion[$new_x-1][$new_y-1] === $this->morpion[$new_x][$new_y]) {
            $new_x--;
            $new_y--;
            $points++;
        }

        $new_x = $this->x;
        $new_y = $this->y;

        while($new_x < 2 && $new_y < 2 && $this->morpion[$new_x+1][$new_y+1] === $this->morpion[$new_x][$new_y]) {
            $new_x++;
            $new_y++;
            $points++;
        }

        return $points === 2;
    }


    /**
     * Check si il y a 3 pions alignés en diagonale (droite gauche) par rapport au pion de coordonées x,y
     *
     * @return boolean
     */
    public function check_diagonale_dg(): bool {
        $new_x = $this->x;
        $new_y = $this->y;
        
        $points = 0;

        while($new_x > 0 && $new_y < 2 && $this->morpion[$new_x-1][$new_y+1] === $this->morpion[$new_x][$new_y]) {
            $new_x--;
            $new_y++;
            $points++;
        }
        
        $new_x = $this->x;
        $new_y = $this->y;
        
        while($new_x < 2 && $new_y > 0 && $this->morpion[$new_x+1][$new_y-1] === $this->morpion[$new_x][$new_y]) {
            $new_x++;
            $new_y--;
            $points++;
        }
        
        return $points === 2;
    }
}
