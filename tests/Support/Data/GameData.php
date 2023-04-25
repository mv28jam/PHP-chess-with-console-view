<?php

namespace Tests\Support\Data;

class GameData
{

    /**
     * @return array[]
     */
    public function gameEndProvider() : array  // to make it public use `_` prefix
    {
        return [
            //Kinder checkmate
            [
                'moves'=>"e2-e4|e7-e5|d1-h5|g8-f6|f1-c4|a7-a6|h5-f7",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
        ];
    }

}