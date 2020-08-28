<?php


/**
 * Horizontal vertical (Straight) move trait
 *
 * @uses Move, Desk
 * @author mv28jam
 */
trait SMoveTrait {

    /**
     * Generate straight moves
     * @param Move $move
     * @return array of Move
     * @throws Exception
     */
    public function generateStraightMoves(Move $move){
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
    
    /**
     * Check horizontal or vertical move blocks
     * @param Move $move Move object
     * @param Desk $desk 
     * @return bool
     */
    public function checkStraightMoveBlock(Move $move, Desk $desk) : bool 
    {
        //one step move
        if(abs($move->dY) == 1 or abs($move->dY) == 1){
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
            if($desk->isFigureExists(($y ? [$move->xFrom, ($move->yTo + $i)] : [$move->prevX($i), $move->yFrom])) == true){
                return false;
            }
        }
        //
        return true;
    }
    
}
