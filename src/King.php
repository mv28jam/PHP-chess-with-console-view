<?php

class King extends AbstractFigure {
    public function __toString() 
    {
        return $this->is_black ? '♔' : '♚';
    }
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) :int
    {
        return 1;
    }
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        return $this;
    }
}
