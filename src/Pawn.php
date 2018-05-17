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
     * Move action and after action
     * @param \Move $move
     * @param \Desk $desk
     * @return \AbstractFigure|\Pawn
     */
    public function move(Move $move, Desk $desk)
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
        //
        return $this;
    }
    
    /**
     * Validate for pawn move 
     * @param \Move $move move of figure
     * @param array $desk desk mask
     * @param \Move $last_move last move in game
     * @return int return some price
     */
    public function checkFigureMove(Move $move, array $desk, Move $last_move=null) : int 
    { 
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //ckeck our normal move
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo and $desk[$move->xTo][$move->yTo]===false){
                return 0;
            }
        }
        //check spec move
        if($this->is_black){
            $sign = 1;    
        }else{
            $sign = -1;    
        }
        foreach($moves[self::SPECIAL] as $val){
            if(
                $val->strTo === $move->strTo 
                and 
                $desk[$move->xTo][$move->yTo]===false
                and 
                $desk[$move->xTo][$move->yTo + $sign]===false    
            ){
                return 0;
            }
        }
        //ckeck our move like attak
        foreach($moves[self::ATTAK] as $val){
            //check for ordinary attak
            if($val->strTo === $move->strTo and $desk[$move->xTo][$move->yTo]!==false){
                return $desk[$move->xTo][$move->yTo];
            }
            //check for attak "en passant"
            if(
                !empty($last_move)
                and
                $desk[$last_move->xTo][$last_move->yTo] == $this->price()    
                and
                abs($last_move->dY)==2
                and     
                $val->yFrom == $last_move->yTo
                and 
                $last_move->xFrom == $val->xTo    
            ){
                $this->desk_change['unset'][] = $last_move->to;
                return $desk[$move->xTo][$move->yTo+$sign];
            }
        }
        //
        return -1;
    }
    
    /**
     * Create array of all possible moves without other figures
     * @param \Move $move
     * @return array of array of strings - second part of move, like "e4"
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array 
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //move destination
        if($this->is_black){
            $sign = -1;    
        }else{
            $sign = 1;    
        }
        //straight move
        /** @see $this->move() overkill check */
        if($move->checkY(($move->yFrom + (1 * $sign)))){
            $result[self::NORMAL][] = new Move($move->strFrom.'-'.$move->xFrom.($move->yFrom + $sign));
        }
        //attak
        if($move->checkX($move->nextX())){
            $result[self::ATTAK][] = new Move($move->strFrom.'-'.$move->nextX().($move->yFrom + $sign));
        }
        if($move->checkX($move->prevX())){
            $result[self::ATTAK][] = new Move($move->strFrom.'-'.$move->prevX().($move->yFrom + $sign));
        }
        //special move
        if($this->first_step){
            $result[self::SPECIAL][] = new Move($move->strFrom.'-'.$move->xFrom.($move->yFrom + (2 * $sign)));
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
