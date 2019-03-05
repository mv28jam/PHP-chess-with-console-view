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
        //if requested move is possible
        //without desk figures poditions check
        $possible = false;
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //ckeck our normal move
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo){
                $possible = true;
            }
        }
        //teoretecly can not do such move
        if(!$possible){
            return Move::FORBIDDEN;
        }
        //
        
        //
        return 0;
    }
    
    /**
     * Get list of possible moves from position start for rook
     * @param Move $move
     * @return array of array of Move 
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //ordinary moves
        for($i=1; $i<=8; $i++){
            //Y move
            $stepY = ($i - $move->yFrom);
            if($stepY != 0){
                $result[self::NORMAL][] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $stepY));
            }
            // X move
            $stepX = ($i - $move->getXLikeY($move->xFrom));
            if($stepX != 0){
                $result[self::NORMAL][] = new Move($move->strFrom, $move->prevX($stepX).$move->yFrom);
            }
        }
        //roque
        //@todo
        $result[self::SPECIAL] = null;
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
