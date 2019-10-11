<?php

/**
 * Knight actions and behavior
 * Test game: e2-e4|e7-e6 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Bishop extends AbstractFigure {
    
    /**
     * Price of Bishop
     * @var integer 
     */
    public $price = 2;
    
    
     /**
     * Validate Bishop move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        
        return Move::FORBIDDEN;
    }
    
    /**
     * Create array of all possible moves without other figures for bishop
     * @param Move $move
     * @return array of array of Move
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) : array
    {
        //ini
        $result = self::generateDiagonalMoves($move);
        
        //var_dump($result);
        //die;
       
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♗' : '♝';
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
        for($i=1; $i<=8; $i++){
      
            
        }
        //
        return $result;
    }
   
    
}
