<?php

/**
 * AbstractFigure abstract 
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
abstract class AbstractFigure {
    
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
     * All figure possible moves, сlean after $this->move()
     * @see $this->cleanMoves() 
     * @var array of Moves
     */
    protected $moves = [];
    /**
     * Ordinary moves 
     * @var array of moves 
     */
    public $normal = [];
    /**
     * Attack special figure moves (for pawn)
     * @var array of moves 
     */
    public $attack = [];
    /**
     * Special figure moves
     * @var array of moves 
     */
    public $special = [];
    
    
    /**
     * Check move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move @see Move
     */
    abstract public function checkFigureMove(Move $move, Desk $desk) : int;
    
    /**
     * Count list of possible moves from position start
     * \except simple limitation - NOT desk depended moves 
     * \simple limitation like "first move"
     * @param array $move - start position
     */
    abstract public function countVacuumHorsePossibleMoves(Move $move) : void;
    
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
        //add move to hitory
        $this->moves[] = $move;
        //clean counted
        $this->cleanMoves();
        //
        return $this;
    }
    
    /**
     * Get list of possible moves from position start
     * \except simple limitation - NOT desk depended moves 
     * \simple limitation like "first move"
     * @param array $move - start position
     * @return array of Move 
     */
    public function getVacuumHorsePossibleMoves(Move $move) : array {
        $this->countVacuumHorsePossibleMoves($move);
        return array_merge($this->attack, $this->normal, $this->special);
    }
    
    /**
     * Check for self attack (white goto white etc)
     * Has not used for pawn
     * @param Move $move
     * @param Desk $desk
     * @return bool
     */
    public function checkSelfAttack(Move $move, Desk $desk) : bool
    {
        if($desk->isFigureExists($move->to)){
            return ($desk->getFigureIsBlack($move->to) === $this->is_black);
        }
        return false;    
    }
    
    /**
     * Clean counted moves after actual moving
     */
    public function cleanMoves() : void
    {
        $this->attack = [];
        $this->normal = [];
        $this->special = [];
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
    
    /**
     * Unset figure
     */
    public function killFigure() : void {
        
    }
}
