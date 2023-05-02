<?php

use ConsoleAnimated\ConsoleAnimatedOutput;
use opponent\NoOpponent;
use opponent\OpponentInterface;
use opponent\RandomOpponent;

/**
 * Console game launcher
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class GameConsoleLauncher
{

    /**
     * Game quit symbol
     */
    const QUIT = 'q';

    /**
     * Output messages
     */
    protected string $input_move = 'Input move:';
    protected string $mistake = 'Mistake: ';
    /**
     * Object to animate output
     * @var ConsoleAnimatedOutput object holder
     */
    protected ConsoleAnimatedOutput $animated_output;
    /**
     * @var Game
     */
    protected Game $game;
    /**
     * @var OpponentInterface
     */
    protected OpponentInterface $opponent;


    /**
     * game start
     * @throws Exception
     */
    public function __construct()
    {
        //new game init
        $this->init();
        //
        $this->opponent = $this->chooseOpponent($this->chooseColor());
        //prepare output space
        $this->animated_output->echoMultipleLine($this->game->desc()->dump(), -1);
        $this->animated_output->echoEmptyLine();
        $this->animated_output->cursorUp();
        $this->animated_output->echoLine($this->input_move);
        //game
        $this->gameProcess();
    }

    /**
     * Init
     * create objects
     * prepare game space
     * @return void
     * @throws Exception
     */
    public function init(): void
    {
        $this->animated_output = new ConsoleAnimated\ConsoleAnimatedOutput();
        $this->game = new Game();
    }

    /**
     * Process game with opponent
     * @return void
     */
    public function gameProcess(): void
    {
        do {
            //opponent move
            if($this->opponent->can($this->game->desc()->getOrderColor())){
                $input = $this->opponent->opMove($this->game->desc());
                //have to draw empty line instead of STDIN
                $this->animated_output->echoEmptyLine();
            }else {
                $input = trim(fgets(STDIN));
                //check for out or save or some other not move
                $this->controlActions($input);
            }
            //
            $this->moveAction($input);
                //
        } while (true);
    }

    /**
     * Move actions
     * @param $move
     * @return void
     */
    public function moveAction($move): void
    {
        try {
            $this->game->makeMove($move);
            $this->animated_output->echoMultipleLine($this->game->desc()->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        } catch (DeskConditionException $e) {
            $this->animated_output->echoMultipleLine($this->game->desc()->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->echoLine($e->getMessage());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        } catch (EndGameException $e) {
            $this->animated_output->echoMultipleLine($this->game->desc()->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($e->getMessage() );
            $this->animated_output->echoEmptyLine();
            exit(0);
        } catch (\MoveValidationException $e) {
            $this->animated_output->echoLine($e->getMessage().$this->game->notation()->info());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        } catch (\Exception $e) {
            //do not save move and echo error message
            $this->animated_output->echoLine($this->mistake . $e->getMessage());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        }
    }

    /**
     * Choose color
     * sry for realisation - tired of frontend
     * @return bool
     */
    public function chooseColor(): bool
    {
        $color_sym = ['w', 'b'];
        $it=0;
        do {
            if ($it) {
                $this->animated_output->cursorUp();
                $this->animated_output->deleteLine();
            }
            $this->animated_output->echoLine('Type w for white, b for black : ');
            $color = trim(fgets(STDIN));
            $it++;
        }while (!in_array($color, $color_sym));
        //
        return $color == $color_sym[0] ? Desk::COLOR_WHITE : Desk::COLOR_BLACK;
    }

    public function chooseOpponent(bool $color): OpponentInterface
    {
        $it = 0;
        $opponents = [new NoOpponent($color), new RandomOpponent($color)];
        $output[] = 'Select opponent type:';
        foreach($opponents as $key => $val){
            $output[] = $key.' - '.$val->opName();
        }
        //
        do {
            if($it){
                $this->animated_output->cursorUp();
                $this->animated_output->deleteLine();
            }
            $this->animated_output->echoMultipleLine($output,-1);
            $this->animated_output->echoLine('Number: ');
            $key = trim(fgets(STDIN));
            $it++;
        }while (!in_array($key, array_keys($opponents)));
        //
        return $opponents[$key];
    }

    /**
     * Check input for control strings
     * @param string $move from STDIN
     * @return void
     */
    protected function controlActions(string $move): void
    {
        switch ($move) {
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
    public function gameExit(): void
    {
        exit(0);
    }


}
