<?php

/**
 * Desk of game
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Desk
{

    const COLOR_BLACK = true;
    const COLOR_WHITE = false;

    /**
     * array of figures on desk
     * @var AbstractFigure[][]
     */
    private array $figures = [];
    /**
     * Last move flag, first move white so true
     * @var bool $color
     * @see AbstractFigure::$is_black
     */
    private bool $color = self::COLOR_BLACK;
    /**
     * Move objects - history of game
     * @var Move[] $moves - all game moves
     */
    private array $moves = [];
    /**
     * @var DeskCondition
     */
    public DeskCondition $condition;

    /**
     * Create chess game desk
     * Set figures
     */
    public function __construct()
    {
        $this->figures['a'][1] = new Rook(self::COLOR_WHITE);
        $this->figures['b'][1] = new Knight(self::COLOR_WHITE);
        $this->figures['c'][1] = new Bishop(self::COLOR_WHITE);
        $this->figures['d'][1] = new Queen(self::COLOR_WHITE);
        $this->figures['e'][1] = new King(self::COLOR_WHITE);
        $this->figures['f'][1] = new Bishop(self::COLOR_WHITE);
        $this->figures['g'][1] = new Knight(self::COLOR_WHITE);
        $this->figures['h'][1] = new Rook(self::COLOR_WHITE);

        $this->figures['a'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['b'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['c'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['d'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['e'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['f'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['g'][2] = new Pawn(self::COLOR_WHITE);
        $this->figures['h'][2] = new Pawn(self::COLOR_WHITE);

        $this->figures['a'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['b'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['c'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['d'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['e'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['f'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['g'][7] = new Pawn(self::COLOR_BLACK);
        $this->figures['h'][7] = new Pawn(self::COLOR_BLACK);

        $this->figures['a'][8] = new Rook(self::COLOR_BLACK);
        $this->figures['b'][8] = new Knight(self::COLOR_BLACK);
        $this->figures['c'][8] = new Bishop(self::COLOR_BLACK);
        $this->figures['d'][8] = new Queen(self::COLOR_BLACK);
        $this->figures['e'][8] = new King(self::COLOR_BLACK);
        $this->figures['f'][8] = new Bishop(self::COLOR_BLACK);
        $this->figures['g'][8] = new Knight(self::COLOR_BLACK);
        $this->figures['h'][8] = new Rook(self::COLOR_BLACK);

        //
        $this->condition = new DeskCondition();
    }

    /**
     * Move of figure
     * @param Move $move
     * @return string
     * @throws EndGameException
     * @throws Exception
     */
    public function move(Move $move): string
    {
        //rewind moves
        end($this->moves);
        //checks
        switch (true) {
            //check for figure in start position
            case(!$this->isFigureExists($move->getStart())):
                throw new \Exception('No figure in position');
            //check move order white-black-white-etc
            case(!$this->moveOrder($move)):
                throw new \Exception('Other color moves - ' . (new Pawn(!$this->color)));
            //check move of figure by this figure rules
            case($this->condition->checkFigureMove($move, $this->figures($move->from), $this) < Move::MOVING):
            case($this->condition->isKingUnderAttackAfterMove($move, $this->figures($move->from)->getIsBlack(), $this)):
                throw new \Exception('Forbidden move for ' . $this->figures($move->getStart()));

        }
        //move to new position + internal figure actions
        $this->moveActions($move);
        //
        return $this->afterMoveCondition();
    }

    /**
     * @param Move $move
     * @return void
     * @throws Exception
     */
    public function moveActions(Move $move): void
    {
        //get result of move
        $res = $this->condition->processMove($move, $this->figures($move->from), $this);
        //set figure result of move in position
        $this->figures[$move->to[0]][$move->to[1]] = $res->getFigure();
        //kill figures
        foreach ($res->getMove()->getKill() as $val) {
            if(empty($val)) break;
            $this->figureRemove($val);
        }
        //move figures
        foreach ($res->getMove()->getTransfer() as $val) {
            if(empty($val)) break;
            $key = key($val);
            $val = str_split($val[$key]);
            $this->figures[$val[0]][$val[1]] = $this->figures[$key[0]][$key[1]];
            $this->figureRemove(str_split($key));
        }
        //
        unset($res);
        //unset figure in old position
        $this->figureRemove($move->from);
        //save history
        $this->moveHistory($move);
    }

    /**
     * Check for standard chess situations
     * @return string
     * @throws EndGameException
     * @throws Exception
     */
    public function afterMoveCondition(): string
    {
        $info = '';
        if($this->condition->isEndGameBy2Kings($this)){
            throw new EndGameException('Game over. 2 kings on desk - nobody wins by '.end($this->moves));
        }
        //there is check
        if($this->condition->isKingUnderAttack(!$this->color, $this)){
            if($this->condition->isEndGameByCheckmate(!$this->color, $this)){
                throw new EndGameException('Game over. Checkmate. ' . (new Pawn($this->color)) . ' wins by '.end($this->moves));
            }
            $info = 'Check. King ' . (new King(!$this->color).' under attack!' );
        }else{
            if($this->condition->isEndGameByStalemate(!$this->color, $this)){
                throw new EndGameException('Game over. Stalemate, nobody wins by '.end($this->moves));
            }
        }
        //
        return $info;
    }

    /**
     * Desk move internal history and flags set
     * @param Move $move
     * @return void
     */
    public function moveHistory(Move $move): void
    {
        //save move
        $this->moves[] = $move;
        //move order set
        $this->color = $this->figures[$move->to[0]][$move->to[1]]->getIsBlack();
    }

    /**
     * Desk move history
     * @return string
     */
    public function getMoveHistory(): string
    {
        $res = [];
        //
        foreach($this->moves as $move){
            $res[] = (string)$move;
        }
        //
        return implode(Move::DELIMITER ,$res);
    }

    /**
     * Check for figure in position
     * @param array $position
     * @return bool
     */
    public function isFigureExists(array $position): bool
    {
        return isset($this->figures[$position[0]][$position[1]]);
    }

    /**
     * Check for move order white-black-white...
     * @param Move $move
     * @return bool true if order is right false if no
     */
    protected function moveOrder(Move $move): bool
    {
        if (
            $this->color === $this->figures[$move->from[0]][$move->from[1]]->getIsBlack()
        ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get figure in position
     * @param array $position
     * @return AbstractFigure
     */
    protected function figures(array $position): AbstractFigure
    {
        return $this->figures[$position[0]][$position[1]];
    }

    /**
     * Check for self attack
     * @param array $position
     * @return bool
     */
    public function isSelfAttack(array $position): bool
    {
        if ($this->isFigureExists($position)) {
            return ($this->getFigureIsBlack($position) !== $this->color);
        } else {
            return false;
        }
    }

    /**
     * Get fugure is black
     * @param array $position
     * @return bool
     */
    public function getFigureIsBlack(array $position): bool
    {
        $color = false;
        //double check
        if ($this->isFigureExists($position)) {
            $color = $this->figures[$position[0]][$position[1]]->getIsBlack();
        } else {
            user_error('No figure in '.implode($position).' to get color. Check figure exist before get color.', E_USER_ERROR);
        }
        //
        return $color;
    }

    /**
     * Get last move of game
     * @return Move|null
     */
    public function getLastMove(): ?Move
    {
        return (current($this->moves) ?: null);
    }

    /**
     * Unset figure in position
     * @param array $position like "e5"
     * @return bool
     */
    protected function figureRemove(array $position): bool
    {
        if ($this->isFigureExists($position)) {
            unset($this->figures[$position[0]][$position[1]]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get figure price
     * @param array $position
     * @return int
     */
    public function getFigurePrice(array $position): int
    {
        if ($this->isFigureExists($position)) {
            return $this->figures[$position[0]][$position[1]]->price();
        }
        //
        return Move::MOVING;
    }

    /**
     * Get figure clone to compare
     * @param array $position
     * @return AbstractFigure|null
     */
    public function getFigureClone(array $position): ?AbstractFigure
    {
        if ($this->isFigureExists($position)) {
            return (clone $this->figures[$position[0]][$position[1]])->cleanMoves();
        }
        //
        return null;
    }

    /**
     * Clone of desk to check state sensitive moves
     * @return Desk
     */
    public function getDeskClone(): Desk
    {
        return clone $this;
    }

    /**
     * @return bool
     */
    public function getOrderColor(): bool
    {
        return $this->color;
    }

    /**
     * Return map of desk like figure price array
     * @return stdClass[]
     */
    public function toMap(): array
    {
        $result = [];
        //
        for ($y = 8; $y >= 1; $y--) {
            for ($x = 'a'; $x <= 'h'; $x++) {
                $res = new stdClass();
                $res->fig = (isset($this->figures[$x][$y]) ? get_class($this->figures[$x][$y]) : '');
                $res->is_black = (isset($this->figures[$x][$y]) ? $this->figures[$x][$y]->getIsBlack() : null);
                $result[$x][$y] = $res;
            }
        }
        //
        return $result;
    }

    /**
     * Create array of lines echo
     * @return string[] output
     */
    public function dump(): array
    {
        $result = [];
        //
        for ($y = 8; $y >= 1; $y--) {
            $result[$y] = "$y ";
            $k=0;
            for ($x = 'a'; $x <= 'h'; $x++) {
                $k++;
                if (isset($this->figures[$x][$y])) {
                    $result[$y] .= $this->figures[$x][$y] . ' ';
                } else {
                    if(($y+$k)%2){
                        $result[$y] .= '■ ';
                    }else{
                        $result[$y] .= '□ ';
                    }
                }
            }
        }
        $result[] = "  a b c d e f g h\n";
        //
        return $result;
    }

    /**
     * In desc array of objects has to be cloned
     * otherwise it will be modified by DescConditions
     * @return void
     */
    function __clone()
    {
        //
        $cloned_figures = [];
        foreach ($this->figures as $key => $val){
            foreach ($val as $key2 => $val2){
                if(!empty($val2)){
                    $cloned_figures[$key][$key2] = clone $val2;
                }else{
                    $cloned_figures[$key][$key2] = null;
                }
            }
        }
        $this->figures = $cloned_figures;
        //
        $cloned_moves = [];
        foreach ($this->moves as $key => $val){
            $cloned_moves[$key] = clone $val;
        }
        $this->moves = $cloned_moves;
    }
}
