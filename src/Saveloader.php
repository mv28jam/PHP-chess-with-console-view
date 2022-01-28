<?php

/**
 * Save and load last game data
 *
 * @author yaonkey <yaonkey@gmail.com>
 */
class Saveloader
{
    /**
     * File name for data saving
     */
    const SAVE_FILENAME = 'last.data';

    /**
     * File for load data from self::SAVE_FILENAME
     */
    private $loaded_data;

    /**
     * Saveloader start
     */
    public function __construct()
    {
        if (file_exists(self::SAVE_FILENAME)) {
            $this->loaded_data = file_get_contents(self::SAVE_FILENAME);
        }
    }

    /**
     * Load last game
     * @return stdClass|false
     * @author yaonkey <yaonkey@gmail.com>
     */
    public function loadLastGame() : stdClass|false
    {
        if ($this->loaded_data) {
            return (object)unserialize($this->loaded_data);
        }
        return false;
    }

    /**
     * Save last game to data file
     * @param Desk $data
     * @return void
     */
    public function saveLastGame(Desk $data) : void
    {
        file_put_contents(self::SAVE_FILENAME, serialize($data->toMap()));
    }
}