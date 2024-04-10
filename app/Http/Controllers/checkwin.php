<?php

function check_line(array $morpion, int $x, int $y) {
    $new_x = $x;
    $new_y = $y;

    $points = 0;

    while($new_y > 0 && $morpion[$new_x][$new_y] === $morpion[$new_x][$new_y-1]) {
        $new_y--;
        $points++;
    }

    $new_x = $x;
    $new_y = $y;

    while($new_y < 2 && $morpion[$new_x][$new_y] === $morpion[$new_x][$new_y+1]) {
        $new_y++;
        $points++;
    }

    if($points === 2) return true;
}

function check_col(array $morpion, int $x, int $y){
    $new_x = $x;
    $new_y = $y;

    $points = 0;

    while($new_x > 0 && $morpion[$new_x-1][$new_y] === $morpion[$new_x][$new_y]) {
        $new_x--;
        $points++;
    }

    $new_x = $x;
    $new_y = $y;

    while($new_x < 2 && $morpion[$new_x][$new_y] === $morpion[$new_x+1][$new_y]) {
        $new_x++;
        $points++;
    }

    if($points === 2) return true;
}

function check_diagonale_gd(array $morpion, int $x, int $y){
    $new_x = $x;
    $new_y = $y;

    $points = 0;

    while($new_x > 0 && $new_y > 0 && $morpion[$new_x-1][$new_y-1] === $morpion[$new_x][$new_y]) {
        $new_x--;
        $new_y--;
        $points++;
    }

    $new_x = $x;
    $new_y = $y;

    while($new_x < 2 && $new_y < 2 && $morpion[$new_x+1][$new_y+1] === $morpion[$new_x][$new_y]) {
        $new_x++;
        $new_y++;
        $points++;
    }

    if($points === 2) return true;
}


function check_diagonale_dg(array $morpion, int $x, int $y){
    $new_x = $x;
    $new_y = $y;
    
    $points = 0;

    while($new_x > 0 && $new_y < 2 && $morpion[$new_x-1][$new_y+1] === $morpion[$new_x][$new_y]) {
        $new_x--;
        $new_y++;
        $points++;
    }
    
    $new_x = $x;
    $new_y = $y;
    
    while($new_x < 2 && $new_y > 0 && $morpion[$new_x+1][$new_y-1] === $morpion[$new_x][$new_y]) {
        $new_x++;
        $new_y--;
        $points++;
    }
    
    if($points === 2) return true;
}
