<?php
declare(strict_types=1);

namespace App\Classes;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class Points
{
    
    /**
     * The bee points array
     *
     * @var array
     */
    private $pointsArr = [];
    
    /**
     * Check it the current value is greater than zero
     * before we try to deduct points
     *
     * @param int $points The current points value
     *
     * @return bool
     */
    public function canDeductPoints(string $key): bool
    {
        $rtn = false;
        
        if ($this->getPoints($key) > 0) {
            $rtn = true;
        }
        
        return $rtn;
    }
    
    /**
     * Update points array for a particular bee
     *
     * @param string $key The bee name
     * @param int $value  The value modifier
     *
     * @return void
     */
    public function updatePoints(string $key, int $value): void
    {
        $this->pointsArr[$key] -= $value;
    }
    
    /**
     * Set the bee points
     *
     * @param string $key The bee name
     * @param int $value  The value modifier
     *
     * @return void
     */
    public function setPoints(string $key, int $value): void
    {
        $this->pointsArr[$key] = $value;
    }
    
    /**
     * Get the bee points
     *
     * @param string $key The bee name
     *
     * @return int
     */
    public function getPoints(string $key): int
    {
        $rtn = 0;
        
        if (isset($this->pointsArr[$key])) {
             $rtn = $this->pointsArr[$key];
        }
        
        return $rtn;
    }
    
    /**
     * Get the entire pointsArr array
     *
     * @return array
     */
    public function getPointsArr(): array
    {
        return $this->pointsArr;
    }
}
