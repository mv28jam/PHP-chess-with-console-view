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
     * Saveloader object
     * @var Saveloader object for save or load
     * last game data
     */
    private $saveloader = null;
    
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
        $this->saveloader = new Saveloader();
        if (($last_game_data = $this->saveloader->loadLastGame()) && $this->wantToOpenLastGame()){
            $this->desk = new Desk($last_game_data);
        } else {
            $this->desk = new Desk();
        }
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
     * Ask to open last game if exists
     * @return bool
     */
    private function wantToOpenLastGame() : bool
    {
        $this->animated_output->echoLine("Do you want to load last game? [Yes/no]: ");
        $input = strtolower(trim(fgets(STDIN)));
        switch($input){
            case('yes'):
            case('y'):
                return true;
            default:
                return false;
        }
    }

    /**
     * Ask to save game progress
     * @return bool
     */
    private function wantToSaveGame() : bool
    {
        $this->animated_output->echoLine("Do you want to save game progress? [Yes/no]: ");
        $input = strtolower(trim(fgets(STDIN)));
        switch($input){
            case('yes'):
            case('y'):
                return true;
            default:
                return false;
        }
    }

    /**
     * exit the game
     * @return void
     */
    public function gameExit() : void
    {
        if($this->wantToSaveGame()) {
            $this->saveloader->saveLastGame($this->desk);
        }
        exit(0);
    }
}
