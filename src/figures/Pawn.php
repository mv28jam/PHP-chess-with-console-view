<?php


/**
 * Pawn actions and behavior
 * "en passant" move example b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3
 * figure change example b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1+r
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Pawn extends AbstractFigure
{
    /**
     * Abstract price of figure for automatic game
     * @var int
     */
    protected int $price = 1;

    public array $conversions = ['q','r','k','b'];

    /**
     * Create array of all possible moves without other figures for pawn
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
        //direction of move flag for color
        $this->is_black ? $sign = -1 : $sign = 1;
        //
        $y = $move->yFrom + $sign;
        //straight move
        if ($move->checkY($y)) {
            if($y == 1 or $y == 8) {
                foreach ($this->conversions as $add) {
                    $this->normal[] = new Move($move->strFrom, $move->xFrom.$y.Move::SEPARATOR.$add);
                }
            }else{
                $this->normal[] = new Move($move->strFrom, $move->xFrom . $y);
            }
        }
        //attack
        if ($move->checkX($move->nextX()) and $move->checkY($y)) {
            if($y == 1 or $y == 8) {
                foreach ($this->conversions as $add) {
                    $this->normal[] = new Move($move->strFrom, $move->nextX().$y.Move::SEPARATOR.$add);
                }
            }else{
                $this->attack[] = new Move($move->strFrom, $move->nextX() . $y);
            }
        }
        if ($move->checkX($move->prevX()) and $move->checkY($y)) {
            if($y == 1 or $y == 8) {
                foreach ($this->conversions as $add) {
                    $this->normal[] = new Move($move->strFrom, $move->prevX() . $y.Move::SEPARATOR.$add);
                }
            }else{
                $this->attack[] = new Move($move->strFrom, $move->prevX() . $y);
            }
        }
        //special move
        if ($this->first_step) {
            $this->special[] = new Move($move->strFrom, $move->xFrom . ($move->yFrom + (2 * $sign)));
        }
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function __toString(): string
    {
        return $this->is_black ? '♙' : '♟';
    }
}
