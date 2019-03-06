<?php
declare(strict_types=1);

namespace App\Classes;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class Bee
{
    
    /**
     * The bee name
     *
     * @var string
     */
    private $name;
    
    /**
     * The bee points
     *
     * @var int
     */
    private $points;
    
    /**
     * The bee points to deduct when hit
     *
     * @var int
     */
    private $hitPoints;
    
    /**
     * The bee dividor for the game play operation
     *
     * @var int
     */
    private $divisor;
    
    /**
     * The game over boolean
     *
     * @var bool
     */
    private $gameOverWhenDead;
    
    /**
     * The volume of bees in the hive
     *
     * @var int
     */
    private $volume;
    
    /**
     * Subroutine to handle DI
     *
     * @param string $name           The bee name
     * @param int $points            The bee points
     * @param int $hitPoints         The bee points to deduct when hit
     * @param int $divisor           The bee dividor for the game play operation
     * @param bool $gameOverWhenDead The game over boolean
     * @param int $volume            The volume of bees in the hive
     */
    public function __construct(
        string $name,
        int $points,
        int $hitPoints,
        int $divisor,
        bool $gameOverWhenDead,
        int $volume
    ) {
        $this->name = $name;
        $this->points = $points;
        $this->hitPoints = $hitPoints;
        $this->divisor = $divisor;
        $this->gameOverWhenDead = $gameOverWhenDead;
        $this->volume = $volume;
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
     * Get the points
     *
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
    
    /**
     * Get the points to deduct when a bee is hit
     *
     * @return int
     */
    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }
    
    /**
     * Get the divisor for the modulus game action
     *
     * @return int
     */
    public function getDivisor(): int
    {
        return $this->divisor;
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
    
    /**
     * Get the volume of a bee type to put in the hive
     *
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }
    
    /**
     * Get the total points for the bee types by their
     * points and the volume
     *
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->points * $this->volume;
    }
}
