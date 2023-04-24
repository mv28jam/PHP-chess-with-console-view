<?php

/**
 * AbstractFigure abstract
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
abstract class AbstractFigure
{

    /**
     * Ordinary moves
     * @var Move[]
     */
    protected array $normal = [];
    /**
     * Attack special figure moves (for pawn)
     * @var Move[]
     */
    protected array $attack = [];
    /**
     * Special figure moves
     * @var Move[]
     */
    protected array $special = [];
    /**
     * Black or white figure
     * @var boolean
     */
    protected bool $is_black = false;
    /**
     * Abstract price of figure to automatic game
     * @var int
     */
    protected int $price = 0;
    /**
     * Rook roque possible only like first step
     * @var boolean
     */
    protected bool $first_step = true;


    /**
     * Create of figure with color determinate
     * @param boolean $is_black
     */
    public function __construct(bool $is_black)
    {
        $this->is_black = $is_black;
    }

    /**
     * Return symbol of figure
     * @return string figure symbol
     */
    abstract public function __toString(): string;

    /**
     * Clean counted moves after actual moving
     * @return AbstractFigure
     */
    public function cleanMoves(): AbstractFigure
    {
        $this->attack = [];
        $this->normal = [];
        $this->special = [];
        return $this;
    }

    /**
     * Get list of possible moves from position start
     * \except simple limitation - NOT desk depended on moves
     * \simple limitation like "first move"
     * @param Move $move - start position
     * @param bool $plain
     * @return Move[]|array of Move
     */
    public function getVacuumHorsePossibleMoves(Move $move, bool $plain = false): array
    {
        if(empty($this->normal)) {
            $this->countVacuumHorsePossibleMoves($move);
        }
        if($plain){
            return array_merge($this->normal, $this->attack, $this->special);
        }
        return ['normal' => $this->normal, 'attack' => $this->attack, 'special' => $this->special];
    }

    /**
     * Count list of possible moves from position start
     * \except simple limitation - NOT desk depended moves
     * \simple limitation like "first move"
     * @param Move $move - start position
     */
    abstract protected function countVacuumHorsePossibleMoves(Move $move): void;

    /**
     * Call after figure move
     * @return void
     */
    public function step(): void
    {
        $this->first_step = false;
        $this->cleanMoves();
    }

    /**
     * @return bool
     */
    public function isFirstStep(): bool
    {
        return $this->first_step;
    }

    /**
     * Return some ktulhu figure price
     * @return int price
     */
    public function price(): int
    {
        return $this->price;
    }

    /**
     * Check black or white
     * @return bool
     */
    public function getIsBlack(): bool
    {
        return $this->is_black;
    }



}
