<?php

class MoveResult
{
    /**
     * Initial move
     * @var Move
     */
    protected AbstractFigure $figure;

    /**
     * Kill in not in To position
     * @var array
     */
    protected array $kill = [];

    /**
     * Figures to move not in From To
     * @var array
     */
    protected array $transfer = [];

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
     * @return array
     */
    public function getKill(): array
    {
        return $this->kill;
    }

    /**
     * @param array $kill
     * @return MoveResult
     */
    public function setKill(array $kill): MoveResult
    {
        $this->kill[] = $kill;
        return $this;
    }

    /**
     * @return array
     */
    public function getTransfer(): array
    {
        return $this->transfer;
    }

    /**
     * @param array $transfer
     * @return MoveResult
     */
    public function setTransfer(array $transfer): MoveResult
    {
        $this->transfer[] = $transfer;
        return $this;
    }



}