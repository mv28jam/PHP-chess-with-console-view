<?php

use notations\AlgebraicFullNotation;
use notations\InternalNotation;
use notations\NumericNotation;

/**
 * Notation converter for moves
 */
class NotationConverter
{
    /**
     * @param $in
     * @param Desk $desk
     * @return array
     */
    public function process($in, Desk $desk) : array{
        //
        $t = [new InternalNotation(), new NumericNotation(), new AlgebraicFullNotation()];
        //
        foreach ($t as $notation) {
            if ($notation->detectNotation($in)) {
                return $notation->convertToInternalMoves($in, $desk);
            }
        }
        return [$in];

    }

}