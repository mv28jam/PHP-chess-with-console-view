<?php

/**
 * Notation converter for moves
 */
class GameNotationConverter
{
    /**
     * Move internal delimiter
     */
    const DELIMITER = '|';

    public function __construct(){

        $ex='1. e2—e4 e7—e5
2. Сf1—c4 Кb8—c6
3. Фd1—h5 Кg8—f6
4. Фh5xf7#';
        $this->convertStdNotation($ex);

        die;



    }

    /**
     * Explode std internal moves
     * @param string $in
     * @return array
     */
    public function internalMoves(string $in): array
    {
        //explode moves b2-b4|g7-g5
        $in = explode(self::DELIMITER, $in);
        return $in;
    }


    public function convertStdNotation(string $in){
        $premoves = [];
        //
        $premoves = $this->explodeMovesFromStd($in);

        var_dump($premoves);

    }

    protected function explodeMovesFromStd(string $in): array
    {
        $in = preg_split("/\d*\./", $in);
        //
        for ($i=0; $i<count($in); $i++){
            $in[$i] = trim($in[$i]);
        }
        return array_values(array_filter($in));
    }
}