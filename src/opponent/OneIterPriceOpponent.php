<?php

namespace opponent;

use Desk;
use Exception;

/**
 * Price simple opponent with one iter of predict
 */
class OneIterPriceOpponent extends PriceOpponent implements OpponentInterface
{

    const CHECKMATE_PRICE = 100;
    const STALEMATE_PRICE = -10;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function opMove(Desk $desk): string
    {
        $fl = false;
        $moves = $this->collectMoves($desk);
        //count price by move result
        foreach ($moves as &$move){
            if($desk->condition->isFieldUnderAttack($move[0]->to, !$this->color(), $desk)){
                //if field under attack lower price of attack or move by price of moving figure
                $move[1] = $move[1] - $move[2];
            }
            //check one move stalemate and checkmate
            $this->predictOneIter($move, clone $desk);
        }
        //
        shuffle($moves);
        //sort by price of attacked figure
        usort ($moves , function ($a, $b) {
            return $a[1]<$b[1];
        });
        //
        return $moves[0][0];
    }

    /**
     * @param array $move
     * @param Desk $tmpdesk
     * @return void
     * @throws Exception
     */
    protected function predictOneIter(array &$move, Desk $tmpdesk): void
    {
        $tmpdesk->moveActions($move[0]);
        if($tmpdesk->condition->isKingUnderAttack(!$this->color(),$tmpdesk)){
                //win upper price
                if($tmpdesk->condition->isEndGameByCheckmate(!$this->color(), $tmpdesk)) $move[1] += self::CHECKMATE_PRICE;
            }else{
                //stalemate = no win so lower price
                if($tmpdesk->condition->isEndGameByStalemate(!$this->color(), $tmpdesk))$move[1]+=self::STALEMATE_PRICE;
        }
    }

    /**
     * @inheritDoc
     */
    public function opName(): string
    {
        return 'Opponent choose move by price of move result, one move prediction.';
    }
}