<?php

namespace opponent;

use Desk;
use DummyMove;
use Exception;
use Move;

/**
 * Price simple opponent
 */
class PriceOpponent extends RandomOpponent implements OpponentInterface
{

    /**
     * @throws Exception
     */
    public function opMove(Desk $desk): string
    {
        $moves = $this->collectMoves($desk);
        //sort by price of attacked figure
        usort ($moves , function ($a, $b) {
            if(($a[0]->respawn > $b[0]->respawn) or $a[0]->respawn=='q') return true;
            return $a[1]>$b[1];
        });
        //
        if($moves[0][1] > 0 or $moves[0][0]->respawn){
            return $moves[0][0];
        }
        //
        return $moves[mt_rand(0,(count($moves)-1))][0];
    }

    /**
     * Collect moves with price
     * @param Desk $desk
     * @return array[][]
     * @throws Exception
     */
    protected function collectMoves(Desk $desk) : array {
        $moves = [];
        //
        foreach ($desk->toMap() as $keyH => $line){
            foreach ($line as $keyG => $val) {
                if($val->is_black === $this->is_black and !empty($val->fig)){
                    $fig = $desk->getFigureClone([$keyH,$keyG]);
                    foreach($fig->getVacuumHorsePossibleMoves(new DummyMove(implode([$keyH,$keyG])),true) as $pmove) {
                        if(
                            !$desk->condition->selfAttackAbstractMove($pmove, $desk)
                        ){
                            $price = $desk->condition->checkFigureMove($pmove, $fig, $desk);
                            if(
                                $price > Move::FORBIDDEN
                                and
                                !$desk->condition->isKingUnderAttackAfterMove($pmove, $this->is_black, $desk)
                            ){
                                $moves[] = [$pmove, $price, $fig->price()];
                            }
                        }
                    }
                }
            }
        }
        //
        return $moves;
    }

    /**
     * @inheritDoc
     */
    public function opName(): string
    {
        return 'Opponent choose move by figure price.';
    }
}