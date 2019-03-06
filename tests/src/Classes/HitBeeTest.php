<?php
declare(strict_types=1);

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;
use App\Classes\HitBee;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class HitBeeTest extends TestCase
{
	/**
     * Test that the result of the getter is the same as the setter
     * and not modifications have been made
     */
    public function testSettersAndGettersShouldReturnUnmodified(): void
    {    
        $ma = ["Test", 1, true];
        list($a, $b, $c) = $ma;
        
        $obj = new HitBee();
        $obj->setName($a);
        $obj->setPoints($b);
        $obj->setGameOverWhenDead($c);
        
        $this->assertEquals($a, $obj->getName());
        $this->assertEquals($b, $obj->getPoints());
        $this->assertEquals($c, $obj->getGameOverWhenDead());
    }
}