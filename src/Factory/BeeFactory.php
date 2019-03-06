<?php
declare(strict_types=1);

namespace App\Factory;

use App\Classes\Bee;

/**
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class BeeFactory
{
    /**
     * Make a new bee
     *
     * @param string $name             The name of the bee type
     * @param int    $points           The points for the individual bee
     * @param int    $hitPoints        The hit points to deduct when the bee is hit
     * @param int    $divisor          The divisor for the bee
     * @param bool   $gameOverWhenDead For when the game is over
     * @param int    $volume           The volume of the bees in the hive
     *
     * @return App\Classes\Bee
     */
    public static function make(
        string $name,
        int $points,
        int $hitPoints,
        int $divisor,
        bool $gameOverWhenDead,
        int $volume
    ): Bee {
        return new Bee(
            $name,
            $points,
            $hitPoints,
            $divisor,
            $gameOverWhenDead,
            $volume
        );
    }
}
