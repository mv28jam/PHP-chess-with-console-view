<?php

/**
 * Rook actions and behavior
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Rook extends AbstractFigure
{
    use SMoveTrait;
    /**
     * Price of Rook
     * @var integer
     */
    public int $price = 2;


    /**
     * Get list of possible moves from position start for rook
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    protected function countVacuumHorsePossibleMoves(Move $move): void
    {
        $this->normal = $this->generateStraightMoves($move);
    }

    /**
     * Rook made from pawn already moved
     * @return $this
     */
    public function fromPawn(): AbstractFigure
    {
        $this->first_step = false;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♖' : '♜';
    }

}
