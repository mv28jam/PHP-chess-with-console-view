<?php

/**
 * Desk of game
 * 
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Desk {
    /**
     * array of figures on desk
     * @var array \Figures 
     */
    private $figures = [];
    /**
     * Last move flag, first move white so true
     * @var bool $last_move previous move 
     * @see \AbstractFigure::$is_black
     */
    private $last_move = true;
    /**
     * Move objects - history of game
     * @var array $moves - all game moves
     */
    private $moves = [];
    
    /**
     * Create chess game desk
     * Set figures 
     */
    public function __construct() {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }

    /**
     * Move of figure 
     * @param Move $move
     * @throws \Exception
     */
    public function move(Move $move) 
    {
        //rewind moves
        end($this->moves);
        //checks
        switch(true){
            case(!$this->checkFigureExists($move->getStart())):
                throw new \Exception('No figure in position');
            case(!$this->moveOrder($move)):
                throw new \Exception('Other color moves - '.(new Pawn(!$this->last_move)));
            case($this->figures($move->from)->checkFigureMove(
                    $move, 
                    $this->toMap(), 
                    (current($this->moves) ? current($this->moves) : null)) < 0
                ):
                throw new \Exception('Forbidden move for '.$this->figures($move->getStart()));
        }
        //save move
        $this->moves[] = $move;
        //move to new position + internal figure actions
        $this->figures[$move->to[0]][$move->to[1]] = $this->figures($move->from)->move($move, $this);
        //move order set
        $this->last_move = $this->figures[$move->to[0]][$move->to[1]]->getIsBlack();
        //unset figure in old position
        unset($this->figures[$move->from[0]][$move->from[1]]);
    }
    
    /**
     * Get figure in position
     * @param array $position
     * @return \Figure
     */
    public function figures(array $position) :AbstractFigure 
    {
        return $this->figures[$position[0]][$position[1]];        
    }
    
    /**
     * Unset figure in position
     * @param array $position like "e5"
     * @return bool
     */
    public function figureUnset(array $position) :bool 
    {
        if($this->checkFigureExists($position)){
            unset($this->figures[$position[0]][$position[1]]);
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Check for figure in position
     * @param array $position
     * @return bool
     */
    public function checkFigureExists(array $position) :bool 
    {
        return isset($this->figures[$position[0]][$position[1]]) ? true : false;
    }
    
    /**
     * Check for move order white-black-white...
     * @param Move $move
     * @return bool true if order is right false if no
     */
    protected function moveOrder(Move $move) :bool 
    { 
        if(
            $this->last_move === $this->figures[$move->from[0]][$move->from[1]]->getIsBlack()
        ){
            return false;
        }else{
            return true;
        }
    }
    
    /**
     * Create array of lines echo
     * @return array output
     */
    public function dump() :array 
    {
        $result = [];
        //
        for ($y = 8; $y >= 1; $y--) {
            $result[$y] = "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    $result[$y] .= $this->figures[$x][$y].' ';
                } else {
                    $result[$y] .= '― ';
                }
            }
        }
        $result[] = "  a b c d e f g h\n";
        //
        return $result;
    }
    
    /**
     * Return map of desk like figure price array
     * @return array
     */
    public function toMap() :array {
        $result=[];
        //
        for ($y = 8; $y >= 1; $y--) {
            for ($x = 'a'; $x <= 'h'; $x++) {
                $result[$x][$y] = (isset($this->figures[$x][$y]) ? $this->figures[$x][$y]->price() : false);
            }
        }
        //
        return $result;
    }
}
