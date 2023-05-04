<?php


/**
 * Queen actions and behavior
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
    public int $price = 4;


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
