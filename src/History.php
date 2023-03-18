<?php

class History
{
    private array $moves;
    private string $movesString;
    public function __construct()
    {
        $this->moves = [];
        $this->movesString = '';
    }

    public function saveGame(Desk $desk, string $fileName = 'last_game'): void
    {
        $this->moves = $desk->getMoves();
        $this->movesToString();
        $file = fopen($fileName, "w");
        fwrite($file, $this->movesString . "\n");
        fclose($file);
    }

    private function movesToString(): void
    {
        $result = [];
        foreach ($this->moves as $move) {
            $result[] = strval($move);
        }
        $this->movesString = implode(Game::DELIMITER, $result);
    }
}