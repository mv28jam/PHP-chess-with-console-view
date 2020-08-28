<?php


/**
 * Knight actions and behavior
 * Test game:g1-f3|b8-c6|f3-e5|c6-e5|e2-e4|f5-e3|e4-e5|f3-e1
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
     * @throws Exception
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        //check for self attack
        if($this->checkSelfAttack($move, $desk)){
            return Move::FORBIDDEN;
        }
        //get possible moves
        $this->countVacuumHorsePossibleMoves($move);
        //
        foreach($this->normal as $val){
            if($val->strTo === $move->strTo){
                return $desk->getFigurePrice($move->to);
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Create array of all possible moves for knight
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move) : void
    {
        //
        if(!empty($this->normal)){
            return;
        }
        //
        foreach([2,-2] as $val){
            //forward 2 vert
            if($move->checkY($move->yFrom + $val)){
                if($move->checkX($move->nextX())){
                    $this->normal[] = new Move($move->strFrom, $move->nextX().($move->yFrom + $val));
                }
                if($move->checkX($move->prevX())){
                    $this->normal[] = new Move($move->strFrom, $move->prevX().($move->yFrom + $val));
                }
            }
            //forward 2 horiz
            if($move->checkX($move->nextX($val))){
                if($move->checkY($move->yFrom + 1)){
                    $this->normal[] = new Move($move->strFrom, $move->nextX($val).($move->yFrom + 1));
                }
                if($move->checkY($move->yFrom - 1)){
                    $this->normal[] = new Move($move->strFrom, $move->nextX($val).($move->yFrom -1));
                }
            }
            //
        }
        //
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♘' : '♞';
    }
    
}
