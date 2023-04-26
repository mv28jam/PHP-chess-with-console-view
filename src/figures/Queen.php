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
     * Create array of all possible moves without other figures for queen
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    protected function countVacuumHorsePossibleMoves(Move $move): void
    {
        $this->normal = array_merge($this->generateDiagonalMoves($move), $this->generateStraightMoves($move));
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♕' : '♛';
    }


}
