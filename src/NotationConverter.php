<?php

use notations\AlgebraicFullNotation;
use notations\InternalNotation;
use notations\NotationInterface;
use notations\NumericNotation;

/**
 * Notation converter for moves
 */
class NotationConverter
{
    /**
     * @var NotationInterface[]
     */
    private array $notations;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->notations = [
            new InternalNotation(),
            new NumericNotation(),
            new AlgebraicFullNotation()
        ];
    }

    /**
     * @param $in
     * @param Desk $desk
     * @return array
     */
    public function process($in, Desk $desk) : array{
        //
        foreach ($this->notations as $notation) {
            if ($notation->detectNotation($in)) {
                return $notation->convertToInternalMoves($in, $desk);
            }
        }
        return [$in];

    }

    /**
     * @return string
     */
    public function info() : string
    {
        $res = '';
        //
        foreach ($this->notations as $notation) {
                $res.= $notation->getNotationName()."/";
        }
        return $res;

    }



}