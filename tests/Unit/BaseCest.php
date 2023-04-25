<?php


namespace Tests\Unit;

use Exception;
use Tests\Support\UnitTester;
use Tests\Support\Data\BaseActionsData;

class BaseCest
{

    private BaseActionsData $data;
    private \Desk $desk;

    public function _before(UnitTester $I)
    {
        $this->data = new BaseActionsData();
        $this->desk = new \Desk();
    }


    public function deskViewTest(UnitTester $I): void
    {
        $I->assertEquals($this->data->start_desc, json_encode($this->desk->toMap(), JSON_PRETTY_PRINT));
    }

    public function moveBaseTest(UnitTester $I): void
    {
        $move = new \Move('e2-e4');
        $I->assertEquals($move->dY, -2);
        $I->assertEquals($move->dX, 0);
        $I->assertEquals($move->getKill(), []);
        $I->assertEquals($move->getTransfer(), []);
        $I->assertEquals($move->xFrom, 'e');
        $I->assertEquals($move->xTo, 'e');
        $I->assertEquals($move->yFrom, 2);
        $I->assertEquals($move->yTo, 4);
        $I->assertEquals($move->respawn, '');
    }

    public function deskBaseMoveTest(UnitTester $I): void
    {
        $this->desk->move(new \Move('e2-e4'));
        $I->assertEquals('Pawn', $this->desk->toMap()['e']['4']->fig);
        //
        $this->desk->move(new \Move('g8-f6'));
        $I->assertEquals('Knight', $this->desk->toMap()['f']['6']->fig);
    }

    public function moveBaseExceptionsTest(UnitTester $I): void
    {
        //
        $I->expectThrowable(
            new \Exception('Incorrect notation. Use e2-e4.'),
            function(){new \Move('e3-e');}
        );
        //
        $I->expectThrowable(
            new \Exception('No move'),
            function(){$this->desk->move(new \Move('e2-e2'));}
        );
    }

    public function deskBaseExceptionsTest(UnitTester $I): void
    {
        //
        $I->expectThrowable(
            new \Exception('No figure in position'),
            function(){$this->desk->move(new \Move('e3-e4'));}
        );
        //
        $I->expectThrowable(
            new \Exception('Other color moves - ♟'),
            function(){$this->desk->move(new \Move('e7-e5'));}
        );

        $I->expectThrowable(
            new \Exception('Self attack move, your color is ♟'),
            function(){$this->desk->move(new \Move('h1-g1'));}
        );
    }


}
