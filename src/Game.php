<?php

/**
 * Description of Game
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Game {
    
    /**
     * Game quit symbol
     */
    const QUIT = 'q';
    /**
     * Move delimiter
     */
    const DELIMITER = '|';
    
    /**
     * Output messages
     */
    protected $input_move='Input move:';
    protected $mistake='Mistake: ';
    /**
     * Object to animate output
     * @var ConsoleAnimatedOutput object holder
     */
    protected $animated_output = null;
    /**
     * Object desk to play
     * @var Desk desk to play on
     */
    protected $desk = null;
    
    /**
     * game start
     */
    public function __construct()
    {
        //new game init
        $this->init();
        //game action
        do{
            $input = trim(fgets(STDIN));
            //check for out or save or some other not move
            $this->controlActions($input);
            //explode moves b2-b4|g7-g5
            $input = explode(self::DELIMITER, $input);
            //moving  
            foreach($input as $key => $move){
                //for multiple input moves we miss STDIN line so create empty
                if($key > 0){
                    $this->animated_output->echoEmptyLine();
                }
                //move output and desk move
                $this->moveAction($move);
            }
        }while(!empty($input));
    }

    /**
     * Move actions
     * @param string $move
     * @return void
     * @throws Exception
     */
    public function moveAction(string $move) : void
    {
        try {    
            $this->desk->move(new Move($move));
            $this->animated_output->echoMultipleLine($this->desk->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);    
        } 
        catch (EndGameException $e) {
            $this->animated_output->echoLine($e->getMessage().(new Move($move)));
            $this->animated_output->echoEmptyLine();
            exit(0);
        }    
        catch (\Exception $e) {
            //do not save move and echo error message
            $this->animated_output->echoLine($this->mistake.$e->getMessage());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);   
        }
    }

    /**
     * Init 
     * create objects
     * prepare game space
     * @return void
     */
    public function init() : void
    {
        $this->animated_output= new ConsoleAnimated\ConsoleAnimatedOutput();
        $this->desk = new Desk();
        //prepare output space
        $this->animated_output->echoMultipleLine($this->desk->dump(), -1);
        $this->animated_output->echoEmptyLine();
        $this->animated_output->cursorUp();
        $this->animated_output->echoLine($this->input_move);
    }
    
    /**
     * Check input for control strings
     * @param string $move from STDIN
     * @return void
     */
    protected function controlActions(string $move) : void
    {
        switch($move){
            case(self::QUIT):
            case('exit'):
            case('quit'):
            case('die'):    
                $this->gameExit();
                break;
        }
    }
    
    /**
     * exit the game
     * @return void
     */
    public function gameExit() : void
    {
        exit(0);
    }
    
    
    
}
