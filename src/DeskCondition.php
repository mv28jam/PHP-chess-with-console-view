<?php


/**
 * DeskCondition simulates and check moves
 * @TODO refactor
 * @author mv28jam
 */
class DeskCondition
{
    use SMoveTrait, DMoveTrait;

    /**
     * @throws Exception
     */
    public function checkFigureMove(Move $move, AbstractFigure $figure, Desk $desk): int
    {
        //all figure moves
        $moves = $figure->getVacuumHorsePossibleMoves($move);
        /**
         * @see  getLastMove // have to have for pawn attack "en passant"
         * @link en.wikipedia.org/wiki/Pawn_(chess)#Capturing
         */
        $last_move = $desk->getLastMove();
        //direction of move flag for color
        if ($figure->getIsBlack()) {
            $sign = 1;
        } else {
            $sign = -1;
        }
        //
        foreach ($moves['normal'] as $val) {
            if ($val->strTo === $move->strTo) {
                switch (true) {
                    case($figure instanceof Knight):
                        return $desk->getFigurePrice($move->to);
                        break;
                    case($figure instanceof Rook):
                        if ($this->checkStraightMoveBlock($move, $desk)) {
                            return $desk->getFigurePrice($move->to);
                        }
                        break;
                    case($figure instanceof Queen):
                        if (
                            (abs($move->dX) > 0 and abs($move->dY) > 0 and $this->checkDiagonalMoveBlock($move, $desk))
                            or
                            ($this->checkStraightMoveBlock($move, $desk))
                        ) {
                            return $desk->getFigurePrice($move->to);
                        }
                        break;
                    case($figure instanceof Bishop):
                        if ($this->checkDiagonalMoveBlock($move, $desk)) {
                            return $desk->getFigurePrice($move->to);
                        }
                        break;
                    case($figure instanceof King):
                        if (!$this->isFieldUnderAttack($val->to, !$figure->getIsBlack(), $desk)) {
                            if (
                                (abs($move->dX) > 0 and abs($move->dY) > 0 and $this->checkDiagonalMoveBlock($move, $desk))
                                or
                                ($this->checkStraightMoveBlock($move, $desk))
                            ) {
                                return $desk->getFigurePrice($move->to);
                            }
                        }
                        break;
                    case($figure instanceof Pawn):
                        if ($desk->getFigurePrice($move->to) === Move::MOVING) {
                            return Move::MOVING;
                        }
                        break;
                }
            }
        }
        //
        foreach ($moves['special'] as $val) {
            if ($val->strTo === $move->strTo) {
                switch (true) {
                    case($figure instanceof King):
                        if(
                            $this->checkStraightMoveBlock($move, $desk)
                            and
                            $desk->getFigureIsBlack($val->getTransferFrom()) == $figure->getIsBlack()
                            and
                            $desk->getFigureClone($val->getTransferFrom()) instanceof Rook
                            and
                            $desk->getFigureClone($val->getTransferFrom())->isFirstStep()
                            and
                            !$desk->condition->isFieldUnderAttack($val->to, !$figure->getIsBlack(), $desk)
                        ){
                            return Move::MOVING;
                        }
                        break;
                    case($figure instanceof Pawn):
                        if (
                            $desk->getFigurePrice($move->to) === 0
                            and
                            $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]) === 0
                        ) {
                            return Move::MOVING;
                        }
                        break;
                }
            }
        }
        foreach ($moves['attack'] as $val) {
            if ($val->strTo === $move->strTo) {
                switch (true) {
                    case($figure instanceof Pawn):
                        if (
                            $val->strTo === $move->strTo
                            and
                            $desk->getFigurePrice($move->to) !== 0
                            and
                            $desk->getFigureIsBlack($move->to) != $figure->getIsBlack()
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
                            $val->yFrom == $last_move->yTo
                            and
                            $last_move->xFrom == $val->xTo
                        ) {
                            $val->setKill($last_move->to);
                            return $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]);
                        }
                }
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Find move that has been done in game to process actions
     * @param Move $move
     * @return Move
     */
    protected function findResultMove(Move $move, AbstractFigure $figure): Move
    {
        $res = $figure->getVacuumHorsePossibleMoves($move);
        //
        foreach (array_merge($res['attack'], $res['normal'], $res['special']) as $val){
            if($val->strFrom == $move->strFrom and $val->strTo == $move->strTo){
                return $val;
            }
        }
        //unexpected
        return $move;
    }

    /**
     * Move figure finally + internal actions
     * @param Move $move move object
     * @param Desk $desk
     * @return MoveResult
     */
    public function processMove(Move $move, AbstractFigure $figure, Desk $desk): MoveResult
    {
        $new = $figure;
        //check pawn respawn
        //when we get 1 or 8 we have other figure
        if ($figure instanceof Pawn and $move->yTo == 1 or $move->yTo == 8) {
            //output change
            $animated_output = new ConsoleAnimated\ConsoleAnimatedOutput();
            $animated_output->cursorUp();
            $animated_output->echoLine('Choose replace of pawn, type first letter of figure name:');
            unset($animated_output);
            //choose figure by first letter
            switch (trim(fgets(STDIN))) {
                case('r'):
                case('R'):
                    $new = (new Rook($figure->getIsBlack()))->fromPawn();
                    break;
                case('K'):
                case('k'):
                    $new = new Knight($figure->getIsBlack());
                    break;
                case('B'):
                case('b'):
                    $new = new Bishop($figure->getIsBlack());
                    break;
                case('q'):
                case('Q'):
                default:
                    $new = new Queen($figure->getIsBlack());
            }
        }
        //
        $res = (new MoveResult())
            ->setFigure($new)
            ->setMove($this->findResultMove($move, $figure));
        //
        $figure->step();
        //
        return $res;
    }


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
        return $this->checkFigureMove((new Move(implode($start).'-'.implode($field))), $desk->getFigureClone($start), $desk);
    }

}
