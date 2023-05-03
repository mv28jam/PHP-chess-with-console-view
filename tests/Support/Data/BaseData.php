<?php

namespace Tests\Support\Data;


/**
 *  @property-read  $start_desc
 */
class BaseData
{
    /**
     * @return array[]
     */
    public function deskBaseMoveProvider() : array
    {
        return [
            ['move'=>"a2-a3", 'fig'=>'Pawn'],
            ['move'=>"a2-a4", 'fig'=>'Pawn'],
            ['move'=>"e2-e3", 'fig'=>'Pawn'],
            ['move'=>"e2-e4", 'fig'=>'Pawn'],
            ['move'=>'b1-a3', 'fig'=>'Knight'],
            ['move'=>'b1-c3', 'fig'=>'Knight'],
            ['move'=>'g1-h3', 'fig'=>'Knight'],
            ['move'=>'g1-f3', 'fig'=>'Knight'],
            ['move'=>"e7-e5", 'fig'=>'Pawn', 'pre'=>'e2-e4'],
            ['move'=>"e7-e6", 'fig'=>'Pawn', 'pre'=>'e2-e4'],
            ['move'=>'b8-a6', 'fig'=>'Knight', 'pre'=>'e2-e4'],
            ['move'=>'b8-c6', 'fig'=>'Knight', 'pre'=>'e2-e4'],
            ['move'=>'g8-h6', 'fig'=>'Knight', 'pre'=>'e2-e4'],
            ['move'=>'g8-f6', 'fig'=>'Knight', 'pre'=>'e2-e4'],
            ['move'=>'e1-e2', 'fig'=>'King', 'pre'=>'e2-e4|e7-e5'],
            ['move'=>'e8-e7', 'fig'=>'King', 'pre'=>'e2-e4|e7-e5|a2-a4'],
            ['move'=>'a1-a2', 'fig'=>'Rook', 'pre'=>'a2-a4|e7-e5'],
            ['move'=>'a8-a6', 'fig'=>'Rook', 'pre'=>'e2-e4|a7-a5|e4-e5'],
            ['move'=>'h1-h2', 'fig'=>'Rook', 'pre'=>'h2-h4|e7-e5'],
            ['move'=>'h8-h6', 'fig'=>'Rook', 'pre'=>'e2-e4|h7-h5|e4-e5'],
            ['move'=>'f1-c4', 'fig'=>'Bishop', 'pre'=>'e2-e4|e7-e5'],
            ['move'=>'f8-c5', 'fig'=>'Bishop', 'pre'=>'e2-e4|e7-e5|a2-a4'],
            ['move'=>'c1-e3', 'fig'=>'Bishop', 'pre'=>'d2-d4|e7-e5'],
            ['move'=>'c8-a6', 'fig'=>'Bishop', 'pre'=>'e2-e4|b7-b5|a2-a4'],
        ];
    }

    /**
     * @return array[]
     */
    public function moveInitProvider() : array
    {
        return [
            ['move'=>"e2-e4", 'dY'=>-2, 'dX'=>0,'xFrom'=>'e','xTo'=>'e','yFrom'=>2,'yTo'=>4],
            ['move'=>"e7-e5", 'dY'=>2, 'dX'=>0,'xFrom'=>'e','xTo'=>'e','yFrom'=>7,'yTo'=>5],
            ['move'=>"g1-f3", 'dY'=>-2, 'dX'=>1,'xFrom'=>'g','xTo'=>'f','yFrom'=>1,'yTo'=>3],
            ['move'=>"b8-c6", 'dY'=>2, 'dX'=>-1,'xFrom'=>'b','xTo'=>'c','yFrom'=>8,'yTo'=>6],
            ['move'=>"h1-g1", 'dY'=>0, 'dX'=>1,'xFrom'=>'h','xTo'=>'g','yFrom'=>1,'yTo'=>1],
            ['move'=>"a8-b8", 'dY'=>0, 'dX'=>-1,'xFrom'=>'a','xTo'=>'b','yFrom'=>8,'yTo'=>8]
        ];
    }

    /**
     * Desc start description
     * @var string
     */
    public string $start_desc = '{
    "a": {
        "8": {
            "fig": "Rook",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Rook",
            "is_black": false
        }
    },
    "b": {
        "8": {
            "fig": "Knight",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Knight",
            "is_black": false
        }
    },
    "c": {
        "8": {
            "fig": "Bishop",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Bishop",
            "is_black": false
        }
    },
    "d": {
        "8": {
            "fig": "Queen",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Queen",
            "is_black": false
        }
    },
    "e": {
        "8": {
            "fig": "King",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "King",
            "is_black": false
        }
    },
    "f": {
        "8": {
            "fig": "Bishop",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Bishop",
            "is_black": false
        }
    },
    "g": {
        "8": {
            "fig": "Knight",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Knight",
            "is_black": false
        }
    },
    "h": {
        "8": {
            "fig": "Rook",
            "is_black": true
        },
        "7": {
            "fig": "Pawn",
            "is_black": true
        },
        "6": {
            "fig": "",
            "is_black": null
        },
        "5": {
            "fig": "",
            "is_black": null
        },
        "4": {
            "fig": "",
            "is_black": null
        },
        "3": {
            "fig": "",
            "is_black": null
        },
        "2": {
            "fig": "Pawn",
            "is_black": false
        },
        "1": {
            "fig": "Rook",
            "is_black": false
        }
    }
}';

}