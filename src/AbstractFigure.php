<?php

/**
 * AbstractFigure abstract 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
abstract class AbstractFigure {
    
    //moves group names
    const NORMAL = 'normal';
    const ATTAK = 'attack';
    const SPECIAL = 'special';
    
    /**
     * Black or white figure
     * @var type 
     */
    protected $is_black = false;
    /**
     * Abstract price of figure to automatic game
     * @var int 
     */
    protected $price = PHP_INT_MAX;
    /**
     * Changes to desk commit with move, but not straight attack or move
     * @var array description below
     *  'unset' => ['e2'] - unset figure in position
     *  'set' => ['e2'=>'e4'] - set figures from position key to to position value
     */
    protected $desk_change = ['unset' => [], 'set' => []];
    
    /**
     * Create of figure with color determinate
     * @param boolean $is_black
     */
    public function __construct(bool $is_black) 
    {
        $this->is_black = $is_black;
    }
    
    /**
     * Return some ktulhu figure price
     * @return int price
     */
    public function price() :int
    {
        return $this->price;
    }
    
    /**
     * Check black or white
     * @return bool
     */
    public function getIsBlack() :bool 
    {
        return $this->is_black;
    }
    
    /**
     * Move figure finally + internal actions
     * @param Move $move move object
     * @param Desk $desk 
     * @return AbstractFigure instanceof 
     */
    public function move(Move $move, Desk $desk)
    {
        return $this;
    }
    
    /**
     * Get list of possible moves from position start
     * @param array $start - start position
     * @return array of arrays of Move with keys 
     *  ['normal'] => ordinary moves 
     *  ['attack'] => attack figure moves
     *  ['special'] => special figure moves
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        return [self::NORMAL => [], self::ATTAK => [], self::SPECIAL => []];
    }
    
    /**
     * Check move
     * @param Move $move move object
     * @param array $desk map of desk
     * @param Move $last_move last move of any figure // have to have for pawn attack "en passant" @see en.wikipedia.org/wiki/Pawn_(chess)#Capturing
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move
     */
    abstract public function checkFigureMove(Move $move, array $desk, Move $last_move=null) :int ;
    
    /**
     * return figure symbol
     */
    abstract public function __toString();
}
