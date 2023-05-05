<?php

namespace Tests\Unit;

use Codeception\Attribute\DataProvider;
use Codeception\Example;
use EndGameException;
use Game;
use opponent\OneIterPriceOpponent;
use opponent\PriceOpponent;
use opponent\RandomOpponent;
use Tests\Support\Data\GameData;
use Tests\Support\UnitTester;

class PVPCest
{

    private Game $game;

    public function _before(UnitTester $I)
    {
        $this->game = new Game();
    }

    /**
     * @param UnitTester $I
     * @param Example $v
     * @return void
     */
    #[DataProvider('botProvider')]
    public function gameFigureSituationTest(UnitTester $I, Example $v): void
    {
        $I->expectThrowable(
            EndGameException::class,
            function() use ($v) {
                do {
                    //find player who can move
                    foreach ([$v[0], $v[1]] as $val) {
                        if ($val->can(!$this->game->desc()->getOrderColor())) {
                            $input = $val->opMove($this->game->desc());
                            $this->game->makeMove($input);
                        }
                    }
                } while (true);
            }
        );
    }

    /** PROVIDERS */
    protected function botProvider() : array
    {
        $res = [];
        //
        $player1 = [new RandomOpponent(true), new PriceOpponent(true), new OneIterPriceOpponent(true)];
        $player2 = [new RandomOpponent(false), new PriceOpponent(false), new OneIterPriceOpponent(false)];
        foreach ($player1 as $p1) {
            foreach ($player2 as $p2) {
                $res[] = [$p1, $p2];
            }
        }
        return $res;

    }

}