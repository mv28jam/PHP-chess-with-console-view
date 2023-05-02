<?php

/**
 *
 */
class Game
{
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
        //
        $this->desk = new Desk();
        $this->notation = new NotationConverter();
        //
    }

    /**
     * game start
     * @param $in string clean in
     * @return bool
     * @throws Exception
     */
    public function makeMove(string $in) : bool
    {
        //moving
        foreach ($this->notation->process($in, $this->desk) as $move) {
            //move output and desk move
            $this->desk->move(new Move($move));
        }
        //
        return true;
    }

    /**
     * @return Desk
     */
    public function desc(): Desk
    {
        return clone $this->desk;
    }

    /**
     * @return NotationConverter
     */
    public function notation(): NotationConverter
    {
        return $this->notation;
    }

}