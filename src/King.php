<?php


/**
 * Queen actions and behavior
 * Test game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7
 * Test of end game: e2-e4|d7-d6|f1-a6|c8-g4|d1-e2|d8-d7|e2-b5|d7-f5|b5-b7|f5-f2|h2-h3|f2-e1
 * 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class King extends AbstractFigure {
    use SMoveTrait;
    use DMoveTrait;
    
    /**
     * Price of King
     * @var integer 
     */
    public $price = PHP_INT_MAX;

    /**
     * King castling possible only like first step
     * @var boolean
     */
    private $first_step = true;

    /**
     * Unset king = game over
     */
    public function killFigure() : void {
        if(isset($this->price)){
            throw new EndGameException('Game over. '.(new Pawn(!$this->is_black)).' wins by ');
        }
    }
    
    /**
     * Move action and after action for king
     * @param Move $move
     * @param Desk $desk
     * @return King
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        //first move done
        $this->first_step = false;

        return parent::move($move, $desk);
    }

    /**
     * Validate King move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     * @throws Exception
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {

        //TODO special checks

        //check for self attack
        if($this->checkSelfAttack($move, $desk)){
            return Move::FORBIDDEN;
        }
        //get possible moves
        $this->countVacuumHorsePossibleMoves($move);
        //special moves(castling)
        foreach ($this->special as $val) {
            if ($val->strTo === $move->strTo) {
                if ($this->checkStraightMoveBlock($move, $desk)) {
                    // Check if King is in check now
                    if ($desk->isPositionUnderAttack($move->from, $this->is_black)) {
                        throw new \Exception('King is in check, castling temporary unavailable');
                    }
                    // Check if King will be in check
                    if ($desk->isPositionUnderAttack($move->to, $this->is_black)) {
                        throw new \Exception('King end up in check, castling temporary unavailable');
                    }
                    if ($desk->isFigureExists($move->to)) {
                        return Move::FORBIDDEN;
                    }
                    switch ($move->strTo) {
                        case ('c1'):
                            // Check if King is pass through field controlled by enemy
                            if ($desk->isPositionUnderAttack(['d', '1'], $this->is_black)) {
                                throw new \Exception('King is pass through field controlled by enemy, castling temporary unavailable');
                            }
                            $desk->move(new Move('a1-d1'), true);
                            break;
                        case ('g1'):
                            if ($desk->isPositionUnderAttack(['f', '1'], $this->is_black)) {
                                throw new \Exception('King is pass through field controlled by enemy, castling temporary unavailable');
                            }
                            $desk->move(new Move('h1-f1'), true);
                            break;
                        case ('c8'):
                            if ($desk->isPositionUnderAttack(['d', '8'], $this->is_black)) {
                                throw new \Exception('King is pass through field controlled by enemy, castling temporary unavailable');
                            }
                            $desk->move(new Move('a8-d8'), true);
                            break;
                        case ('g8'):
                            if ($desk->isPositionUnderAttack(['f', '8'], $this->is_black)) {
                                throw new \Exception('King is pass through field controlled by enemy, castling temporary unavailable');
                            }
                            $desk->move(new Move('h8-f8'), true);
                            break;
                    }
                    return $desk->getFigurePrice($move->to);
                }
                return Move::FORBIDDEN;
            }
        }
        foreach($this->normal as $val){
            if($val->strTo === $move->strTo){
                switch(true){
                    //@TODO check got attack move
                    case(abs($move->dX) > 0 and abs($move->dY) > 0 and $this->checkDiagonalMoveBlock($move, $desk)):
                    case($this->checkStraightMoveBlock($move, $desk)):
                        return $desk->getFigurePrice($move->to);
                    default:
                        return Move::FORBIDDEN;
                }
            }
        }
        //
        return Move::FORBIDDEN;
    }

    /**
     * Create array of all possible moves without other figures for king
     * @param Move $move
     * @throws Exception
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move) : void
    {
        //
        if(!empty($this->normal)){
            return;
        }
        //
        foreach(array_merge($this->generateDiagonalMoves($move), $this->generateStraightMoves($move)) as $val){
            if(abs($val->dX)<2 and abs($val->dY)<2){
                $this->normal[] = $val;
            }
            if ($this->first_step and $val->dY === 0 and abs($val->dX) === 2) {
                $this->special[] = $val;
            }
        }
        //
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string  
    {
        return $this->is_black ? '♔' : '♚';
    }
    
}
