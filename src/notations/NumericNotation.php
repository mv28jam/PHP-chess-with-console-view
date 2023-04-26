<?php

namespace notations;

use Desk;
use Move;

class NumericNotation implements NotationInterface
{

    /**
     * regex for move split
     */
    const DELIMITER = "/(\d*\.)|( )/";
    /**
     * regex for notation detect
     */
    const REGEX = '/^(\d*\.\s)?([1-8]{4}([1-4]{1})?\s)?[1-8]{4}([1-4]{1})?()?/';
    /**
     * maps for translation
     */
    protected array $map=[1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h'];
    protected array $respawn_map=[1=>'q',2=>'r',3=>'b',4=>'k'];

    /**
     * @inheritDoc
     */
    public function getNotationName(): string
    {
        return 'ICCF numeric notation:"6264"';
    }

    /**
     * @inheritDoc
     */
    public function detectNotation(string $in): bool
    {
        return (preg_match(self::REGEX, $in) != false);
    }

    /**
     * @inheritDoc
     */
    public function convertToInternalMoves($in, Desk $desk = null): array
    {
        $res = [];
        //
        foreach ($this->splitMoves($in) as $val){
            $res[]=
                $this->map[$val[0]].$val[1]. Move::SEPARATOR.$this->map[$val[2]].$val[3]
                .(empty($val[4]) ? '' : (Move::SEPARATOR.$this->respawn_map[$val[4]]));
        }
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