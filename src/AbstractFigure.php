<?php

/**
 * AbstractFigure abstract 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
abstract class AbstractFigure {
    
    /**
     * moves group names
     */
    const NORMAL = 'normal';
    const ATTAK = 'attack';
    const SPECIAL = 'special';
    
    /**
     * Black or white figure
     * @var boolean 
     */
    protected $is_black = false;
    /**
     * Abstract price of figure to automatic game
     * @var int 
     */
    protected $price = 0;
    /**
     * All figure moves
     * @var array of Moves
     */
    protected $moves = [];
    
    
    /**
     * Check move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move @see Move
     */
    abstract public function checkFigureMove(Move $move, Desk $desk) : int;
    
    /**
     * Return symbol of figure
     * @return string figure symbol
     */
    abstract public function __toString() : string;
    
    /**
     * Create of figure with color determinate
     * @param boolean $is_black
     */
    public function __construct(bool $is_black) 
    {
        $this->is_black = $is_black;
    }
    
    /**
     * Move figure finally + internal actions
     * @param Move $move move object
     * @param Desk $desk 
     * @return AbstractFigure 
     */
    public function move(Move $move, Desk $desk) : AbstractFigure
    {
        $this->moves[] = $move; 
        return $this;
    }
    
    /**
     * Check horizontal or vertical move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move @see Move
     */
    public function checkHorizontalVerticalMove(Move $move, Desk $desk) : int 
    {
        //horiz or vertical move
        if($move->dY > 0){
            
        }else{
            
        }
        return Move::FORBIDDEN;
    }
    
    /**
     * Check diagonal move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move 
     * @see Move
     */
    public function checkDiagonalMove(Move $move, Desk $desk) : int 
    {
        return Move::FORBIDDEN;
    }
    
     /**
     * Get list of possible moves from position start
     * @param array $move - start position
     * @return array of arrays of Move with keys 
     *  ['normal'] => ordinary moves 
     *  ['attack'] => attack special figure moves (for pawn)
     *  ['special'] => special figure moves
     */
    public function getVacuumHorsePossibleMoves(Move $move) : array
    {
        return [self::NORMAL => [], self::ATTAK => [], self::SPECIAL => []];
    }
    
    /**
     * Return some ktulhu figure price
     * @return int price
     */
    public function price() : int
    {
        return $this->price;
    }
    
    /**
     * Check black or white
     * @return bool
     */
    public function getIsBlack() : bool 
    {
        return $this->is_black;
    }
    
}
