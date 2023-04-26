<?php


/**
 * Rook actions and behavior
 * Test game: b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|a7-a6|h1-h3|c7-b6|h3-a3|a6-a5|c2-c3|a5-a4
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
