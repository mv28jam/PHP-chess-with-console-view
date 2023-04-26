<?php

namespace notations;

use Move;

class AlgebraicFullNotation implements NotationInterface
{
    /**
     * regex for move split
     */
    const DELIMITER = "/(\d*\.)|( )/";
    /**
     * regex for notation detect
     */
    const REGEX = '/^(\d{1}\.\s)?\pL?([a-h]{1}[0-8]{1})[-|—|x]([a-h]{1}[0-8]{1})/u';
    const REGEX2 = '/^(\d{1}\.\s)?([0-]{2,})/u';

    /**
     * @inheritDoc
     */
    public function getNotationName(): string
    {
        return 'Algebraic full notation. "1. e2—e4 e7—e5"';
    }

    /**
     * @inheritDoc
     */
    public function detectNotation(string $in): bool
    {
        return ((preg_match(self::REGEX, $in) != false) or (preg_match(self::REGEX2, $in) != false));
    }

    /**
     * @inheritDoc
     */
    public function convertToInternalMoves($in): array
    {
        $res = [];

        //FIXME!!! Convert Roque

        //
        foreach ($this->splitMoves($in) as $val){
            $tmp = str_replace(['—','x'],Move::SEPARATOR,$val);
            $tmp = str_replace(['?','!','#','+'],'',$tmp);
            preg_match(self::REGEX, $tmp, $matches);
            $tmp = $matches[2].Move::SEPARATOR.$matches[3];
            $res[] = $tmp;
        }
        //
        return $res;
    }

    public function splitMoves(string $in): array
    {
        $in = preg_split(self::DELIMITER, $in);
        //
        for ($i=0; $i<count($in); $i++){
            $in[$i] = trim($in[$i]);
        }
        return array_values(array_filter($in));
    }
}