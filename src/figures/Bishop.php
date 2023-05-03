<?php


/**
 * Knight actions and behavior
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
     * Create array of all possible moves without other figures for bishop
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
        $this->normal = $this->generateDiagonalMoves($move);
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♗' : '♝';
    }

}
