<?php

/**
 * Knight actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4 
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
        //
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo){
                if(self::checkDiagonalMoveBlock($move, $desc)){
                    return $desk->getFigurePrice($move->to);
                }
                return Move::FORBIDDEN;
            }
        }
        //
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
        return self::generateDiagonalMoves($move);
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
        //one step move
        if(abs($move->dY) == 1){
            return true;
        }
        //@todo check
        //delta of move
        switch(true){
            //down left
            case($move->dY > 0 and $move->dX > 0):
                
                break;
            //down right
            case($move->dY > 0 and $move->dX < 0):
                
                break;
            //up right
            case($move->dX > 0):
                
                break;
            //up left
            case($move->dX < 0):
                
                break;
        }  
        //
        return true;
    }
    
    /**
     * Generate diagonal moves
     * @param Move $move
     * @return array of Move
     */
    public static function generateDiagonalMoves(Move $move){
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //
        for($i=1; $i<=8; $i++){
            $step = ($i - $move->getXLikeY($move->xFrom));
            if($step != 0){
                if($move->checkX($move->prevX($step)) and $move->checkY($move->yFrom + $step)){
                    $result[self::NORMAL][] = new Move($move->strFrom, $move->prevX($step).($move->yFrom + $step));
                }
                if($move->checkX($move->nextX($step)) and $move->checkY($move->yFrom + $step)){
                    $result[self::NORMAL][] = new Move($move->strFrom, $move->nextX($step).($move->yFrom + $step));
                }
                if($move->checkX($move->prevX($step)) and $move->checkY($move->yFrom - $step)){
                    $result[self::NORMAL][] = new Move($move->strFrom, $move->prevX($step).($move->yFrom - $step));
                }
                if($move->checkX($move->nextX($step)) and $move->checkY($move->yFrom - $step)){
                    $result[self::NORMAL][] = new Move($move->strFrom, $move->nextX($step).($move->yFrom - $step));
                }
            }
        }
        //
        return $result;
    }
   
    
}
