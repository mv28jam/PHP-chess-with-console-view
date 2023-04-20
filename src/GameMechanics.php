<?php


/**
 * GameMehanics simulates and check moves
 * @TODO
 * @author mv28jam
 */
class GameMechanics
{
    /**
     * Check field under attack
     * @param array $field check for attack
     * @param bool $is_black attack by color
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function isFieldUnderAttack(array $field, bool $is_black, Desk $desk) : bool
    {
        $map = $desk->toMap();
        foreach ($map as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if(
                    $val->is_black === $is_black
                    and
                    $val->price > 0
                ){
                   if($this->checkProcess([$keyH,$keyG], $field, $desk) > Move::FORBIDDEN){
                       return true;
                   }
                }
            }
        }
        return false;
    }

    /**
     * Check king under attack
     * @param bool $is_black king color
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function isKingUnderAttack(bool $is_black, Desk $desk): bool
    {
        //check for attack
        return $this->isFieldUnderAttack($this->findKing($is_black, $desk), !$is_black,  $desk);
    }

    //public function isKingUnderAttackAfterMove(bool $is_black, Desk $desk){
    //
    //}
    //public function isKingCanMove(){
    //
    //}

    /**
     * @param bool $is_black
     * @param Desk $desk
     * @return array
     */
    public function findKing(bool $is_black, Desk $desk): ?array
    {
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if(
                    $val->is_black === $is_black
                    and
                    $val->price == PHP_INT_MAX
                ){
                    return [$keyH,$keyG];
                }
            }
        }
        //
        return null;
    }

    /**
     * Take figure in position $start
     * check for possibility of move to $field
     * @param array $start
     * @param array $field
     * @param Desk $desk
     * @return int
     * @throws Exception
     */
    private function checkProcess(array $start, array $field, Desk $desk): int
    {
        $clone = $desk->getFigureClone($start);
        return $clone->checkFigureMove((new Move(implode($start).'-'.implode($field))), $desk);
    }

}
