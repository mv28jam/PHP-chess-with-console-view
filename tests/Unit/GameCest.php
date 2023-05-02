<?php

namespace Tests\Unit;

use DeskConditionException;
use EndGameException;
use Exception;
use Game;
use Move;
use Tests\Support\Data\GameData;
use Tests\Support\UnitTester;
use \Codeception\Attribute\DataProvider;
use \Codeception\Example;;


class GameCest
{
    private GameData $data;
    private Game $game;

    public function __construct()
    {
        $this->data = new GameData();
    }

    public function _before(UnitTester $I)
    {
        $this->game = new Game();
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
        $I->expectThrowable(
            new EndGameException($v['result']),
            function() use ($v){
                $this->game->makeMove($v['moves']);
            }
        );
    }

    /**
     * Check test
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('gameCheckProvider')]
    public function gameCheckTest(UnitTester $I,  Example $v): void
    {
        $I->expectThrowable(
            new DeskConditionException($v['result']),
            function() use ($v){
                $this->game->makeMove($v['moves']);
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
                $this->game->makeMove($v['moves']);
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
        $this->game->makeMove($v['moves']);
        $I->assertEquals($v['fig'], $this->game->desc()->toMap()[$v['x']][$v['y']]->fig);
    }


    /** PROVIDERS */
    protected function gameEndProvider() : array
    {
        return $this->data->gameEndProvider();
    }
    protected function gameFigurePosProvider() : array
    {
        return $this->data->gameFigurePosProvider();
    }
    protected function gameFigureSituationProvider() : array
    {
        return $this->data->gameFigureSituationProvider();
    }
    protected function gameCheckProvider() : array
    {
        return $this->data->gameCheckProvider();
    }



}