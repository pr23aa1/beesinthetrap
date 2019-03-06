<?php
declare(strict_types=1);

namespace App\Classes;

use App\Classes\Bee;
use App\Classes\HitBee;
use App\Classes\Points;
use App\Constants\Strings;
use Exception;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class Hive
{

    /**
     * The bees in the hive
     *
     * @var array
     */
    private $bees = [];
    
    /**
     * IF the game if over
     *
     * @var bool
     */
    private $gameOver = false;
    
    /**
     *
     * @var App\Classes\HitBee
     */
    private $hitObj;
    
    /**
     *
     * @var App\Classes\Points
     */
    private $pointObj;
    
    /**
     * The individual hit bee game over boolean
     * If this ends the game
     * Immutable
     *
     * @var bool
     */
    private $getOverOnZero;
    
    /**
     * Subroutine to handle DI
     *
     * @param App\Classes\HitBee $pointObj The hit bee object
     * @param App\Classes\Points $hitObj The hit bee object
     */
    public function __construct(HitBee $hitObj, Points $pointObj)
    {
        $this->hitObj = $hitObj;
        $this->pointObj = $pointObj;
    }
    
    /**
     * Add a bee object to the class bee array
     *
     * @param App\Classes\Bee $bee The bee object
     *
     * @return void
     */
    public function addBee(Bee $bee): void
    {
        $this->bees[$bee->getName()] = $bee;
    }
    
    /**
     * Calculate the init
     * ial total bee points for each bee
     * type in the hive
     *
     * @return void
     *
     * @throws exception
     */
    public function calcBeePoints(): void
    {
        if (!empty($this->bees)) {
            foreach ($this->bees as $bee) {
                $this->pointObj->setPoints($bee->getName(), $bee->getTotalPoints());
            }
        } else {
            throw new Exception(Strings::NO_BEE_IN_HIVE);
        }
    }
    
    /**
     * Test if a bee is hit
     *
     * @param int $num The number to test the modulus
     *
     * @return Bool
     *
     * @throws Exception
     */
    public function detectHit(int $num): bool
    {
        $rtn = false;
        
        if (!empty($this->bees)) {
            foreach ($this->bees as $bee) {
                // Get the bee divisor to see if it was a hit
                // If the modulus equals zero it was a hit
                if ($num % $bee->getDivisor() == 0) {
                    $rtn = true;
                    
                    // Set
                    $this->hitObj->setName($bee->getName());
                    $this->hitObj->setPoints($bee->getHitPoints());
                    $this->hitObj->setGameOverWhenDead($bee->getGameOverWhenDead());
                    
                    break;
                }
            }
            
            return $rtn;
        } else {
            throw new Exception(Strings::NO_BEE_IN_HIVE);
        }
    }
    
    /**
     * Test and perform the hit on the bee type
     *
     * @return bool
     */
    public function performHit(): bool
    {
        $rtn = false;
        
         $beeName = $this->hitObj->getName();
         $beeHitPoints = $this->hitObj->getPoints();
         $beeGameOver = $this->hitObj->getGameOverWhenDead();
        
        if ($this->pointObj->canDeductPoints($beeName) == true) {
            $this->pointObj->updatePoints($beeName, $beeHitPoints);
            
            $rtn = true;
        
            if ($this->pointObj->getPoints($beeName) <= 0) {
                if ($beeGameOver == true) {
                    $this->gameOver = true;
                }
            }
        } else {
            // no hit message
            $rtn = false;
        }
 
        return $rtn;
    }
 
    /**
     * Show the name of the bee hit
     *
     * @return int
     */
    public function showHitBeeName(): string
    {
        return $this->hitObj->getName();
    }
    
    /**
     * Show the points to be deducted on a hit
     *
     * @return int
     */
    public function showHitBeePoints(): int
    {
        return $this->hitObj->getPoints();
    }
    
    /**
     * Get the total points requires
     * to destroy the hive
     *
     * @return bool
     */
    public function showScoreNeeded(): int
    {
        $sc = 0;
        
        foreach ($this->bees as $bee) {
            $sc += $bee->getTotalPoints();
        }
        
        return $sc;
    }
    
    /**
     * Get if game is over
     *
     * @return bool
     */
    public function getGameOver(): bool
    {
        return $this->gameOver;
    }
}
