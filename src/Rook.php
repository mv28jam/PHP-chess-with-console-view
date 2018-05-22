<?php

class Rook extends AbstractFigure {
    
    /**
     * Price of Rook
     * @var integer 
     */
    public $price = 2;
    
    /**
     * Validate Rook move
     * @param Move $move Move object
     * @param array $desk map of desk
     * @param Move $last_move not used for Rook
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    {
        return true;
    }
    
    /**
     * Get list of possible moves from position start
     * @param array $start - start position
     * @return array of arrays of Move with keys 
     *  ['normal'] => moves 
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = [self::NORMAL => []];
       
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() 
    {
        return $this->is_black ? '♖' : '♜';
    }
   
}
