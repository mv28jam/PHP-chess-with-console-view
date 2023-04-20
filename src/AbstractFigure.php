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
    public array $normal = [];
    /**
     * Attack special figure moves (for pawn)
     * @var Move[]
     */
    public array $attack = [];
    /**
     * Special figure moves
     * @var Move[]
     */
    public array $special = [];
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
    private bool $first_step = true;

    /**
     * Create of figure with color determinate
     * @param boolean $is_black
     */
    public function __construct(bool $is_black)
    {
        $this->is_black = $is_black;
    }

    /**
     * Check move
     * @param Move $move Move object
     * @param Desk $desk
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move @see Move
     */
    abstract public function checkFigureMove(Move $move, Desk $desk): int;

    /**
     * Return symbol of figure
     * @return string figure symbol
     */
    abstract public function __toString(): string;

    /**
     * Move figure finally + internal actions
     * @param Move $move move object
     * @param Desk $desk
     * @return MoveResult
     */
    public function processMove(Move $move, Desk $desk): MoveResult
    {
        //
        $res = (new MoveResult())
            ->setFigure($this)
            ->setMove($this->findResultMove($move));
        //clean counted
        $this->cleanMoves();
        //
        return $res;
    }

    /**
     * Clean counted moves after actual moving
     */
    public function cleanMoves(): void
    {
        $this->attack = [];
        $this->normal = [];
        $this->special = [];
    }

    /**
     * Find move that has been done in game to process actions
     * @param Move $move
     * @return Move
     */
    protected function findResultMove(Move $move): Move
    {
        //
        foreach (array_merge($this->attack, $this->normal, $this->special) as $val){
            if($val->strFrom == $move->strFrom and $val->strTo == $move->strTo){
                return $val;
            }
        }
        //unexpected
        return $move;
    }

    /**
     * Get list of possible moves from position start
     * \except simple limitation - NOT desk depended moves
     * \simple limitation like "first move"
     * @param Move $move - start position
     * @return array of Move
     */
    public function getVacuumHorsePossibleMoves(Move $move): array
    {
        $this->countVacuumHorsePossibleMoves($move);
        return array_merge($this->attack, $this->normal, $this->special);
    }

    /**
     * Count list of possible moves from position start
     * \except simple limitation - NOT desk depended moves
     * \simple limitation like "first move"
     * @param Move $move - start position
     */
    abstract public function countVacuumHorsePossibleMoves(Move $move): void;

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

    /**
     * Destruction of figure actions result of attack
     * @return void
     */
    public function destructFigure(): void  {}


}
