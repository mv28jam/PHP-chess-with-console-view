<?php


/**
 * Knight actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Bishop extends AbstractFigure
{
    use DMoveTrait;

    /**
     * Price of Bishop
     * @var integer
     */
    public int $price = 2;


    /**
     * Validate Bishop move
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
                if ($this->checkDiagonalMoveBlock($move, $desk)) {
                    return $desk->getFigurePrice($move->to);
                }
                return Move::FORBIDDEN;
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Create array of all possible moves without other figures for bishop
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
        //
        $this->normal = $this->generateDiagonalMoves($move);
        //        
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♗' : '♝';
    }

}
