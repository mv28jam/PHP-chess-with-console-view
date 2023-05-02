<?php

namespace opponent;

use Desk;

/**
 * Empty opponent
 */
class NoOpponent implements OpponentInterface
{

    /**
     * Color of opponent
     * @var bool
     */
    private bool $is_black;

    /**
     * @inheritDoc
     */
    public function __construct(bool $color)
    {
        $this->is_black = $color;
    }

    /**
     * @inheritDoc
     */
    public function color(): bool
    {
        return $this->is_black;
    }

    /**
     * @inheritDoc
     */
    public function opMove(Desk $desk): string
    {
        return '';
    }

    /**
     * @param bool $color
     * @inheritDoc
     */
    public function can(bool $color): bool
    {
       return false;
    }

    /**
     * @inheritDoc
     */
    public function opName(): string
    {
        return 'No opponent mode.';
    }

}