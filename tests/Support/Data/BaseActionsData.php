<?php

namespace Tests\Support\Data;


/**
 *  @property-read  $start_desc
 */
class BaseActionsData
{
    /**
     * @param string $name
     * @return false|string
     */
    public function __get(string $name){
        return $this->$name;
    }

    /**
     * Desc start description
     * @var string
     */
    private string $start_desc = '{
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