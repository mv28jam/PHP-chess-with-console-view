<?php

namespace Tests\Support\Data;

class GameData
{

    /**
     * @return array[]
     */
    public function gameEndProvider() : array
    {
        return [
            //Kinder checkmate
            [
                'moves'=>"e2-e4|e7-e5|d1-h5|g8-f6|f1-c4|a7-a6|h5-f7",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
            [
                'moves'=>"g2-g4|e7-e5|f2-f3|d8-h4",
                'result'=>'Game over. Checkmate. ♙ wins by d8-h4'
            ],
            [
                'moves'=>"g2-g4|e7-e5|f2-f4|d8-h4",
                'result'=>'Game over. Checkmate. ♙ wins by d8-h4'
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function gameFigurePosProvider() : array
    {
        return [
            //en passant
            [
                'moves'=>"b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3", 'x'=>'h', 'y'=>4, 'fig'=>''
            ],
            //roque
            [
                'moves'=>"g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|e1-g1", 'x'=>'f', 'y'=>1, 'fig'=>'Rook'
            ],
            //Pawn respawn
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1+r', 'x'=>'g', 'y'=>1, 'fig'=>'Rook'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1+q', 'x'=>'g', 'y'=>1, 'fig'=>'Queen'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1+k', 'x'=>'g', 'y'=>1, 'fig'=>'Knight'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1+B', 'x'=>'g', 'y'=>1, 'fig'=>'Bishop'
            ],

        ];
    }

    /**
     * @return array[]
     */
    public function gameFigureSituationProvider() : array
    {
        return [
            //roque can not
            [
                'moves'=>"g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-g1",
                'result'=>'Forbidden move for ♚'
            ],
            //goto under attack
            [
                'moves'=>"g1-h3|e7-e6|e2-e4|e6-e5|f1-d3|d8-h4|g2-g4|h4-g3|e1-f1|h7-h6|f1-g1",
                'result'=>'Forbidden move for ♚'
            ],
            //king collision
            [
                'moves'=>"e2-e4|e7-e5|e1-e2|e8-e7|e2-e3|e7-e6|e3-f4|e6-f6|f3-g3|f6-g6|g3-g4|g6-g5",
                'result'=>'Forbidden move for ♚'
            ],

        ];
    }

}