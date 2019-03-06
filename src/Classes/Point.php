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
     * The points array
     *
     * @var array
     */
    private $points = [];
    
    public function updatePoints($key, $value): void
    {
        $this->points[$key] -= $value;
    }
    
    public function setPoints($key, $value): void
    {
        $this->points[$key] = $value;
    }
    
    public function getPoints($key): interger
    {
        $rtn = 0;
        
        if (isset($this->points[$key])) {
             $rtn = $this->points[$key];
        }
        
        return $rtn;
    }
}
