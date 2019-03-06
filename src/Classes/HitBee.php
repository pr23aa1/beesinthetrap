<?php
declare(strict_types=1);

namespace App\Classes;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class HitBee
{
    /**
     * The bee name
     *
     * @var string
     */
    private $name;
    
    /**
     * The bee points to deduct when
     *
     * @var int
     */
    private $points;
    
    /**
     * The game over boolean
     *
     * @var bool
     */
    private $gameOverWhenDead;
    
    /**
     * Set the bee name
     *
     * @param string
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Set the points to deduct when a bee is
     *
     * @param int
     *
     * @return void
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
    
    /**
     * Set game over boolean
     *
     * @param $gameOverWhenDead bool
     *
     * @return void
     */
    public function setGameOverWhenDead(bool $gameOverWhenDead): void
    {
         $this->gameOverWhenDead = $gameOverWhenDead;
    }
    
    /**
     * Get the bee name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Get the points to deduct when a bee is
     *
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
    
    /**
     * Get the boolean for if the game is over
     *
     * @return bool
     */
    public function getGameOverWhenDead(): bool
    {
        return $this->gameOverWhenDead;
    }
}
