<?php

/**
 * Dummy move for internal use
 * like
 * @see AbstractFigure::getVacuumHorsePossibleMoves()
 */
class DummyMove extends Move
{

    /**
     * @param string $move like e2-e4
     * @param string $move_exploded end of move like e4 and $move like e2
     * @throws Exception
     */
    public function __construct(string $move, string $move_exploded = '')
    {
        //check matching for std string move
        if (!preg_match('/^([a-h])([1-8])$/', $move, $match)) {
            throw new Exception("Incorrect notation fro dummy move. Use e2.");
        }
        //
        $this->start[] = $match[1];
        $this->start[] = $match[2];
        $this->stop[] = $match[1];
        $this->stop[] = $match[2];
        //create delta of move
        $this->deltaX = ord($this->start[0]) - ord($this->stop[0]);
        $this->deltaY = $this->start[1] - $this->stop[1];
    }

}