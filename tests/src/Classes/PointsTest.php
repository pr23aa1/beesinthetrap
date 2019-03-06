<?php
declare(strict_types=1);

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;
use App\Classes\Points;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class PointsTest extends TestCase
{
    
	/**
     * -------------------------------------------
     * testArray[feature being tested][Should Result]
     * -------------------------------------------
     * Test that the array populates correctly
     */
    public function testArrayKeyExists(): void
    {    
        $ma = ["Bee A", "Bee B", "Bee c"];
        list($a, $b, $c) = $ma;
        
        $obj = new Points();
        $obj->setPoints($a, 10);
        $obj->setPoints($b, 77);
        $obj->setPoints($c, 2);
        
        $res = $obj->getPointsArr();
        
        $this->assertTrue(array_key_exists($a, $res));
        $this->assertTrue(array_key_exists($b, $res));
        $this->assertTrue(array_key_exists($c, $res));
    }
    
	/**
     * -------------------------------------------
     * testGetpoints[feature being tested][Should Result]
     * -------------------------------------------
     * Test that the get points returns expected values
     */
    public function testGetpointsShouldReturnArray(): void
    {    
        $ma = ["Bee A", "Bee B"];
        $maa = [101, 102];
        list($b, $b1) = $ma;
        list($i, $i1) = $maa;
       
        $obj = new Points();
        $obj->setPoints($b, $i);
        $obj->setPoints($b1, $i1);
      
        $this->assertEquals($i, $obj->getPoints($b));
        $this->assertEquals($i1, $obj->getPoints($b1));
    }
    
	/**
     * -------------------------------------------
     * testGetpoints[feature being tested][Should Result]
     * -------------------------------------------
     * Test that the get points returns 0 if key is not
     * found in the array
     */
    public function testGetpointsShouldReturnZero(): void
    {    
        $ab = "AB";
       
        $obj = new Points();
        $obj->setPoints($ab, 10);
      
        $this->assertEquals(0, $obj->getPoints("Foo"));
    }
    
    /**
     * -------------------------------------------
     * testUpdatepoints[feature being tested][Should Result]
     * -------------------------------------------
     * Test that updating the points subtracts correctly
     */
    public function testUpdatepoints(): void
    { 
        $ma = ["Bee A", "Bee B"];
        $maa = [101, 10];
        list($b, $b1) = $ma;
        list($i, $i1) = $maa;
       
        $obj = new Points();
        $obj->setPoints($b, $i);
        $obj->setPoints($b1, $i1);
        
        // First set of substitution
        $obj->updatePoints($b, 90);
        $obj->updatePoints($b1, 4);
        
        $this->assertEquals(($i - 90), $obj->getPoints($b));
        $this->assertEquals(($i1 - 4), $obj->getPoints($b1));
        
        // Second set of substitution
        $obj->updatePoints($b, 10);
        $obj->updatePoints($b1, 4);
        
        $this->assertEquals(1, $obj->getPoints($b));
        $this->assertEquals(2, $obj->getPoints($b1));
    }
    
    /**
     * -------------------------------------------
     * testCanDeductPoints[feature being tested][Should Result]
     * -------------------------------------------
     * Test the can deduct points method is true when we pass a value
     * that is greater than zero
     */
    public function testCandeductdointsWhenGtZeroShouldReturnTrue(): void
    {    
        $ab = "AB";
       
        $obj = new Points();
        $obj->setPoints($ab, 10);
        
        $this->assertTrue($obj->canDeductPoints($ab));
    }
    
    /**
     * Test the can deduct points method is false when we pass a value
     * that is zero
     */
    public function testCandeductdointsWhenEqZeroShouldReturnFalse(): void
    {    
        $ab = "AB";
       
        $obj = new Points();
        $obj->setPoints($ab, 0);
        
        $this->assertFalse($obj->canDeductPoints($ab));
    }
    
    /**
     * Test the can deduct points method is false when we pass a value
     * less than zero
     */
    public function testCandeductdointsWhenltZeroShouldReturnFalse(): void
    {    
        $ab = "AB";
       
        $obj = new Points();
        $obj->setPoints($ab, -1);
        
        $this->assertFalse($obj->canDeductPoints($ab));
    }
    
}