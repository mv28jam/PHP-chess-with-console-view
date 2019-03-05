<?php

/**
 * Pawn actions and behavior
 * "en passant" move example b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3
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
     * Abstract price of figure to automatic game
     * @var int 
     */
    protected $price = 1;
    /**
     * Changes to desk commit with "en passant" move
     * @var array descr below
     *  'unset' => ['e2'] - unset figure in position
     *  'set' => ['e2'=>'e4'] - set figures from position key to to position value
     */
    protected $desk_change = ['unset' => [], 'set' => []];
    
    
    /**
     * Move action and after action for pawn
     * @param Move $move
     * @param Desk $desk
     * @return AbstractFigure|Pawn
     */
    public function move(Move $move, Desk $desk) :AbstractFigure
    {
        parent::move($move, $desk);
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
                    return new Rook($this->is_black);
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
        foreach($this->desk_change['unset'] as $val){
            $desk->figureUnset($val);
        }
        //emptying unset array 
        $this->desk_change['unset']=[];
        //
        return $this;
    }
    
    /**
     * Validate pawn move
     * @param Move $move move object
     * @param array $desk map of desk
     * @param Move $last_move last move of any figure // have to have for pawn attack "en passant" @see en.wikipedia.org/wiki/Pawn_(chess)#Capturing
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    { 
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //ckeck our normal move
        //for pawn move only 1 field move so check only closest
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo and $desk[$move->xTo][$move->yTo]->price===false){
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
        foreach($moves[self::SPECIAL] as $val){
            if(
                $val->strTo === $move->strTo 
                and 
                $desk[$move->xTo][$move->yTo]->price===false
                and 
                $desk[$move->xTo][$move->yTo + $sign]->price===false    
            ){
                return Move::MOVING;
            }
        }
        //ckeck our move like attak
        foreach($moves[self::ATTAK] as $val){
            //check for ordinary attak
            if(
                $val->strTo === $move->strTo
                and 
                $desk[$move->xTo][$move->yTo]->price !== false 
                and
                $desk[$move->xTo][$move->yTo]->is_black != $this->is_black     
            ){
                return $desk[$move->xTo][$move->yTo]->price;
            }
            //check for attak "en passant"
            if(
                !empty($last_move)
                and
                $desk[$last_move->xTo][$last_move->yTo]->price == $this->price()
                and
                $desk[$move->xTo][$move->yTo]->is_black != $this->is_black    
                and
                abs($last_move->dY)==2
                and     
                $val->yFrom == $last_move->yTo
                and 
                $last_move->xFrom == $val->xTo    
            ){
                $this->desk_change['unset'][] = $last_move->to;
                return $desk[$move->xTo][$move->yTo+$sign]->price;
            }
        }
        //
        return Move::FORBIDDEN;
    }
    
    /**
     * Create array of all possible moves without other figures for pawn
     * @param Move $move
     * @return array of array of Move 
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array 
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //direction of move flag for color
        if($this->is_black){
            $sign = -1;    
        }else{
            $sign = 1;    
        }
        //straight move
        /** @see $this->move() overkill check */
        if($move->checkY(($move->yFrom + (1 * $sign)))){
            $result[self::NORMAL][] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $sign));
        }
        //attak
        if($move->checkX($move->nextX())){
            $result[self::ATTAK][] = new Move($move->strFrom, $move->nextX().($move->yFrom + $sign));
        }
        if($move->checkX($move->prevX())){
            $result[self::ATTAK][] = new Move($move->strFrom, $move->prevX().($move->yFrom + $sign));
        }
        //special move
        if($this->first_step){
            $result[self::SPECIAL][] = new Move($move->strFrom, $move->xFrom.($move->yFrom + (2 * $sign)));
        }
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     * @return string
     */
    public function __toString() 
    {
        return $this->is_black ? '♙' : '♟';
    }
}
