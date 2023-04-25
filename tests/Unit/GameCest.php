<?php

namespace Tests\Unit;

use Desk;
use EndGameException;
use Exception;
use Move;
use Tests\Support\Data\GameData;
use Tests\Support\UnitTester;
use \Codeception\Attribute\DataProvider;
use \Codeception\Example;;


class GameCest
{
    private GameData $data;
    private Desk $desk;

    public function __construct()
    {
        $this->data = new GameData();
    }

    public function _before(UnitTester $I)
    {

    }


    /**
     *
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('gameEndProvider')]
    public function gameEndTest(UnitTester $I,  Example $v): void
    {
        $this->desk = new Desk();

        $I->expectThrowable(
            new EndGameException($v['result']),
            function() use ($v){
                foreach (explode('|', $v['moves']) as $move) {
                    $this->desk->move(new Move($move));
                }
            }
        );
    }



    /** PROVIDERS */
    protected function gameEndProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->gameEndProvider();
    }


}