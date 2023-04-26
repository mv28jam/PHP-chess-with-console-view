<?php

namespace notations;

/**
 *
 */
interface NotationInterface
{

    /**
     * Return notation name
     * @return string
     */
    public function getNotationName():string;

    /**
     * Detect is notation of this type
     * @param string $in
     * @return bool
     */
    public function detectNotation(string $in):bool;

    /**
     * Convert to internal notation moves
     * @param $in
     * @return array
     */
    public function convertToInternalNotation($in):array;

}