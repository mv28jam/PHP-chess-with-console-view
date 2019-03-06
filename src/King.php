<?php

class King extends AbstractFigure {
    
    /**
     * Price of King
     * @var integer 
     */
    public $price = PHP_INT_MAX;
    
    
    /**
     * Move action and after action for king
     * @param Move $move
     * @param Desk $desk
     * @return King
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        return $this;
    }
    
    /**
     * Validate King move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        return 0;
    }
    
    /**
     * Create array of all possible moves without other figures for king
     * @param Move $move
     * @return array of array of Move
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
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
        return $this->is_black ? '♔' : '♚';
    }
    
}
