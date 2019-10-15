<?php

/**
 * Queen actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
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
     * @param Desk $desk not used!
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk): int 
    {
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo){
                switch(true){
                    case(abs($move->dX) > 0 and abs($move->dY) > 0 and Bishop::checkDiagonalMoveBlock($move, $desk)):
                    case(Rook::checkStraightMoveBlock($move, $desk)):
                        return $desk->getFigurePrice($move->to);
                    default:
                        return Move::FORBIDDEN;
                }
            }
        }
        //
        return Move::FORBIDDEN;
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
        $result = parent::getVacuumHorsePossibleMoves($move);
        //
        $result[self::NORMAL] = array_merge(Bishop::generateDiagonalMoves($move), Rook::generateStraightMoves($move));
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♕' : '♛';
    }

    
}
