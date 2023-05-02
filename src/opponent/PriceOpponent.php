<?php

namespace opponent;

use Desk;

class PriceOpponent implements OpponentInterface
{

    public function __construct(bool $color)
    {
    }

    public function color(): bool
    {
        // TODO: Implement color() method.
    }

    public function opMove(Desk $desk): string
    {
        // TODO: Implement opMove() method.
    }

    public function can(bool $color): bool
    {
        // TODO: Implement can() method.
    }

    public function opName(): string
    {
        // TODO: Implement opName() method.
    }
}