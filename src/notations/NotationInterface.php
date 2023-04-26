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
     * Split moves in current notation
     * @param string $in
     * @return array
     */
    public function splitMoves(string $in):array;

    /**
     * Convert to internal notation moves
     * @param string $in
     * @return array
     */
    public function convertToInternalMoves(string $in):array;

}