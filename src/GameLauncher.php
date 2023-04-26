<?php

use ConsoleAnimated\ConsoleAnimatedOutput;

/**
 * Description of Game
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class GameLauncher
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
     * @var NotationConverter
     */
    protected NotationConverter $notation;
    /**
     * Object desk to play
     * @var Desk desk to play on
     */
    protected Desk $desk;

    /**
     * game start
     * @throws Exception
     */
    public function __construct()
    {
        //new game init
        $this->init();
        //game action
        do {
            $input = trim(fgets(STDIN));
            //check for out or save or some other not move
            $this->controlActions($input);
            //moving
            foreach ($this->notation->process($input, $this->desk) as $key => $move) {
                //for multiple input moves we miss STDIN line so create empty
                if ($key > 0) {
                    $this->animated_output->echoEmptyLine();
                }
                //move output and desk move
                $this->moveAction($move);
            }
        } while (!empty($input));
    }

    /**
     * Init
     * create objects
     * prepare game space
     * @return void
     */
    public function init(): void
    {
        $this->animated_output = new ConsoleAnimated\ConsoleAnimatedOutput();
        $this->desk = new Desk();
        $this->notation = new NotationConverter();
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
            $this->desk->move(new Move($move));
            $this->animated_output->echoMultipleLine($this->desk->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        } catch (DeskConditionException $e) {
            $this->animated_output->echoMultipleLine($this->desk->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->echoLine($e->getMessage());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        } catch (EndGameException $e) {
            $this->animated_output->echoMultipleLine($this->desk->dump(), 1);
            $this->animated_output->deleteLine();
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($e->getMessage() );
            $this->animated_output->echoEmptyLine();
            exit(0);
        } catch (\Exception $e) {
            //do not save move and echo error message
            $this->animated_output->echoLine($this->mistake . $e->getMessage());
            $this->animated_output->cursorUp();
            $this->animated_output->echoLine($this->input_move);
        }
    }


}
