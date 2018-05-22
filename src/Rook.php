<?php

class Rook extends AbstractFigure {
    
    public $price = 2;
    
    /**
     * Validate Rook move
     * @param Move $move move object
     * @param array $desk map of desk
     * @param Move $last_move last move of any figure
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    {
        return true;
    }
    
    /**
     * Get list of possible moves from position start
     * @param array $start - start position
     * @return array of arrays of Move with keys 
     *  ['normal'] => ordinary moves 
     *  ['attack'] => attack figure moves
     *  ['special'] => special figure moves
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
       
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     * @return string
     */
    public function __toString() 
    {
        return $this->is_black ? '♖' : '♜';
    }
   
}
