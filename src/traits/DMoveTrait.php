<?php


/**
 * Diagonal move trait
 *
 * @uses Move, Desk
 * @author mv28jam
 */
trait DMoveTrait {

    /**
     * Generate diagonal moves
     * @param Move $move
     * @return array of Move
     * @throws Exception
     */
    public function generateDiagonalMoves(Move $move){
        //
        $result = [];
        //
        for($i=1; $i<=8; $i++){
            $step = ($i - $move->getXLikeY($move->xFrom));
            if($step != 0){
                if($move->checkXY($move->prevX($step), $move->yFrom + $step)){
                    $result[] = new Move($move->strFrom, $move->prevX($step).($move->yFrom + $step));
                }
                if($move->checkXY($move->nextX($step), $move->yFrom + $step)){
                    $result[] = new Move($move->strFrom, $move->nextX($step).($move->yFrom + $step));
                }
                if($move->checkXY($move->prevX($step), $move->yFrom - $step)){
                    $result[] = new Move($move->strFrom, $move->prevX($step).($move->yFrom - $step));
                }
                if($move->checkXY($move->nextX($step),$move->yFrom - $step)){
                    $result[] = new Move($move->strFrom, $move->nextX($step).($move->yFrom - $step));
                }
            }
        }
        //
        return $result;
    }
    
    /**
     * Check diagonal move blocks
     * @param Move $move Move object
     * @param Desk $desk 
     * @return bool
     */
    public function checkDiagonalMoveBlock(Move $move, Desk $desk) : bool 
    {
        //dir sign
        $y=0;
        $x=0;
        //one step move
        if(abs($move->dY) == 1){
            return true;
        }
        //define direction
        switch(true){
            //down left
            case($move->dY > 0 and $move->dX > 0):
                $y = $x = -1;
                break;
            //down right
            case($move->dY > 0 and $move->dX < 0):
                $y = -1;
                $x = 1;
                break;
            //up right
            case($move->dX > 0)://$move->dY < 0
                $y = 1;
                $x = -1;
                break;
            //up left
            case($move->dX < 0)://$move->dY < 0
                $y = $x = 1;
                break;
        }  
        //check desk
        for($i = 1; $i < abs($move->dX); $i++){
            if($desk->isFigureExists([$move->nextX($i*$x), ($move->yFrom + $i*$y)]) == true){
                return false;
            }
        }
        //
        return true;
    }
    
}
