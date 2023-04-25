<?php


namespace Tests\Unit;

use Desk;
use Exception;
use Move;
use Tests\Support\UnitTester;
use Tests\Support\Data\BaseData;
use \Codeception\Attribute\DataProvider;
use \Codeception\Example;

class BaseCest
{

    private BaseData $data;
    private Desk $desk;

    public function __construct()
    {
        $this->data = new BaseData();
    }

    public function _before(UnitTester $I)
    {
        $this->desk = new Desk();
    }


    /**
     * View description of desk
     * @param UnitTester $I
     * @return void
     */
    public function deskViewTest(UnitTester $I): void
    {
        $I->assertEquals($this->data->start_desc, json_encode($this->desk->toMap(), JSON_PRETTY_PRINT));
    }

    /**
     * Primitive Move object test
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('moveInitProvider')]
    public function moveBaseTest(UnitTester $I,  Example $v): void
    {
        $move = new Move($v['move']);
        $I->assertEquals($move->dY, $v['dY']);
        $I->assertEquals($move->dX, $v['dX']);
        $I->assertEquals($move->getKill(), []);
        $I->assertEquals($move->getTransfer(), []);
        $I->assertEquals($move->xFrom, $v['xFrom']);
        $I->assertEquals($move->xTo, $v['xTo']);
        $I->assertEquals($move->yFrom, $v['yFrom']);
        $I->assertEquals($move->yTo, $v['yTo']);
        $I->assertEquals($move->respawn, '');
    }

    /**
     * Test for figure moving on desk
     * @param UnitTester $I
     * @param Example $v
     * @return void
     * @throws Exception
     */
    #[DataProvider('deskBaseMoveProvider')]
    public function deskBaseMoveTest(UnitTester $I,  Example $v): void
    {
        if(!empty($v['pre'])){
            $this->desk->move(new Move($v['pre']));
        }
        $this->desk->move(new Move($v['move']));
        $pos=explode('-',$v['move']);
        $I->assertEquals($v['fig'], $this->desk->toMap()[$pos[1][0]][$pos[1][1]]->fig);
        //
    }

    /**
     * Base move exceptions test
     * @param UnitTester $I
     * @return void
     */
    public function moveBaseExceptionsTest(UnitTester $I): void
    {
        //
        $I->expectThrowable(
            new Exception('Incorrect notation. Use e2-e4.'),
            function(){new Move('e3-e');}
        );
        //
        $I->expectThrowable(
            new Exception('No move'),
            function(){$this->desk->move(new Move('e2-e2'));}
        );
    }

    /**
     * Base desk move exceptions test
     * @param UnitTester $I
     * @return void
     */
    public function deskBaseExceptionsTest(UnitTester $I): void
    {
        //
        $I->expectThrowable(
            new Exception('No figure in position'),
            function(){$this->desk->move(new Move('e3-e4'));}
        );
        //
        $I->expectThrowable(
            new Exception('Other color moves - ♟'),
            function(){$this->desk->move(new Move('e7-e5'));}
        );

        $I->expectThrowable(
            new Exception('Self attack move, your color is ♟'),
            function(){$this->desk->move(new Move('h1-g1'));}
        );
    }

    /** PROVIDERS */
    protected function moveInitProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->moveInitProvider();
    }
    protected function deskBaseMoveProvider() : array  // to make it public use `_` prefix
    {
        return $this->data->deskBaseMoveProvider();
    }

}
