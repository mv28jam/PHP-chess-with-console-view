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
        $this->getVacuumHorsePossibleMoves($move); 
        return true;
    }
    
    /**
     * Get list of possible moves from position start for rook
     * @param array $start - start position
     * @return array of arrays of Move with keys 
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //
        for($i=1; $i<=8; $i++){
            $step = ($i - $move->yFrom);
            if($step == 0){
                continue;
            }
            $result[self::NORMAL][] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $step));
            $result[self::NORMAL][] = new Move($move->strFrom, $move->nextX($step).$move->yFrom);
        }
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
