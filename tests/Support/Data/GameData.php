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
            //checkmate
            [
                'moves'=>"e2-e4|e7-e5|d1-h5|g8-f6|f1-c4|a7-a6|h5-f7",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
            [
                'moves'=>"g2-g4|e7-e5|f2-f4|d8-h4",
                'result'=>'Game over. Checkmate. ♙ wins by d8-h4'
            ],
            [
                'moves'=>"1. f2-f3 e7-e5 2. g2-g4?? Фd8-h4x",
                'result'=>'Game over. Checkmate. ♙ wins by d8-h4'
            ],
            //checkmate dif notations
            [
                'moves'=>"e2-e4|e7-e5|f1-c4|b8-c6|d1-h5|g8-f6|h5-f7",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
            [
                'moves'=>"1. e2—e4 e7—e5 2. Сf1—c4 Кb8—c6 3. Фd1—h5 Кg8—f6 4. Фh5xf7#",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
            [
                'moves'=>"1. 5254 5755 2. 6134 2836 3. 4185 7866 4. 8567",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
            [
                'moves'=>"5254 5755 6134 2836 4185 7866 8567",
                'result'=>'Game over. Checkmate. ♟ wins by h5-f7'
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function gameCheckProvider() : array
    {
        return [
            //check
            [
                'moves'=>"1. d2-d4 Kg8-f6 2. Cc1-g5 c7-c6 3. e2-e3?? Фd8-a5+",
                'result'=>'Check. King ♚ under attack!'
            ],
            [
                'moves'=>"1. d2-d4 Kg8-f6 2. Kg1-f3 c7-c5 3. Cc1-f4 c5:d4 4. Kf3:d4? e7-e5! 5. Сf4:e5 Фd8-a5+",
                'result'=>'Check. King ♚ under attack!'
            ],
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
            [
                'moves'=>"7183 5756 5254 5655 6143 4884 5171", 'x'=>'f', 'y'=>1, 'fig'=>'Rook'
            ],
            //Pawn respawn
            [
                'moves'=>'2224 7775 2425 7574 8284 7483 2526 8382 1213 82712', 'x'=>'g', 'y'=>1, 'fig'=>'Rook'
            ],
            [
                'moves'=>'2224 7775 2425 7574 8284 7483 2526 8382 1213 82711', 'x'=>'g', 'y'=>1, 'fig'=>'Queen'
            ],
            [
                'moves'=>'2224 7775 2425 7574 8284 7483 2526 8382 1213 82714', 'x'=>'g', 'y'=>1, 'fig'=>'Knight'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1-r', 'x'=>'g', 'y'=>1, 'fig'=>'Rook'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1-q', 'x'=>'g', 'y'=>1, 'fig'=>'Queen'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1-k', 'x'=>'g', 'y'=>1, 'fig'=>'Knight'
            ],
            [
                'moves'=>'b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1-B', 'x'=>'g', 'y'=>1, 'fig'=>'Bishop'
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