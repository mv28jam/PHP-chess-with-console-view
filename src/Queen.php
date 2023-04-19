<?php


/**
 * Queen actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Queen extends AbstractFigure
{
    use SMoveTrait, DMoveTrait;

    /**
     * Price of Queen
     * @var integer
     */
    public int $price = 3;


    /**
     * Validate Queen move
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
        foreach ($this->normal as $val) {
            if ($val->strTo === $move->strTo) {
                switch (true) {
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
     * Create array of all possible moves without other figures for queen
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
        if (!empty($this->normal)) {
            return;
        }
        //
        $this->normal = array_merge($this->generateDiagonalMoves($move), $this->generateStraightMoves($move));
        //
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♕' : '♛';
    }


}
