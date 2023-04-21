<?php


/**
 * DeskCondition simulates and check moves
 * Has no state!
 * Describes game mechanics
 * @author mv28jam
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
     * REDO FIXME
     */
    public function checkFigureMove(Move $move, AbstractFigure $figure, Desk $desk): int
    {
        //all figure moves
        $moves = $figure->getVacuumHorsePossibleMoves($move);
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
                        //FIXME +check for kings around 1  field
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
                        if($this->checkForRoque($val, $figure, $desk)) return Move::MOVING;
                        break;
                    case($figure instanceof Pawn):
                        if ($this->checkPawn2fieldMove($move, $figure, $desk)) return Move::MOVING;
                        break;
                }
            }
        }
        //check attack moves
        foreach ($moves['attack'] as $val) {
            if ($val->strTo === $move->strTo) {
                //only pawn has
                if ($figure instanceof Pawn) {
                    return $this->checkPawnEnPassant($val, $figure, $desk);
                }
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Move figure finally + internal actions
     * @param Move $move move object
     * @param AbstractFigure $figure
     * @param Desk $desk
     * @return MoveResult - resulting move != initial $move
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

    //public function isKingUnderAttackAfterMove(bool $is_black, Desk $desk){
    //
    //}
    //public function isKingCanMove(){
    //
    //}

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
        $map = $desk->toMap();
        foreach ($map as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if(
                    $val->is_black === $is_black
                    and $val->price > 0
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
                    $val->price == (new King(true))->price
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
    private function checkForRoque(Move $move, AbstractFigure $figure, Desk $desk):bool
    {
        if(
            $this->checkStraightMoveBlock($move, $desk)
            and
            $desk->getFigureIsBlack($move->getTransferFrom()) == $figure->getIsBlack()
            and
            $desk->getFigureClone($move->getTransferFrom()) instanceof Rook
            and
            $desk->getFigureClone($move->getTransferFrom())->isFirstStep()
            and
            !$this->isFieldUnderAttack($move->to, !$figure->getIsBlack(), $desk)
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
        $figure->getIsBlack() ? $sign = -1 : $sign = 1;
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
    private function checkPawnEnPassant(Move $move, AbstractFigure $figure, Desk $desk) : int
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
            $desk->getFigurePrice($move->to) !== 0
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
     */
    private function figureConversion(Move $move, AbstractFigure $figure): AbstractFigure{
        if ($figure instanceof Pawn and $move->yTo == 1 or $move->yTo == 8) {
            //
            if($move->respawn){
                $respawn = $move->respawn;
            }else{
                //output change FIXME
                $animated_output = new ConsoleAnimated\ConsoleAnimatedOutput();
                $animated_output->cursorUp();
                $animated_output->echoLine('Choose replace of pawn, type first letter of figure name:');
                $respawn = trim(fgets(STDIN));
                unset($animated_output);
            }
            //choose figure by first letter
            switch ($respawn) {
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
                default:
                    return new Queen($figure->getIsBlack());
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
            (new Move(implode($start).Move::$separator.implode($field))),
            $desk->getFigureClone($start),
            $desk
        );
    }

}
