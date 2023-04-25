<?php


/**
 * King actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5
 * Roque: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|e1-g1
 * Roque can not: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-g1
 * King goto under attack: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-f1|h7-h6|f1-g1
 * King check: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-f1|h7-h6|f1-g1|a2-a3|g3-g2
 * King collision: e2-e4|e7-e5|e1-e2|e8-e7|e2-e3|e7-e6|e3-f4|e6-f6|f3-g3|f6-g6|g3-g4|g6-g5
 * King under attack: g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-f1|h7-h6|f1-g1|a2-a3|f1-e1|a7-a6|d3-e2|g2-g1
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
     * Create array of all possible moves without other figures for king
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move): void
    {
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
