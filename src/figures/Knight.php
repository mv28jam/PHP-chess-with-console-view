<?php


/**
 * Knight actions and behavior
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Knight extends AbstractFigure
{
    /**
     * Price of Knight
     * @var integer
     */
    public int $price = 2;


    /**
     * Create array of all possible moves for knight
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    protected function countVacuumHorsePossibleMoves(Move $move): void
    {
        //
        foreach ([2, -2] as $val) {
            //forward 2 vert
            if ($move->checkY($move->yFrom + $val)) {
                if ($move->checkX($move->nextX())) {
                    $this->normal[] = new Move($move->strFrom, $move->nextX() . ($move->yFrom + $val));
                }
                if ($move->checkX($move->prevX())) {
                    $this->normal[] = new Move($move->strFrom, $move->prevX() . ($move->yFrom + $val));
                }
            }
            //forward 2 horiz
            if ($move->checkX($move->nextX($val))) {
                if ($move->checkY($move->yFrom + 1)) {
                    $this->normal[] = new Move($move->strFrom, $move->nextX($val) . ($move->yFrom + 1));
                }
                if ($move->checkY($move->yFrom - 1)) {
                    $this->normal[] = new Move($move->strFrom, $move->nextX($val) . ($move->yFrom - 1));
                }
            }
            //
        }
        //
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->is_black ? '♘' : '♞';
    }

}
