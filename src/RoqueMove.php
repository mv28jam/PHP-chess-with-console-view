<?php

class RoqueMove
{
    const WHITE_LINE = 1;
    const BLACK_LINE = 8;

    const KING_START = 'e';
    // SHORT
    const KING_STOP_SHORT = 'g';
    const ROOK_START_SHORT = 'h';
    const ROOK_STOP_SHORT = 'f';
    const CHECK_SHORT_POSITION = ['f', 'g'];
    // LONG
    const KING_STOP_LONG = 'c';
    const ROOK_START_LONG = 'a';
    const ROOK_STOP_LONG = 'd';
    const CHECK_LONG_POSITION = ['b', 'c', 'd'];



    private bool $isBlack;

    private bool $isShort;

    private array $kingStartPosition;
    private array $kingStopPosition;

    private array $rookStartPosition;
    private array $rookStopPosition;
    private array $checkPositions;

    public function __construct(bool $isBlack, bool $isShort)
    {
        $this->isBlack = $isBlack;
        $this->isShort = $isShort;

        $line = $this->isBlack ? self::BLACK_LINE : self::WHITE_LINE;

        $this->kingStartPosition = [self::KING_START, $line];
        $this->kingStopPosition = $this->isShort ? [self::KING_STOP_SHORT, $line] : [self::KING_STOP_LONG, $line];

        $this->rookStartPosition = $this->isShort ? [self::ROOK_START_SHORT, $line] : [self::ROOK_START_LONG, $line];
        $this->rookStopPosition = $this->isShort ? [self::ROOK_STOP_SHORT, $line] : [self::ROOK_STOP_LONG, $line];

        $this->checkPositions = $this->isShort ? self::CHECK_SHORT_POSITION : self::CHECK_LONG_POSITION;
    }

    public function getStartKingPosition(): array
    {
        return $this->kingStartPosition;
    }

    public function getStopKingPosition(): array
    {
        return $this->kingStopPosition;
    }

    public function getStartRookPosition(): array
    {
        return $this->rookStartPosition;
    }

    public function getStopRookPosition(): array
    {
        return $this->rookStopPosition;
    }

    public function getToCheckPositions(): array
    {
        $result = [];
        $line = $this->isBlack ? self::BLACK_LINE : self::WHITE_LINE;
        foreach ($this->checkPositions as $position) {
            $result[] = [$position, $line];
        }
        return $result;
    }

    public function isBlack(): bool
    {
        return $this->isBlack;
    }
}