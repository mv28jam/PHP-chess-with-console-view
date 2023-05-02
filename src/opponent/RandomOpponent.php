<?php

namespace opponent;

use Desk;
use DummyMove;
use Move;

/**
 * Opponent makes random moves
 * Dummy opponent
 */
class RandomOpponent implements OpponentInterface
{

    /**
     * Color of opponent
     * @var bool
     */
    private bool $is_black;


    /**
     * @inheritDoc
     */
    public function __construct(bool $color)
    {
        $this->is_black = $color;
    }

    /**
     * @inheritDoc
     */
    public function color(): bool
    {
        return $this->is_black;
    }

    /**
     * @throws \Exception
     */
    public function opMove(Desk $desk): string
    {
        $moves = [];
        //
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if($val->is_black === !$this->is_black and !empty($val->fig)){
                    $fig = $desk->getFigureClone([$keyH,$keyG]);
                    foreach($fig->getVacuumHorsePossibleMoves(new DummyMove(implode([$keyH,$keyG])),true) as $pmove) {
                        if(!$desk->condition->selfAttackAbstractMove($pmove, $desk) and $desk->condition->checkFigureMove($pmove, $fig, $desk) > Move::FORBIDDEN){
                            $moves[] = $pmove;
                        }
                    }
                }
            }
        }
        //
        return $moves[mt_rand(0,(count($moves)-1))];
    }

    /**
     * @inheritDoc
     */
    public function can(bool $color): bool
    {
        return ($this->color() == $color);
    }

    public function opName(): string
    {
        return 'Random move by opponent only.';
    }
}