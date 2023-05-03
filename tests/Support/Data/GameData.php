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
            //big auto games
            [
                'moves'=>"b1-c3|f7-f6|d2-d4|b8-a6|d4-d5|c7-c5|d1-d4|g7-g5|d4-g4|b7-b5|g4-f5|f8-h6|e1-d2|e8-f7|c3-a4|c5-c4|f5-g6|f7-f8|d2-e3|e7-e5|a4-c3|d8-e7|b2-b3|b5-b4|g6-h5|a6-c7|c3-d1|c4-b3|c2-c3|e7-d8|e3-d2|d8-e7|h5-h4|b4-c3|d2-c3|c7-b5|c3-b3|e7-f7|b3-b2|e5-e4|h4-h3|c8-a6|f2-f4|f7-h5|h3-f3|f8-g7|c1-e3|a8-f8|f3-g4|f8-d8|g4-g3|h5-e2|b2-c1|e2-f3|h2-h4|f3-g4|e3-a7|g4-h3|a7-b8|e4-e3|f1-c4|h3-g3|c4-e2|g3-g2|d1-e3|g5-g4|e3-g2|g4-g3|b8-a7|g7-f8|a2-a3|f8-g7|e2-c4|d7-d6|c1-d2|g8-e7|g2-e1|g7-f8|d2-d3|d8-d7|c4-b5|h6-g5|b5-a6|d7-b7|e1-f3|b7-b4|a6-c4|g5-f4|d3-e2|b4-b2|f3-d2|b2-c2|a7-b6|f4-d2|g1-f3|h8-g8|h1-h2|e7-c6|a1-a2|c2-a2|h4-h5|d2-f4|e2-d3|f8-e8|c4-a2|e8-d7|d3-c4|g8-e8|b6-a7|e8-a8|f3-g5|c6-b4|h2-h1|a8-b8|h1-h4|b8-b6|c4-b3|f4-d2|h4-c4|f6-f5|b3-a4|b4-d3|a7-b6|d2-b4|a3-b4|d7-e7|c4-c3|g3-g2|c3-c7|e7-d8|c7-c1|d8-e7|a4-a5|g2-g1-b|b6-c5|d3-f2|a5-b6|f5-f4|h5-h6|e7-f6|b6-c6|f2-g4|g5-e6|g4-h6|e6-d4|f6-e7|a2-b3|e7-e8|d4-f3|h6-f5|b3-c2|e8-f8|c5-d6|f5-e7|c6-b5|g1-f2|c2-b1|f2-b6|d6-e7|f8-g7|b5-c6|b6-g1|f3-d2|g7-h8|c6-c7|h8-g7|c1-f1|g1-a7|f1-d1|a7-d4|c7-b8|d4-c3|b1-g6|c3-d4|b8-b7|f4-f3|e7-c5|d4-f6|c5-g1|f6-d8|d1-e1|g7-f8|e1-e7|f3-f2|g1-f2|d8-b6|b7-b6|f8-g8|e7-f7|h7-h5|b6-a7|g8-h8|f7-h7|h8-g8|g6-d3|h5-h4|d3-e2|g8-h7|d2-f3|h7-h6|f2-b6|h6-g7|f3-e5|g7-f6|e5-c4|f6-f7|e2-h5|f7-f6|c4-e3|f6-e5|h5-e8|e5-e4|e8-f7|e4-e5|f7-g6|e5-d6|e3-f5|d6-e5|b6-d8|h4-h3|g6-f7|e5-e4|a7-b8|e4-f5|d5-d6|f5-g4|d8-g5|g4-f5|g5-h4|f5-e5|d6-d7|e5-f5|d7-d8-r|f5-g4|d8-d2|g4-f5|d2-e2|f5-g4|f7-g8|g4-f3|b8-c7|f3-e2|h4-f2|e2-d1|g8-f7|d1-e2|f7-g8|e2-d1|f2-h4|d1-e2|g8-h7|h3-h2|h7-b1|h2-h1-r|c7-c8|h1-h3|b1-c2|h3-h4|c2-h7|e2-e1|c8-b7|h4-c4|b4-b5|c4-h4|b7-a7|e1-d1|h7-g8|d1-e1|a7-a8|h4-h5|g8-d5|h5-h4|d5-g2|h4-f4|g2-f3|f4-e4|f3-g2|e4-h4|g2-h3|h4-c4|h3-f5|e1-d1|b5-b6|d1-e1|f5-h7|c4-c2|b6-b7|c2-c3|b7-b8-b|c3-g3|h7-g6|e1-f2|b8-e5|g3-g6|e5-d4|f2-e2|d4-c3|e2-e3|c3-a5|g6-c6|a5-b6|e3-f4|b6-a7|c6-c1|a7-d4|f4-f3|d4-a1|f3-g4|a8-b8|g4-f4|b8-a7|f4-f3|a1-c3|f3-f4|c3-b4|c1-c4|b4-d2|f4-e5|d2-c3|e5-f4|c3-d4|f4-g4|a7-b6|g4-h4|d4-g1|h4-g4|b6-b7|c4-b4|b7-c6|g4-g3|c6-d5|g3-h4|g1-f2|h4-h3|d5-d6|b4-f4|f2-b6|f4-h4|b6-a7|h4-h7|d6-e5|h7-c7|e5-f5|c7-f7|f5-e6|f7-f1|a7-g1|f1-f2|e6-e5|f2-f8|e5-d4|f8-f6|g1-h2|f6-a6|d4-e4|a6-h6|e4-f3|h3-h2|f3-e4|h6-h3|e4-f5|h3-e3|f5-f4|e3-e2|f4-f3|h2-g1|f3-g3|e2-e1|g3-f4|g1-f2|f4-g4|e1-b1|g4-h4|b1-b4|h4-h5|b4-d4|h5-h6|f2-f1|h6-h5|d4-c4|h5-g5|c4-h4|g5-g6|f1-e1|g6-f6|h4-f4|f6-e7|f4-f7|e7-f7",
                'result'=>'Game over. 2 kings on desk - nobody wins by e7-f7'
            ],
            [
                'moves'=>"g1-f3|b7-b5|f3-h4|d7-d6|f2-f3|d6-d5|d2-d3|f7-f6|b2-b4|c8-b7|h4-g6|h7-h6|h2-h4|a7-a6|c1-g5|c7-c6|e1-f2|e8-f7|g5-e3|d8-c7|h1-h3|c7-d8|b1-c3|d8-d7|e3-d2|d7-g4|d1-e1|e7-e5|a2-a3|g4-c4|d2-c1|h6-h5|c3-e4|c4-b3|c1-e3|d5-d4|e1-c3|b3-d5|h3-g3|d5-d8|g3-g4|a6-a5|e3-f4|b7-c8|f4-d2|d8-e7|a1-b1|e7-d7|c3-d4|a8-a7|d4-b2|c6-c5|g2-g3|d7-c7|d2-f4|a7-a8|f2-g1|h8-h7|g1-g2|f7-e8|a3-a4|c7-b6|b2-a1|c5-b4|b1-e1|e8-d8|f4-g5|b6-e3|e4-d2|d8-e8|g4-d4|c8-d7|d4-c4|e3-b6|c4-g4|e5-e4|g2-h3|f8-d6|g5-h6|g8-e7|d3-e4|b6-a6|g6-f8|d7-c8|h6-f4|c8-e6|a1-c3|g7-g6|c3-d4|a6-b7|d4-e3|e6-f7|e3-f2|f7-b3|f4-d6|h5-g4|h3-g4|h7-g7|f1-h3|e8-f7|a4-b5|b7-b6|f2-b6|g6-g5|e1-c1|a5-a4|c1-a1|b8-d7|h4-g5|f6-f5|g4-h4|g7-g8|d6-b4|f7-e8|d2-c4|a8-a6|b6-d4|a6-a8|b4-e1|b3-c4|g5-g6|g8-g7|d4-d7|e8-f8|d7-e7|g7-e7|e2-e3|e7-e4|h4-g5|c4-e2|g5-f6|f5-f4|h3-d7|f4-g3|a1-a2|e4-e5|e1-c3|e2-d3|c3-b2|d3-e2|c2-c4|e5-b5|d7-c8|b5-b8|a2-a3|e2-f3|c8-h3|a8-a5|b2-c1|f8-g8|c1-b2|f3-e4|a3-a1|b8-b3|h3-d7|b3-d3|d7-g4|d3-d4|b2-c1|e4-h1|g4-c8|d4-h4|c1-d2|h4-h2|a1-e1|a5-a6|f6-f5|g8-g7|d2-a5|h2-h6|e1-h1|h6-h2|h1-d1|g7-f8|c8-a6|a4-a3|a5-c3|h2-c2|c3-a1|c2-f2|f5-g4|f2-f1|g4-h3|f1-f4|a1-b2|f8-e7|e3-f4|g3-g2|b2-a3|e7-e6|d1-g1|e6-f6|a3-b2|f6-e7|h3-g2|e7-e6|b2-c1|e6-f5|g2-f3|f5-e6|a6-c8|e6-f6|c8-a6|f6-g7|g1-d1|g7-h6|f3-g3|h6-g6|d1-d5|g6-h6|c1-e3|h6-h7|g3-h2|h7-h6|e3-c1|h6-g6|h2-h1|g6-f7|d5-d8|f7-g7|d8-h8|g7-h8|a6-b7|h8-h7|c1-e3|h7-g7|e3-f2|g7-h8|f4-f5|h8-g8|f2-g1|g8-h7|g1-h2|h7-h8|h2-b8|h8-g7|b8-f4|g7-f8|h1-h2|f8-e8|c4-c5|e8-e7|b7-h1|e7-f6|f4-d6|f6-g7|d6-c7|g7-f8|c7-e5|f8-f7|h2-h3|f7-e8|e5-b2|e8-f7|b2-a1|f7-e8|c5-c6|e8-f7|f5-f6|f7-e6|h3-g3|e6-f5|a1-b2|f5-g5|b2-c3|g5-g6|c3-a5|g6-h5|a5-c7|h5-g5|c7-a5|g5-f5|g3-h4|f5-e6|h4-g3|e6-f5|g3-h2|f5-e6|a5-c7|e6-f5|c7-b6|f5-g5|h2-g1|g5-h5|b6-a7|h5-g4|h1-e4|g4-h5|e4-d3|h5-g5|a7-b6|g5-h4|d3-b5|h4-h5|g1-f1|h5-g5|b6-c5|g5-f4|f1-g2|f4-e5|g2-f1|e5-d5|b5-a6|d5-e4|a6-c4|e4-f3|c4-d5|f3-g4|d5-b3|g4-f3|b3-a2|f3-e4|c5-e7|e4-d4|f1-e1|d4-c3|e7-f8|c3-d4|f8-h6|d4-d3|a2-f7|d3-c2|f7-e6|c2-d3|h6-f8|d3-e3|e6-f7|e3-d4|f7-g8|d4-e4|f8-d6|e4-d3|d6-a3|d3-e4|e1-f2|e4-f5|f6-f7|f5-f6|f2-g2|f6-g5|g2-f1|g5-h4|f1-g1|h4-g4|g1-g2|g4-f5|g2-g1|f5-g5|g1-h2|g5-f5|g8-h7|f5-g4|h7-g8|g4-f5|h2-h3|f5-e4|f7-f8-q|e4-e5|f8-f7|e5-e4|f7-h5|e4-e3|g8-h7|e3-f4|h5-d1|f4-g5|d1-b3|g5-h6|a3-f8|h6-g5|f8-c5|g5-f6|b3-a3|f6-g7|c5-a7|g7-h6|h7-f5|h6-h5|a7-c5|h5-g5|c6-c7|g5-h6|c5-d4|h6-g5|c7-c8-k|g5-h6|f5-e6|h6-g6|e6-f5|g6-h6|h3-g3|h6-h5|c8-a7|h5-h6|d4-f6|h6-h5|f5-g4|h5-h6|g4-d1|h6-g6|a3-f8|g6-f5|a7-c6|f5-g6|d1-b3|g6-f5|f8-h6|f5-e4|h6-h5|e4-d3|g3-h2|d3-e4|b3-c4|e4-e3|c6-e5|e3-d2|c4-g8|d2-c3|g8-c4|c3-d2|f6-g5|d2-e1|c4-b3|e1-f2|e5-d7|f2-e1|g5-h6|e1-f1|b3-g8|f1-f2|h5-d1",
                'result'=>'Game over. Stalemate, nobody wins by h5-d1'
            ],
            [
                'moves'=>"g1-f3|e7-e5|c2-c4|f8-a3|d1-a4|a3-c5|g2-g3|c5-e7|e1-d1|e8-f8|f3-e1|g8-h6|a4-a5|f8-e8|c4-c5|h8-f8|h2-h3|f7-f5|e2-e3|e7-f6|f1-e2|b7-b6|e2-f3|b8-c6|f3-e2|e8-f7|e2-b5|f5-f4|b5-a4|f4-e3|e1-g2|b6-a5|g2-h4|c8-a6|b2-b3|g7-g5|b1-c3|f7-g7|h4-f3|e3-d2|h3-h4|d7-d5|f3-d2|g5-h4|h1-h2|d8-e7|f2-f4|c6-d4|d2-f1|h6-f5|h2-g2|e7-c5|c3-b1|f5-e3|f1-e3|f6-e7|a4-d7|a8-e8|d7-a4|d4-b3|a2-a3|c5-c1",
                'result'=>'Game over. Checkmate. ♙ wins by c5-c1'
            ],
            [
                'moves'=>"e2-e4|b8-c6|d2-d4|c6-b8|e1-e2|b7-b6|b1-d2|d7-d6|c2-c4|c8-a6|b2-b4|a6-c4|e2-e3|c4-a2|f1-b5|c7-c6|b5-e2|f7-f5|e2-f1|e8-f7|d1-f3|d8-e8|e4-e5|g8-h6|f3-h5|g7-g6|e3-e2|a2-b1|a1-a2|e8-d8|h5-g5|f7-e8|h2-h4|d8-c8|g5-h6|f5-f4|h4-h5|f4-f3|e2-e3|f8-g7|f1-e2|a7-a5|e2-b5|e8-d7|b5-c4|c8-b7|h1-h4|f3-g2|f2-f3|b7-a7|a2-a3|g7-h6|f3-f4|e7-e6|h4-h2|b1-c2|c4-b5|h8-d8|h2-h1|g2-h1-q|a3-a4|h1-h4|b5-c6|d7-c8|c6-d7|b8-d7|c1-a3|h4-g4|g1-h3|c2-b3|d4-d5|g4-f5|d2-f3|h6-f4|h3-f4|d8-f8|e3-f2|b3-a4|h5-g6|f5-f4|a3-c1|f8-d8|f2-g1|f4-h6|c1-e3|e6-d5|e3-c5|a8-b8|g1-f2|h6-f8|f2-e1|b6-c5|b4-c5|f8-h8|f3-g1|h7-g6|e5-e6|h8-h2|e6-d7|a7-d7|g1-e2|h2-g1|e1-d2|c8-c7|e2-d4|b8-b1|d4-b5|c7-c8|b5-d6|d7-d6|d2-e2|g1-f2|e2-d3|d6-f8|d3-c3|f8-d6|c5-c6|d6-f8|c6-c7|f2-f7|c7-d8-r|c8-b7|d8-e8|a4-b3|e8-a8|b3-c4|a8-e8|f8-e8|c3-d4|e8-h8|d4-e3|f7-f2|e3-f2|h8-e8|f2-f3|e8-a8|f3-g2|a8-c8|g2-f3|c8-d7|f3-e3|b7-c8|e3-d4|d7-a4|d4-c5|a4-a2|c5-d4|a2-g2|d4-c3|b1-g1|c3-d4|g1-b1|d4-e3|c8-b8|e3-d4|b1-b6|d4-e5|c4-d3|e5-f4|g2-h1|f4-g5|d3-e4|g5-f4|h1-c1|f4-e5|e4-g2|e5-d4|g2-h1|d4-d3|b6-b2|d3-d4|c1-d2|d4-e5|d2-h6|e5-d6|b2-h2|d6-e5|h2-h3|e5-d6|b8-a7|d6-d7|h3-h4|d7-c8|d5-d4|c8-d8|h4-g4|d8-e7|a5-a4|e7-e8|h6-c1|e8-e7|c1-g1|e7-f8|g1-a1|f8-f7|h1-e4|f7-f8|a1-h1|f8-g8|g4-g2|g8-f7|a7-b8|f7-e6|h1-g1|e6-f6|d4-d3|f6-e6|g1-d4|e6-e7|d4-a1|e7-d6|g2-h2|d6-c5|e4-b7|c5-b6|a1-f1|b6-c5|h2-h7|c5-b6|f1-e2|b6-a5|e2-a2|a5-b6|a4-a3|b6-c5|h7-d7|c5-b4|b8-a7|b4-a5|a2-b1|a5-a4|a7-b8|a4-a5|d7-d8|a5-a4|d8-f8|a4-a5|b1-f1|a5-b5|f1-f3|b5-c4|f3-d1|c4-b4|b7-c6|b4-c5|c6-a8|c5-d6|d1-e1|d6-c5|a8-h1|c5-d6|e1-b4|d6-d7|b8-b7|d7-e6|d3-d2|e6-e5|f8-g8|e5-e6|h1-f3|e6-f6|f3-g2|f6-g5|b4-a5|g5-f6|d2-d1-r|f6-e7|d1-f1|e7-d6|g8-a8|d6-d7|a5-b5|d7-d6|b5-e2|d6-c5|g2-d5|c5-d6|d5-a2|d6-c5|f1-f8|c5-b4|e2-c4",
                'result'=>'Game over. Checkmate. ♙ wins by e2-c4'
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
            // ?
            [
                'moves'=>"b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3|b5-b6|h3-h2|a2-a3|h2-g1",
                'result'=>'Pawn conversion move. Choose replace of pawn by adding h2-g1+r (move +first letter of new figure name).'
            ],

        ];
    }

}