<?php

/**
 * Description of Move
 *
 * @author mv28jam <mv28jam@yandex.ru>
 * 
 * @property-read array $from move from
 * @property-read array $to move to 
 * @property-read string $strFrom move from string
 * @property-read string $strTo move to string
 * @property-read string $xFrom move from
 * @property-read int $yFrom move from
 * @property-read string $xTo move to 
 * @property-read int $yTo move to
 * @property-read int $dX delta of move
 * @property-read int $dY delta of move
 * 
 */
class Move {
    
    /**
     * Move without attack
     */
    const MOVING = 0;
    /**
     * Forbidden move
     */
    const FORBIDDEN = -1;
    
    /**
     * @var array $start
     * where is figure  
     */
    protected $start = [];
     /**
     * @var array $stop
     * where to go  
     */
    protected $stop = [];
    /**
     * Delta of move
     * @var int 
     */
    protected $deltaX = 0;
    protected $deltaY = 0;
    protected static $move_delimeter = '-';
    
    
    /**
     * @param string $move like e2-e4
     * @param string $move_exploded end of move like e4 and $move like e2
     * @throws \Exception
     */
    public function __construct(string $move, string $move_exploded = '') 
    {
        //
        if(!empty($move_exploded)){
            $move = implode(self::$move_delimeter, [$move, $move_exploded]);
        }
        //check matching for std string move
        if (!preg_match('/^([a-h])([1-8])'.self::$move_delimeter.'?([a-h])([1-8])$/', $move, $match)) {
            throw new \Exception("Incorrect notation. Use e2-e4.");
        }
        //
        $this->start[] = $match[1];
        $this->start[] = $match[2];
        $this->stop[] = $match[3];
        $this->stop[] = $match[4];
        //
        if($this->start == $this->stop){
            throw new \Exception("No move");
        }
        //create delta of move
        $this->deltaX = ord($this->start[0]) - ord($this->stop[0]);
        $this->deltaY = $this->start[1] - $this->stop[1];
    }
    
    /**
     * Simple access to move
     * @param string $name
     * @return mixed 
     */
    public function __get(string $name){
        $start = $this->getStart();
        switch($name){
            case('from'):
                return $this->getStart();
            case('to'):
                return $this->getStop();
            case('strFrom'):
                return implode('',$this->getStart());
            case('strTo'):
                return implode('',$this->getStop());    
            case('xFrom'):
                return $start[0];
            case('xTo'):
                return $this->getStop()[0];
            case('yFrom'):
                return $this->getStart()[1];
            case('yTo'):
                return $this->getStop()[1];
            case('dX'):
                return $this->deltaX;    
            case('dY'):
                return $this->deltaY;        
        }
        //
        user_error('Undefined property in '.__METHOD__.' : ' . $name, E_USER_ERROR);
        return null;
    }
    
    /**
     * Increment char self::xFrom not by link
     * @param int $step shith on
     * @return string
     */
    public function nextX(int $step = 1): string
    {
         return chr(ord($this->xFrom) + $step);
    }
    
    /**
     * Decrement char self::xFrom not by link
     * @param int $step shith on
     * @return string
     */
    public function prevX(int $step = 1): string
    {
        return chr(ord($this->xFrom) - $step);
    }
    
    /**
     * Check for first component of move
     * @param string $in move first letter
     * @return boolean
     */
    public function checkX(string $in): bool
    {
        if(ord($in) > 96 and ord($in) < 105){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Check for second component of move
     * @param int $in move second number
     * @return boolean
     */
    public function checkY(int $in) : bool
    {
        if($in > 0 and $in < 9){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check X and Y
     * @param string $x move first letter
     * @param int $y move second number
     * @return bool
     */
    public function checkXY(string $x, int $y) : bool{
        return ($this->checkX($x) and $this->checkY($y));
    }
    
    /**
     * Return move from
     * @return array
     */
    public function getStart(): array
    {
        return $this->start;
    }
    
    /**
     * Return move to
     * @return array
     */
    public function getStop(): array
    {
        return $this->stop;
    }
    
    /**
     * Get X position of figure like Y(1-8)
     * Sorry
     * @return int
     */
    public function getXLikeY(string $in): int
    {
        return (105-ord($in));
    }
    
    /**
     * To string
     * @return string
     */
    public function __toString() : string {
        return $this->strFrom.self::$move_delimeter.$this->strTo;
    }
    
}
