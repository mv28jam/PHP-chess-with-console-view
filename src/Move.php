<?php

/**
 * Description of Move
 *
 * @author mv28jam
 * 
 * @property-read array $from move from
 * @property-read array $to move to 
 * @property-read string $strFrom move from string
 * @property-read string $strTo move to string
 * @property-read string $xFrom move from
 * @property-read string $yFrom move from
 * @property-read string $xTo move to 
 * @property-read string $yTo move to 
 * @property-read int $dX delta of move
 * @property-read int $dY delta of move
 * 
 */
class Move {
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
    
    /**
     * @param string $move like e2-e4
     * @throws \Exception
     */
    public function __construct(string $move) 
    {
        if (!preg_match('/^([a-h])([1-8])-?([a-h])([1-8])$/', $move, $match)) {
            throw new \Exception("Incorrect move");
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
    public function __get($name){
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
        trigger_error('Undefined property in '.__METHOD__.' : ' . $name, E_USER_ERROR);
        return null;
    }
    
    /**
     * Increment char self::xFrom not by link
     * @return string
     */
    public function nextX(){
         return chr(ord($this->xFrom) + 1);
    }
    
    /**
     * Decrement char self::xFrom not by link
     * @return string
     */
    public function prevX(){
        return chr(ord($this->xFrom) - 1);
    }
    
    /**
     * Check for first component of move
     * @param string $in move first letter
     * @return boolean
     */
    public function checkX(string $in){
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
    public function checkY(int $in){
        if($in > 0 and $in < 9){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Return move from
     * @return array
     */
    public function getStart(){
        return $this->start;
    }
    
    /**
     * Return move to
     * @return array
     */
    public function getStop(){
        return $this->stop;
    }
    
}
