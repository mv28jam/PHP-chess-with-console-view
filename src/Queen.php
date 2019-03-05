<?php

class Queen extends AbstractFigure {
    
    /**
     * Price of Queen
     * @var integer 
     */
    public $price = 3;
    
    
    /**
     * Move action and after action for queen
     * @param Move $move
     * @param Desk $desk
     * @return Queen
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        return $this;
    }
    
    /**
     * Validate Queen move
     * @param Move $move Move object
     * @param array $desk map of desk
     * @param Move $last_move not used!
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    {
        return 0;
    }
    
    /**
     * Create array of all possible moves without other figures for queen
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
        return $this->is_black ? '♕' : '♛';
    }

    
}
