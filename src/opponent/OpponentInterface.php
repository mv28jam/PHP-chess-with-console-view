<?php

namespace opponent;

use Desk;

interface OpponentInterface
{

    /**
     * @param bool $color
     */
    public function __construct(bool $color);

    /**
     * Color of opponent
     * @return bool
     */
    public function color(): bool;

    /**
     * Return opponent move
     * @param Desk $desk
     * @param bool $is_black
     * @return string
     */
    public function opMove(Desk $desk): string;

    /**
     * Can opponent move by itself
     * @param bool $color
     * @return bool
     */
    public function can(bool $color): bool;

    /**
     * Name of bot
     * @return string
     */
    public function opName(): string;

}