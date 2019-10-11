<?php

/**
 * Knight actions and behavior
 * Test game: 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Knight extends AbstractFigure {
    
    /**
     * Price of Knight
     * @var integer 
     */
    public $price = 2;
    
    
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
    public function getVacuumHorsePossibleMoves(Move $move) : array
    {
        //ini
        $result = [self::NORMAL => []];
       
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♘' : '♞';
    }
   
    /**
     * Check diagonal move blocks
     * @param Move $move Move object
     * @param Desk $desk 
     * @return bool
     */
    public static function checkDiagonalMoveBlock(Move $move, Desk $desk) : bool 
    {
        
        //
        return true;
    }
    
    /**
     * Generate diagonal moves
     * @param Move $move
     * @return array of Move
     */
    public static function generateDiagonalMoves(Move $move){
        //array of moves
        $result = [];
        //
        
        //
        return $result;
    }
   
    
}
