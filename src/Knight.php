<?php

class Knight extends AbstractFigure {
    
    /**
     * Price of Knight
     * @var integer 
     */
    public $price = 2;
    
    
    /**
     * Move action and after action for knight
     * @param Move $move
     * @param Desk $desk
     * @return King
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        return $this;
    }
    
    /**
     * Validate Knight move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        return 0;
    }
    
    /**
     * Create array of all possible moves without other figures for knight
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
        return $this->is_black ? '♘' : '♞';
    }
    
}
