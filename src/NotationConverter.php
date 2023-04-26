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
     * @return array
     */
    public function process($in) : array{
        //
        $t = [new InternalNotation(), new NumericNotation(), new AlgebraicFullNotation()];
        //
        foreach ($t as $notation) {
            if ($notation->detectNotation($in)) {
                return $notation->convertToInternalMoves($in);
            }
        }
        return [$in];

    }

}