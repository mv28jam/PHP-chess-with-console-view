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
     */
    public function generateDiagonalMoves(Move $move){
        //
        $result = [];
        //
        for($i=1; $i<=8; $i++){
            $step = ($i - $move->getXLikeY($move->xFrom));
            if($step != 0){
                if($move->checkX($move->prevX($step)) and $move->checkY($move->yFrom + $step)){
                    $result[] = new Move($move->strFrom, $move->prevX($step).($move->yFrom + $step));
                }
                if($move->checkX($move->nextX($step)) and $move->checkY($move->yFrom + $step)){
                    $result[] = new Move($move->strFrom, $move->nextX($step).($move->yFrom + $step));
                }
                if($move->checkX($move->prevX($step)) and $move->checkY($move->yFrom - $step)){
                    $result[] = new Move($move->strFrom, $move->prevX($step).($move->yFrom - $step));
                }
                if($move->checkX($move->nextX($step)) and $move->checkY($move->yFrom - $step)){
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
    
}
