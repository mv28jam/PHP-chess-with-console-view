<?php

use ConsoleAnimated\ConsoleAnimatedOutput;
use opponent\NoOpponent;
use opponent\OpponentInterface;

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
        //prepare output space
        $this->animated_output->echoMultipleLine($this->game->desc()->dump(), -1);
        $this->animated_output->echoEmptyLine();
        $this->animated_output->cursorUp();
        $this->animated_output->echoLine($this->input_move);
        //game action
        do {
            $input = trim(fgets(STDIN));
            //check for out or save or some other not move
            $this->controlActions($input);
            //moving
           $this->moveAction($input);
        } while (true);
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
        $this->opponent =new NoOpponent(true);
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

    /**
     * Move actions
     * @param string $move
     * @return void
     * @throws Exception
     */
    public function moveAction(string $move): void
    {
        try {
            if($this->opponent->can($this->game->desc()->getOrderColor())){
                $this->game->makeMove($this->opponent->opMove($this->game->desc()));
            }else{
                $this->game->makeMove($move);
            }
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


}
