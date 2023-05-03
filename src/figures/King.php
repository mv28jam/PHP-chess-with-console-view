<?php


/**
 * King actions and behavior
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
    public int $price = 100;

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
                $this->special[] = (new Move('e8', 'b8'))->setTransfer(['a8'=>'d8']);
            }else{
                $this->special[] = (new Move('e1', 'g1'))->setTransfer(['h1'=>'f1']);
                $this->special[] = (new Move('e1', 'b1'))->setTransfer(['a1'=>'d1']);
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
