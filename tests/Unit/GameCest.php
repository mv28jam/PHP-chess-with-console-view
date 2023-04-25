<?php

namespace Tests\Unit;

use Desk;
use DeskConditionException;
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
        $this->desk = new Desk();
    }


    /**
     * Full game test with end
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

    /**
     * Game cant exception after move check
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('gameFigureSituationProvider')]
    public function gameFigureSituationTest(UnitTester $I,  Example $v): void
    {
        $I->expectThrowable(
            new Exception($v['result']),
            function() use ($v){
                foreach (explode('|', $v['moves']) as $move) {
                    $this->desk->move(new Move($move));
                }
            }
        );
    }

    /**
     * Game after moves figure in position
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('gameFigurePosProvider')]
    public function gameFigurePosTest(UnitTester $I,  Example $v): void
    {
        foreach (explode('|', $v['moves']) as $move) {
            $this->desk->move(new Move($move));
        }
        $I->assertEquals($v['fig'], $this->desk->toMap()[$v['x']][$v['y']]->fig);
    }


    /** PROVIDERS */
    protected function gameEndProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->gameEndProvider();
    }
    protected function gameFigurePosProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->gameFigurePosProvider();
    }
    protected function gameFigureSituationProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->gameFigureSituationProvider();
    }


}