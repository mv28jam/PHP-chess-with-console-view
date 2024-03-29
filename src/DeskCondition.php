<?php


/**
 * DeskCondition simulates and check moves
 * Has no state!
 * Stateless.
 * Describes game mechanics
 * @author mv28jam
 *
 * c2-c4|b7-b6|d1-b3|g8-f6|a2-a4|f6-h5|b3-a3|c8-a6|a3-b4|h7-h6|b4-a5|b6-a5|g2-g4|a6-c4|g4-h5|d7-d5|g1-f3|d8-c8|e2-e4|d5-e4|f1-c4|e4-f3|c4-b5|e8-d8|a1-a3|c8-f5|h1-f1|f5-b1|a3-f3|b1-c1|e1-e2|c1-b2|f3-f7|b2-a2|f1-e1|a2-f7|e2-d1|f7-f2|d1-c1|f2-e1|c1-c2|e1-e4|c2-d1|h8-h7|h2-h3|e4-e3|d2-e3|g7-g6|h5-g6|h7-f7|g6-f7|e7-e5|f7-e8-r
 *
 */
class DeskCondition
{
    use SMoveTrait, DMoveTrait;

    /**
     * @param Move $move - initial Move, not result Move
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return int
     * @throws Exception
     */
    public function checkFigureMove(Move $move, AbstractFigure $figure, Desk $desk): int
    {
        //all figure moves
        $moves = $figure->getVacuumHorsePossibleMoves($move);
        //
        foreach ($moves['normal'] as $val) {
            //check for move destination and respawn for diff pawn moves
            if ($val->strTo === $move->strTo and $val->respawn == $move->respawn) {
                switch (true) {
                    case($figure instanceof Knight):
                        return $desk->getFigurePrice($val->to);
                        break;
                    case($figure instanceof Rook):
                        if ($this->checkStraightMoveBlock($val, $desk)) return $desk->getFigurePrice($val->to);
                        break;
                    case($figure instanceof Queen):
                        if (abs($val->dX) > 0 and abs($val->dY) > 0){
                            if($this->checkDiagonalMoveBlock($val, $desk)) return $desk->getFigurePrice($val->to);
                        }else{
                            if($this->checkStraightMoveBlock($val, $desk)) return $desk->getFigurePrice($val->to);
                        }
                        break;
                    case($figure instanceof Bishop):
                        if ($this->checkDiagonalMoveBlock($val, $desk)) return $desk->getFigurePrice($val->to);
                        break;
                    case($figure instanceof Pawn):
                        if ($desk->getFigurePrice($val->to) === Move::MOVING){
                            //if pawn convert to other figure return price of new figure
                           if($val->respawn != '') {
                               return $this->figureConversion($val, $figure)->price();
                           }
                           return Move::MOVING;
                        }
                        break;
                    case($figure instanceof King):
                        if($this->checkKingMove($val, $figure, $desk))return $desk->getFigurePrice($move->to);
                        break;

                }
            }
        }
        //check attack moves
        foreach ($moves['attack'] as $val) {
            if ($val->strTo === $move->strTo) {
                if ($figure instanceof Pawn){
                    $pprice = $this->checkPawnAttack($val, $figure, $desk);
                    //if convert after attack price more
                    if($pprice != Move::FORBIDDEN and $val->respawn != '') {
                        $pprice += $this->figureConversion($val, $figure)->price();
                    }
                    return $pprice;
                }
            }
        }
        //
        foreach ($moves['special'] as $val) {
            if ($val->strTo === $move->strTo) {
                switch (true) {
                    case($figure instanceof King):
                        if($this->checkForRoque($val, $figure, $desk)) return Move::MOVING;
                        break;
                    case($figure instanceof Pawn):
                        if ($this->checkPawn2fieldMove($val, $figure, $desk)) return Move::MOVING;
                        break;
                }
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Move figure finally + internal actions
     * @param Move $move INITIAL(!) move object
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return MoveResult - resulting move != initial $move
     * @throws Exception
     */
    public function processMove(Move $move, AbstractFigure $figure, Desk $desk): MoveResult
    {
        //Move result assembly
        $res = (new MoveResult())
            ->setFigure($this->figureConversion($move, $figure))
            ->setMove($this->findResultMove($move, $figure));
        //signal for figure about move finalisation
        $figure->step();
        //
        return $res;
    }

    /**
     * Check for king under attack after move = loose
     * @param Move $move
     * @param bool $is_black
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function isKingUnderAttackAfterMove(Move $move, bool $is_black, Desk $desk) : bool{
        $clone = $desk->getDeskClone();
        $clone->moveActions($move);
        if($this->isKingUnderAttack($is_black, $clone)){
            return true;
        }
        unset ($clone);
        //
        return false;
    }

    /**
     * @param Move $move
     * @param Desk $desk
     * @return bool
     */
    public function selfAttackAbstractMove(Move $move, Desk $desk): bool{
        if ($desk->isFigureExists($move->to)) {
            return ($desk->getFigureIsBlack($move->from) === $desk->getFigureIsBlack($move->to));
        } else {
            return false;
        }
    }

    /**
     * End game by 2 kings on desk
     * @param Desk $desk
     * @return bool
     */
    public function isEndGameBy2Kings(Desk $desk): bool
    {
        $count=0;
        //
        foreach ($desk->toMap() as $keyH => $line) {
            foreach ($line as $keyG => $val) {
                if(!empty($val->fig)){
                    $count++;
                    if($count > 2){
                        return false;
                    }
                }
            }
        }
        //
        return true;
    }

    /**
     * Check for figures of color can unset check
     * @param bool $is_black
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function isEndGameByCheckmate(bool $is_black, Desk $desk): bool
    {
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if($val->is_black === $is_black and !empty($val->fig)){
                    $fig = $desk->getFigureClone([$keyH,$keyG]);
                    foreach($fig->getVacuumHorsePossibleMoves(new DummyMove(implode([$keyH,$keyG])),true) as $pmove) {
                        if(
                            !$this->selfAttackAbstractMove($pmove, $desk)
                            and
                            $this->checkFigureMove($pmove, $fig, $desk) > Move::FORBIDDEN
                        ){
                            if(!$this->isKingUnderAttackAfterMove($pmove,$is_black,$desk)) return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Alias for isEndGameByCheckmate
     * @param bool $is_black
     * @param Desk $desk
     * @return bool
     * @throws Exception
     * @see self::isEndGameByCheckmate()
     */
    public function isEndGameByStalemate(bool $is_black, Desk $desk): bool
    {
        return $this->isEndGameByCheckmate($is_black, $desk);
    }



    /**
     * Check field under attack
     * @param array $field field for attack
     * @param bool $is_black attack by color
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function isFieldUnderAttack(array $field, bool $is_black, Desk $desk) : bool
    {
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if(
                    $val->is_black === $is_black
                    and !empty($val->fig)
                    and [$keyH,$keyG] != $field //field under attack can be start field
                    and $this->checkProcess([$keyH,$keyG], $field, $desk) > Move::FORBIDDEN
                ){
                    return true;
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

    /**
     * Check for kings close less then one field of each other
     * @param Move $move
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    protected function isKingCollision(Move $move, Desk $desk): bool
    {
        $to1 = $to2 =[];
        //
        $king1 = $desk->getFigureClone($move->from);
        $king2pos = $this->findKing(!$king1->getIsBlack(), $desk);
        $king2 = $desk->getFigureClone($king2pos);
        //
        foreach($king1->getVacuumHorsePossibleMoves($move, true) as $val){
            $to1[] = $val->strTo;
        }
        foreach($king2->getVacuumHorsePossibleMoves(new DummyMove(implode($king2pos)), true) as $val){
            $to2[] = $val->strTo;
        }
        //
        if(!empty(array_intersect($to1, $to2, [$move->strTo]))){
            return true;
        }
        return false;
    }

    /**
     * @param bool $is_black
     * @param Desk $desk
     * @return array|null
     */
    public function findKing(bool $is_black, Desk $desk): ?array
    {
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if(
                    $val->is_black === $is_black
                    and
                    $val->fig == get_class(new King(true))
                ){
                    return [$keyH,$keyG];
                }
            }
        }
        //
        return null;
    }


    /**
     * @param Move $move
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    public function checkKingMove(Move $move, AbstractFigure $figure, Desk $desk):bool
    {
        //
        if($this->isKingCollision($move, $desk)){
            return false;
        }
        //
        if (
            (abs($move->dX) > 0 and abs($move->dY) > 0 and $this->checkDiagonalMoveBlock($move, $desk))
            or
            ($this->checkStraightMoveBlock($move, $desk))
        ) {
            return true;
        }
        //
        return false;
    }

    /**
     * @param Move $move
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return bool
     * @throws Exception
     */
    private function checkForRoque(Move $move, AbstractFigure $figure, Desk $desk):bool
    {
        //
        if($this->isKingCollision($move, $desk)){
            return false;
        }
        //
        if(
            $this->checkStraightMoveBlock($move, $desk)
            and
            $desk->isFigureExists($move->getTransferFrom())
            and
            $desk->getFigureIsBlack($move->getTransferFrom()) == $figure->getIsBlack()
            and
            $desk->getFigureClone($move->getTransferFrom()) instanceof Rook
            and
            $desk->getFigureClone($move->getTransferFrom())->isFirstStep()
        ){
            return true;
        }
        //
        return  false;
    }

    /**
     * Check for 2 fields pawn move
     * @param Move $move
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return bool
     */
    private function checkPawn2fieldMove(Move $move, AbstractFigure $figure, Desk $desk): bool
    {
        // $sign direction of move flag for pawn
        $figure->getIsBlack() ? $sign = 1 : $sign = -1;
        //
        if (
            $desk->getFigurePrice($move->to) === 0
            and
            $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]) === 0
        ) {
            return true;
        }
        return false;
    }

    /**
     * Check for en passant conditions
     * @param Move $move
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return int
     */
    private function checkPawnAttack(Move $move, AbstractFigure $figure, Desk $desk) : int
    {
        // $sign direction of move flag for pawn
        $figure->getIsBlack() ? $sign = -1 : $sign = 1;
        //
        /**
         * @see  getLastMove // have to have for pawn attack "en passant"
         * @link en.wikipedia.org/wiki/Pawn_(chess)#Capturing
         */
        $last_move = $desk->getLastMove();
        if (
            $desk->getFigurePrice($move->to) > 0
        ) {
            return $desk->getFigurePrice($move->to);
        }
        //check for attack "en passant"
        if (
            !empty($last_move)
            and
            $desk->getFigureClone($last_move->to) instanceof Pawn
            and
            $desk->getFigureIsBlack($last_move->to) != $figure->getIsBlack()
            and
            abs($last_move->dY) == 2
            and
            abs($last_move->yTo - $move->yTo)<2
            and
            $move->yFrom == $last_move->yTo
            and
            $last_move->xFrom == $move->xTo
        ) {
            $move->setKill($last_move->to);
            return $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]);
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * For pawn conversion into other figure is possible
     * check pawn respawn when we get 1 or 8 we have other figure
     * @param Move $move
     * @param AbstractFigure $figure
     * @return AbstractFigure
     * @throws Exception
     */
    private function figureConversion(Move $move, AbstractFigure $figure): AbstractFigure{
        //
        if ($figure instanceof Pawn and ($move->yTo == 1 or $move->yTo == 8)) {
            //
            if($move->respawn == ''){
                throw new Exception('Pawn conversion move. Choose replace of pawn by adding h2-g1-r (move +first letter of new figure name).');
            }
            //choose figure by first letter
            switch ($move->respawn) {
                case('r'):
                case('R'):
                    return (new Rook($figure->getIsBlack()))->fromPawn();
                case('K'):
                case('k'):
                    return new Knight($figure->getIsBlack());
                case('B'):
                case('b'):
                    return new Bishop($figure->getIsBlack());
                case('q'):
                case('Q'):
                    return new Queen($figure->getIsBlack());
                default:
                    user_error('Conversion Pawn unexpected value', E_USER_ERROR);
            }
        }
        //
        return $figure;
    }

    /**
     * Detect result move with after actions by initial move
     * Result move that has been done in game to process actions
     * @param Move $move
     * @param AbstractFigure $figure
     * @return Move
     */
    private function findResultMove(Move $move, AbstractFigure $figure): Move
    {
        //
        foreach ($figure->getVacuumHorsePossibleMoves($move, true) as $val){
            //object Move ($val, $move) are NOT equal - initial move can not contain en passant attack for example
            if($val->strFrom == $move->strFrom and $val->strTo == $move->strTo and $val->respawn == $move->respawn){
                return $val;
            }
        }
        return $move;
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
        return $this->checkFigureMove(
            (new Move(implode($start),implode($field))),
            $desk->getFigureClone($start),
            $desk
        );
    }

}
