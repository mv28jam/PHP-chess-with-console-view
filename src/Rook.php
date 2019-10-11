<?php

/**
 * Rook actions and behavior
 * Test game: b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|a7-a6|h1-h3|c7-b6|h3-a3|a6-a5|c2-c3|a5-a4
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Rook extends AbstractFigure {
    
    /**
     * Price of Rook
     * @var integer 
     */
    public $price = 2;
    /**
     * Rook roque possible only like first step
     * @var boolean 
     */
    private $first_step = true;
    
    
    /**
     * Move Rook figure finally + rook actions
     * @param Move $move move object
     * @param Desk $desk 
     * @return AbstractFigure 
     */
    public function move(\Move $move, \Desk $desk) : AbstractFigure {
        //first move done
        $this->first_step = false;
        //
        return parent::move($move, $desk);
    }
    
    /**
     * Validate Rook move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //roque move
        if(!empty($moves[self::SPECIAL]) and $moves[self::SPECIAL][0]->strTo == $move->strTo){
            throw new Exception('Roque support under construction! Sorry...');
            //@TODO check of roque
            //return true;
        }
        //ckeck our normal move
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo){
                if(self::checkStraightMoveBlock($move, $desk)){
                    return $desk->getFigurePrice($move->to);
                }
                return Move::FORBIDDEN;
            }
        }
        //
        return Move::FORBIDDEN;;
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
        $result[self::NORMAL] = self::generateStraightMoves($move);
        //roque move without limitation
        switch(true){
            case($move->strFrom == 'h1' and $this->first_step):
                $result[self::SPECIAL][] = new Move('h1-f1');
                break;
            case($move->strFrom == 'a1' and $this->first_step):
                $result[self::SPECIAL][] = new Move('a1-d1');
                break;
            case($move->strFrom == 'h8' and $this->first_step):
                $result[self::SPECIAL][] = new Move('h8-f8');
                break;
            case($move->strFrom == 'a8' and $this->first_step):
                $result[self::SPECIAL][] = new Move('a8-d8');
                break;
        }
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♖' : '♜';
    }
    
    /**
     * Check horizontal or vertical move blocks
     * @param Move $move Move object
     * @param Desk $desk 
     * @return bool
     */
    public static function checkStraightMoveBlock(Move $move, Desk $desk) : bool 
    {
        //one step move
        if(abs($move->dY) == 1 or abs($move->dY) === 1){
            return true;
        }
        //
        $delta = 0;
        $y = false;
        //delta of move
        switch(true){
            //vertical move down
            case(abs($move->dY) > 0 and $move->dY > 0):
                $delta = $move->dY - 1;
                $y = true;
                break;
            //vertical move up
            case(abs($move->dY) > 0 and $move->dY < 0):
                $delta = $move->dY + 1;
                $y = true;
                break;
            //horizontal move left
            case($move->dX > 0):
                $delta = $move->dX - 1;
                break;
            //horizontal move right
            case($move->dX < 0):
                $delta = $move->dX + 1;
                break;
        }        
        //
        for($i = $delta; abs($i) > 0; ($delta < 0 ? $i++ : $i--)){
            if($desk->checkFigureExists(($y ? [$move->xFrom, ($move->yTo + $i)] : [$move->prevX($i), $move->yFrom])) == true){
                return false;
            }
        }
        //
        return true;
    }
    
    /**
     * Generate straight moves
     * @param Move $move
     * @return array of Move
     */
    public static function generateStraightMoves(Move $move){
        //array of moves
        $result = [];
        //
        for($i=1; $i<=8; $i++){
            //Y move
            $stepY = ($i - $move->yFrom);
            if($stepY != 0){
                $result[] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $stepY));
            }
            // X move
            $stepX = ($i - $move->getXLikeY($move->xFrom));
            if($stepX != 0){
                $result[] = new Move($move->strFrom, $move->prevX($stepX).$move->yFrom);
            }
        }
        //
        return $result;
    }
   
}
