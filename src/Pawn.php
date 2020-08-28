<?php


/**
 * Pawn actions and behavior
 * "en passant" move example b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6
 * figure change example b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Pawn extends AbstractFigure {
    
    /**
     * Pawn first step differ form other
     * @var boolean first pawn step or not
     */
    private $first_step=true;
    /**
     * Abstract price of figure for automatic game
     * @var int 
     */
    protected $price = 1;
    /**
     * Changes to desk after "en passant" move
     * @var array 
     */
    protected $desk_change = [];
    
    
    /**
     * Move action and after action for pawn
     * @param Move $move
     * @param Desk $desk
     * @return AbstractFigure|Pawn
     */
    public function move(Move $move, Desk $desk) : AbstractFigure
    {
        //register first move
        $this->first_step=false;
        //check pawn respawn
        //when we get 1 or 8 we have other figure
        if($move->yTo == 1 or $move->yTo == 8){
            //output change
            $animated_output= new ConsoleAnimated\ConsoleAnimatedOutput();
            $animated_output->cursorUp();
            $animated_output->echoLine('Choose replace of pawn, type first letter of figure name:');
            unset($animated_output);
            //choose figure by first letter
            switch(trim(fgets(STDIN))){
                case('q'):
                case('Q'):
                    return new Queen($this->is_black);
                case('r'):
                case('R'):
                    return (new Rook($this->is_black))->fromPawn();
                case('K'):
                case('k'):
                    return new Knight($this->is_black);
                case('B'):
                case('b'):
                    return new Bishop($this->is_black);    
                default:
                    return new Queen($this->is_black);
            }
        }
        //"en passant" support
        if(!empty($this->desk_change)){
            //unset and check for fatal error
            if($desk->figureUnset($this->desk_change) === false){
                user_error('No figure in position, have to be there!', E_USER_ERROR);
            }
            //change clear
            $this->desk_change = [];
        }
        return parent::move($move, $desk);
        //
    }
    
    /**
     * Validate pawn move
     * @param Move $move move object
     * @param Desk $desk 
     * @see getLastMove // have to have for pawn attack "en passant" 
     * @link en.wikipedia.org/wiki/Pawn_(chess)#Capturing
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    { 
        //use for "en passant"
        $last_move = $desk->getLastMove();
        //get possible moves
        $this->countVacuumHorsePossibleMoves($move);
        //ckeck our normal move
        //for pawn move only 1 field move so check only closest
        foreach($this->normal as $val){
            if($val->strTo === $move->strTo and $desk->getFigurePrice($move->to) === Move::MOVING){
                return Move::MOVING;
            }
        }
        //direction of move flag for color
        if($this->is_black){
            $sign = 1;    
        }else{
            $sign = -1;    
        }
        //check spec move
        //field ahead have to be empty
        foreach($this->special as $val){
            if(
                $val->strTo === $move->strTo 
                and 
                $desk->getFigurePrice($move->to) === 0
                and 
                $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]) === 0
            ){
                return Move::MOVING;
            }
        }
        //ckeck our move like attack
        foreach($this->attack as $val){
            //check for ordinary attack
            if(
                $val->strTo === $move->strTo
                and 
                $desk->getFigurePrice($move->to) !== 0 
                and
                $desk->getFigureIsBlack($move->to) != $this->is_black     
            ){
                return $desk->getFigurePrice($move->to);
            }
            //check for attack "en passant"
            if(
                !empty($last_move)
                and
                $desk->getFigurePrice($last_move->to) == $this->price()
                and
                $desk->getFigureIsBlack($last_move->to) != $this->is_black    
                and
                abs($last_move->dY)==2
                and     
                $val->yFrom == $last_move->yTo
                and 
                $last_move->xFrom == $val->xTo    
            ){
                $this->desk_change = $last_move->to;
                return $desk->getFigurePrice([$move->xTo, ($move->yTo + $sign)]);
            }
        }
        //
        return Move::FORBIDDEN;
    }
    
    /**
     * Create array of all possible moves without other figures for pawn
     * @param Move $move
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function countVacuumHorsePossibleMoves(Move $move) : void 
    {
        //
        if(!empty($this->normal)){
            return;
        }
        //direction of move flag for color
        if($this->is_black){
            $sign = -1;    
        }else{
            $sign = 1;    
        }
        //straight move
        /** @see $this->move() overkill check */
        if($move->checkY(($move->yFrom + (1 * $sign)))){
            $this->normal[] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $sign));
        }
        //attack
        if($move->checkX($move->nextX())){
            $this->attack[] = new Move($move->strFrom, $move->nextX().($move->yFrom + $sign));
        }
        if($move->checkX($move->prevX())){
            $this->attack[] = new Move($move->strFrom, $move->prevX().($move->yFrom + $sign));
        }
        //special move
        if($this->first_step){
            $this->special[] = new Move($move->strFrom, $move->xFrom.($move->yFrom + (2 * $sign)));
        }
        //
    }
    
    /**
     * @inheritdoc
     * @return string
     */
    public function __toString() : string
    {
        return $this->is_black ? '♙' : '♟';
    }
}
