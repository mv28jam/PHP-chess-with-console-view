<?php

namespace notations;

use Desk;
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
    const REGEX = '/^(\d{1}\.\s)?\pL{0,2}?([a-h]{1}[0-8]{1})[-|—|x|:]([a-h]{1}[0-8]{1})([RQKB]{1})?/u';
    const REGEX2 = '/^(\d{1}\.\s)?([0-]{2,})/u';

    /**
     * @inheritDoc
     */
    public function getNotationName(): string
    {
        return 'Algebraic full notation:"1. e2—e4 e7—e5"';
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
    public function convertToInternalMoves($in, Desk $desk = null): array
    {
        $res = [];
        //
        foreach ($this->splitMoves($in) as $val){
            if(preg_match(self::REGEX2, $in)){
                switch(true){
                    case(strlen($in)>3 and $desk->getOrderColor()):
                        $res[] = 'e1-b1';
                        break;
                    case(strlen($in)>3 and !$desk->getOrderColor()):
                        $res[] = 'e8-b8';
                        break;
                    case($desk->getOrderColor()):
                        $res[] = 'e1-g1';
                        break;
                    default:
                        $res[] = 'e8-g8';
                        break;
                }
            }else{
                $tmp = str_replace(['—', 'x', ':'], Move::SEPARATOR, $val);
                $tmp = str_replace(['?', '!', '#', '+'], '', $tmp);
                preg_match(self::REGEX, $tmp, $matches);
                $tmp = $matches[2] . Move::SEPARATOR . $matches[3] . (empty($val[4]) ?? [$val[4]]);;
                $res[] = $tmp;
            }
            //
        }

        //
        return $res;
    }

    /**
     * @inheritDoc
     */
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