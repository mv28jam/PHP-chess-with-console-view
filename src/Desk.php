<?php

/**
 * Desk of game
 *
 * @author mv28jam <mv28jam@yandex.ru>
 */
class Desk
{
    /**
     * array of figures on desk
     * @var array Figures
     */
    private $figures = [];
    /**
     * Last move flag, first move white so true
     * @var bool $last_move previous move
     * @see AbstractFigure::$is_black
     */
    private $last_move = true;
    /**
     * Move objects - history of game
     * @var array $moves - all game moves
     */
    private $moves = [];

    /**
     * Create chess game desk
     * Set figures
     */
    public function __construct()
    {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }

    /**
     * Move of figure
     * @param Move $move
     * @throws \Exception
     */
    public function move(Move $move): void
    {
        //rewind moves
        end($this->moves);
        //checks
        switch (true) {
            //check for figure in start podition
            case(!$this->isFigureExists($move->getStart())):
                throw new \Exception('No figure in position');
            //check move order white-black-white-etc
            case(!$this->moveOrder($move)):
                throw new \Exception('Other color moves - ' . (new Pawn(!$this->last_move)));
            //check move of figure by this figure rules    
            case($this->figures($move->from)->checkFigureMove($move, $this) < Move::MOVING):
                throw new \Exception('Forbidden move for ' . $this->figures($move->getStart()));
        }
        //check for attack figure of same color    
        if ($this->isSelfAttack($move->getStop())) {
            user_error('Incorrect move check for figure', E_USER_ERROR);
        }
        //save move
        $this->moves[] = $move;
        //kill fugure actions
        if ($this->isFigureExists($move->to)) {
            $this->figures($move->to)->killFigure();
        }
        //move to new position + internal figure actions
        $this->figures[$move->to[0]][$move->to[1]] = $this->figures($move->from)->move($move, $this);
        //move order set
        $this->last_move = $this->figures[$move->to[0]][$move->to[1]]->getIsBlack();
        //unset figure in old position
        unset($this->figures[$move->from[0]][$move->from[1]]);
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
            $this->last_move === $this->figures[$move->from[0]][$move->from[1]]->getIsBlack()
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
            return ($this->getFigureIsBlack($position) !== $this->last_move);
        } else {
            return false;
        }
    }

    /**
     * Get fugure is black
     * @param array $position
     * @return bool|null
     */
    public function getFigureIsBlack(array $position): bool
    {
        $color = false;
        //double check
        if ($this->isFigureExists($position)) {
            $color = $this->figures[$position[0]][$position[1]]->getIsBlack();
        } else {
            user_error('No figure to get color. Check figure exist before get color.', E_USER_ERROR);
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
        $current = current($this->moves) ?: null;
        if (isset($current) and $current instanceof RoqueMove) {
            $rookStart = $current->getStartRookPosition();
            $rookStop = $current->getStopRookPosition();
            $current = new Move(implode('', $rookStart) . '-' . implode('', $rookStop));
        }
        return $current;
    }

    /**
     * Unset figure in position
     * @param array $position like "e5"
     * @return bool
     */
    public function figureUnset(array $position): bool
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
     * Return map of desk like figure price array
     * @return array of stdClass
     */
    public function toMap(): array
    {
        $result = [];
        //
        for ($y = 8; $y >= 1; $y--) {
            for ($x = 'a'; $x <= 'h'; $x++) {
                $res = new stdClass();
                $res->price = (isset($this->figures[$x][$y]) ? $this->figures[$x][$y]->price() : false);
                $res->is_black = (isset($this->figures[$x][$y]) ? $this->figures[$x][$y]->getIsBlack() : null);
                $result[$x][$y] = $res;
            }
        }
        //
        return $result;
    }

    /**
     * Create array of lines echo
     * @return array output
     */
    public function dump(): array
    {
        $result = [];
        //
        for ($y = 8; $y >= 1; $y--) {
            $result[$y] = "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    $result[$y] .= $this->figures[$x][$y] . ' ';
                } else {
                    $result[$y] .= '― ';
                }
            }
        }
        $result[] = "  a b c d e f g h\n";
        //
        return $result;
    }

    public function getFiguresByColor(bool $isBlack = true): array
    {
        $figures = [];
        foreach ($this->figures as $x => $yFigure) {
            foreach ($yFigure as $y => $figure) {
                if ($figure->getIsBlack() === $isBlack) {
                    $figures[$x][$y] = $figure;
                }
            }
        }
        return $figures;
    }

    public function isPositionUnderAttack(array $position, bool $selfColorIsBlack = true): bool
    {
        $enemyFigures = $this->getFiguresByColor(!$selfColorIsBlack);
        foreach ($enemyFigures as $x => $yFigure) {
            foreach ($yFigure as $y => $figure) {
                $inspectedMoveStr = $x . $y . '-' . $position[0] . $position[1];
                $inspectedMove = new Move($inspectedMoveStr);
                $figure->countVacuumHorsePossibleMoves($inspectedMove);
                return $figure->checkFigureMove($inspectedMove, $this) > Move::FORBIDDEN;
            }
        }
        return false;
    }

    public function makeRoque(int $roqueLength): void
    {
        $isBlackRoque = !$this->last_move;
        $isShortRoque = $roqueLength === 3;

        $roque = new RoqueMove($isBlackRoque, $isShortRoque);
        // checking The King
        $kingStart = $roque->getStartKingPosition();
        if (!$this->isFigureExists($kingStart)) {
            throw new \Exception('No King in position');
        }
        $king = $this->figures[$kingStart[0]][$kingStart[1]];
        if (!($king instanceof King)) {
            throw new \Exception('No King in position');
        }
        if ($isBlackRoque != $king->getIsBlack()) {
            throw new \Exception('This is wrong colored king!');
        }
        if (!$king->isFirstStep()) {
            throw new \Exception('The king has already made a move');
        }
        if ($this->isPositionUnderAttack($kingStart, $isBlackRoque)) {
            throw new \Exception('The king in check');
        }

        // checking The Rook
        $rookStart = $roque->getStartRookPosition();
        if (!$this->isFigureExists($rookStart)) {
            throw new \Exception('No Rook in position');
        }
        $rook = $this->figures[$rookStart[0]][$rookStart[1]];
        if (!($rook instanceof Rook)) {
            throw new \Exception('No Rook in position');
        }
        if ($isBlackRoque != $rook->getIsBlack()) {
            throw new \Exception('This is wrong colored Rook!');
        }
        if (!$rook->isFirstStep()) {
            throw new \Exception('The Rook has already made a move');
        }

        foreach ($roque->getToCheckPositions() as $checkedPosition) {
            if ($this->isFigureExists($checkedPosition)) {
                throw new \Exception('There is figure between King and Rook');
            }
            if ($checkedPosition[0] != 'b' and $this->isPositionUnderAttack($checkedPosition, $roque->isBlack())) {
                throw new \Exception('The roque through beaten square or target King position is under attack');
            }
        }
        // save move
        $this->moves[] = $roque;

        //move to new position + internal figure actions
        $kingStop = $roque->getStopKingPosition();
        $kingMove = new Move(implode('', $kingStart) . '-' . implode('', $kingStop));
        $this->figures[$kingStop[0]][$kingStop[1]] = $king->move($kingMove, $this);

        $rookStop = $roque->getStopRookPosition();
        $rookMove = new Move(implode('', $rookStart) . '-' . implode('', $rookStop));
        $this->figures[$rookStop[0]][$rookStop[1]] = $rook->move($rookMove, $this);

        $this->last_move = $roque->isBlack();
        unset($this->figures[$kingStart[0]][$kingStart[1]]);
        unset($this->figures[$rookStart[0]][$rookStart[1]]);
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

}
