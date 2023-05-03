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
     * @return string
     * @throws Exception
     */
    public function makeMove(string $in) : string
    {
        $info = '';
        //moving
        foreach ($this->notation->process($in, $this->desk) as $move) {
            //move output and desk move
            $info = $this->desk->move(new Move($move));
        }
        //
        return $info;
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

    /**
     * @return string
     */
    public function getMovesRecord(){
        return $this->desk->getMoveHistory();
    }

}