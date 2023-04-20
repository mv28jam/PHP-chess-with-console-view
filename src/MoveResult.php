<?php

class MoveResult
{
    /**
     * Initial move
     * @var AbstractFigure
     */
    protected AbstractFigure $figure;

    /**
     * @var Move
     */
    protected Move $move;

    /**
     * @return AbstractFigure
     */
    public function getFigure(): AbstractFigure
    {
        return $this->figure;
    }

    /**
     * @param AbstractFigure $figure
     * @return MoveResult
     */
    public function setFigure(AbstractFigure $figure): MoveResult
    {
        $this->figure = $figure;
        return $this;
    }

    /**
     * @return Move
     */
    public function getMove(): Move
    {
        return $this->move;
    }

    /**
     * @param Move $move
     * @return MoveResult
     */
    public function setMove(Move $move): MoveResult
    {
        $this->move = $move;
        return $this;
    }
    
}