<?php

namespace notations;

use Desk;
use Move;

/**
 * Internal notation instance
 */
class InternalNotation implements NotationInterface
{

    /**
     * Move internal delimiter
     */
    const DELIMITER = Move::DELIMITER;

    const REGEX='/^([a-h])([1-8])'.Move::SEPARATOR.'([a-h])([1-8])('.Move::SEPARATOR.'[rRqQkKbB])?$[^!?:#+]?/u';

    /**
     * @inheritDoc
     */
    public function getNotationName(): string
    {
        return 'Internal notation:"g8'.Move::SEPARATOR.'f6"';
    }

    /**
     * @inheritDoc
     */
    public function detectNotation(string $in): bool
    {
        $m = $this->splitMoves($in);
        if(preg_match(self::REGEX, $m[0])) return true;
        return false;
    }

    /**
     * @inheritDoc
     */
    public function convertToInternalMoves($in, Desk $desk=null): array
    {
        return $this->splitMoves($in);
    }

    /**
     * @inheritDoc
     */
    public function splitMoves(string $in): array
    {
        return explode(self::DELIMITER, $in);
    }
}