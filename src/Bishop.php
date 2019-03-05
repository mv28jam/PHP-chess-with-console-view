<?php

class Bishop extends AbstractFigure {
    
    /**
     * Price of Bishop
     * @var integer 
     */
    public $price = 2;
    
    
    /**
     * Move action and after action for bishop
     * @param Move $move
     * @param Desk $desk
     * @return King
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        return $this;
    }
    
    /**
     * Validate Bishop move
     * @param Move $move Move object
     * @param array $desk map of desk
     * @param Move $last_move 
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    {
        $this->getVacuumHorsePossibleMoves($move); 
        return 0;
    }
    
    /**
     * Create array of all possible moves without other figures for bishop
     * @param Move $move
     * @return array of array of Move
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //

        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() {
        return $this->is_black ? '♗' : '♝';
    }
    
}
