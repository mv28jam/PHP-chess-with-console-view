<?php


/**
 * Rook actions and behavior
 * Test game: b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|a7-a6|h1-h3|c7-b6|h3-a3|a6-a5|c2-c3|a5-a4
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Rook extends AbstractFigure {
    use SMoveTrait;
    
    /**
     * Price of Rook
     * @var integer 
     */
    public $price = 2;
    /**
     * Rook roque possible only like first step
     * @var boolean 
     */
    private $first_step = true;
    
    
    /**
     * Move Rook figure finally + rook actions
     * @param Move $move move object
     * @param Desk $desk 
     * @return AbstractFigure 
     */
    public function move(\Move $move, \Desk $desk) : AbstractFigure {
        //first move done
        $this->first_step = false;
        //
        return parent::move($move, $desk);
    }

    /**
     * Validate Rook move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int {@inheritdoc}
     * @throws Exception
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        //check for self attack
        if($this->checkSelfAttack($move, $desk)){
            return Move::FORBIDDEN;
        }
        //get possible moves
        $this->countVacuumHorsePossibleMoves($move);
        //roque move
        if(!empty($this->special) and $this->special[0]->strTo == $move->strTo){
            throw new Exception('Roque support under construction! Sorry...');
            //@TODO check of roque
            //return true;
        }
        //ckeck our normal move
        foreach($this->normal as $val){
            if($val->strTo === $move->strTo){
                if($this->checkStraightMoveBlock($move, $desk)){
                    return $desk->getFigurePrice($move->to);
                }
                return Move::FORBIDDEN;
            }
        }
        //
        return Move::FORBIDDEN;;
    }

    /**
     * Get list of possible moves from position start for rook
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
        //ordinary moves
        $this->normal = $this->generateStraightMoves($move);
        //roque move without limitation
        switch(true){
            case($move->strFrom == 'h1' and $this->first_step):
                $this->special[] = new Move('h1-f1');
                break;
            case($move->strFrom == 'a1' and $this->first_step):
                $this->special[] = new Move('a1-d1');
                break;
            case($move->strFrom == 'h8' and $this->first_step):
                $this->special[] = new Move('h8-f8');
                break;
            case($move->strFrom == 'a8' and $this->first_step):
                $this->special[] = new Move('a8-d8');
                break;
        }
        //
    }

    /**
     * Rook made from pawn already moved
     * @return $this
     */
    public function fromPawn(){
        $this->first_step = false;
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♖' : '♜';
    }
   
}
