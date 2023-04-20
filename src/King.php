<?php


/**
 * King actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7
 * Test of end game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7|f5-f2|h2-h3|f2-e1
 * Roque: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|e1-g1
 * Roque can not: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-g1
 * King goto under attack: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-f1|h7-h6|f1-g1
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class King extends AbstractFigure
{
    use SMoveTrait;
    use DMoveTrait;

    /**
     * Price of King
     * @var integer
     */
    public int $price = PHP_INT_MAX;

    /**
     * First step save for roque
     * @var boolean first pawn step or not
     */
    private bool $first_step = true;

    /**
     * Unset king = game over
     * @throws EndGameException
     */
    public function destructFigure(): void
    {
        if (isset($this->price)) {
            throw new EndGameException('Game over. ' . (new Pawn(!$this->is_black)) . ' wins by ');
        }
    }

    /**
     * Move action and after action for king
     * @param Move $move
     * @param Desk $desk
     * @return MoveResult
     */
    public function processMove(Move $move, Desk $desk): MoveResult
    {
        $this->first_step = false;
        //
        return parent::processMove($move, $desk);
    }

    /**
     * Validate King move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     * @throws Exception
     */
    public function checkFigureMove(Move $move, Desk $desk): int
    {
        //get possible moves
        $this->countVacuumHorsePossibleMoves($move);
        //
        foreach ($this->special as $val){
            if ($val->strTo === $move->strTo) {
                if(
                    $this->checkStraightMoveBlock($move, $desk)
                    and
                    $desk->getFigureIsBlack($val->getTransferFrom()) == $this->is_black
                    and
                    $desk->getFigureClone($val->getTransferFrom()) instanceof Rook
                    and
                    $desk->getFigureClone($val->getTransferFrom())->isFirstStep()
                    and
                    !$desk->mechanics->isFieldUnderAttack($val->to, !$this->is_black, $desk)
                ){
                    return Move::MOVING;
                }
            }
        }
        //
        foreach ($this->normal as $val) {
            if ($val->strTo === $move->strTo and !$desk->mechanics->isFieldUnderAttack($val->to, !$this->is_black, $desk)) {
                switch (true) {
                    //@TODO check got attack move
                    case(abs($move->dX) > 0 and abs($move->dY) > 0 and $this->checkDiagonalMoveBlock($move, $desk)):
                    case($this->checkStraightMoveBlock($move, $desk)):
                        return $desk->getFigurePrice($move->to);
                    default:
                        return Move::FORBIDDEN;
                }
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Create array of all possible moves without other figures for king
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
        //
        if (!empty($this->normal)) {
            return;
        }
        //
        if($this->first_step){
            if($this->is_black){
                $this->special[] = (new Move('e8', 'g8'))->setTransfer(['h8'=>'f8']);
                $this->special[] = (new Move('e8', 'a8'))->setTransfer(['a8'=>'d8']);
            }else{
                $this->special[] = (new Move('e1', 'g1'))->setTransfer(['h1'=>'f1']);
                $this->special[] = (new Move('e1', 'a1'))->setTransfer(['a1'=>'d1']);
            }
        }
        //
        foreach (array_merge($this->generateDiagonalMoves($move), $this->generateStraightMoves($move)) as $val) {
            if (abs($val->dX) < 2 and abs($val->dY) < 2) {
                $this->normal[] = $val;
            }
        }
        //
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♔' : '♚';
    }

}
