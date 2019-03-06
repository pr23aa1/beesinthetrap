<?php
declare(strict_types=1);

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use App\Classes\Hive;
use App\Classes\Bee;
use App\Classes\HitBee;
use App\Classes\Points;
use Exception;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class HiveTest extends TestCase
{
    /**
     * @var string
     */
    private $beeName = 'Test';
    
    /**
     * @var int
     */
    private $beePoints = 30;
    
    /**
     * @var prophecy
     */
    private $hitBee;
    
    /**
     * @var prophecy
    */
    private $points;
    
    /**
     * @var App\Classes\Hive
     */
    private $hive;
    
    /**
     * @see PHPUnit\Framework\TestCase::setup()
     */
    public function setUp(): void
    {
       $this->hitBee = $this->prophesize(HitBee::class);      
       $this->points = $this->prophesize(Points::class);
       $this->hive = new Hive($this->hitBee->reveal(), $this->points->reveal());
    }
    
    /**
     * Values to test for subtraction
     */
    public function provider()
    {
        return [
            [1, 1, 0],
            [3, 1, 2],
            [7, 3, 4],
            [17, 7, 10]
        ];
    }
    
    /**
     * Values to test for adding of bee scores
     */
    public function beeProvider()
    {
        return [
            [1, 1, 2],
            [3, 1, 4],
            [7, 3, 10],
            [17, 7, 24]
        ];
    }
    
	/**
     * -------------------------------------------
     * testCalcBeePoints[feature being tested][Should Result]
     * -------------------------------------------
     * Test that the calcBeePoints throw an exception
     * when no bees are added
     */
    public function testcalcbeePointsWhenEmptyShouldThrowException(): void
    {    
        $this->expectException(Exception::class);
        $this->hive->calcBeePoints();
    }
    
    /**
     * -------------------------------------------
     * testDetectHit[feature being tested][Should Result]
     * -------------------------------------------
     * Test that the detectHit throw an exception
     * when no bees are added
     */
    public function testDetecthitWhenEmptyShouldThrowException(): void
    {    
        $this->expectException(Exception::class);
        $this->hive->detectHit(0);
    }
    
    /**
     * Test that the detectHit is true when the modulus 
     * expression equals 0
     */
    public function testDetecthitWhenHitShouldReturnTrue(): void
    {    
        $bee = $this->prophesize(Bee::class);
        $bee->getName()->willReturn($this->beeName);
        $bee->getHitPoints()->willReturn(0);
        $bee->getDivisor()->willReturn(2);
        $bee->getGameOverWhenDead()->willReturn(false);
        
        $this->hive->addBee($bee->reveal());
        
        $this->assertTrue($this->hive->detectHit(4));
    }
    
    /**
     * Test that the detectHit is false when the modulus 
     * expression does not equal 0
     */
    public function testDetecthitWhenHitShouldReturnFalse(): void
    { 
        $bee = $this->prophesize(Bee::class);
        $bee->getName()->willReturn($this->beeName);
        $bee->getHitPoints()->willReturn(0);
        $bee->getDivisor()->willReturn(3);
        $bee->getGameOverWhenDead()->willReturn(false);
        
        $this->hive->addBee($bee->reveal());
        
        $this->assertFalse($this->hive->detectHit(4));
    }
    
	/**
     * -------------------------------------------
     * testPerformHit[feature being tested][Should Result]
     * -------------------------------------------
     * Test perform hit method returns true when the deduction is successful
     */
    public function testPerformhitWhenSatisfyDeductShouldReturnTrue(): void
    {  
        $hitBee = $this->prophesize(HitBee::class);
        $hitBee->getName()->willReturn($this->beeName);
	    $hitBee->getPoints()->willReturn(1);
	    $hitBee->getGameOverWhenDead()->willReturn(false);
	    
        $points = $this->prophesize(Points::class);
        $points->canDeductPoints(Argument::any())->willReturn(true);
        $points->updatePoints(Argument::any(), Argument::any());

	    $points->getPoints(Argument::any())->willReturn(1);
	     
	    $hive = new Hive($hitBee->reveal(), $points->reveal());
       
        $this->assertTrue($hive->performHit());
    }
    
    /**
     * Test perform hit method sets gameover when the total points reach
     * zero for bees marked as game over on dead
     */
    public function testPerformhitWhenSatisfyDeductAndIsZeroShouldSetGameOver(): void
    {    
        $hitBee = $this->prophesize(HitBee::class);
        $hitBee->getName()->willReturn($this->beeName);
	    $hitBee->getPoints()->willReturn(1);
	    $hitBee->getGameOverWhenDead()->willReturn(true);
	    
        $points = $this->prophesize(Points::class);
        $points->canDeductPoints(Argument::any())->willReturn(true);
        $points->updatePoints(Argument::any(), Argument::any());
        $points->getPoints(Argument::any())->willReturn(0);

	    $hive = new Hive($hitBee->reveal(), $points->reveal());
        $hive->performHit();
       
        $this->assertTrue($hive->getGameOver());
    }
    
    /**
     * Test perform hit method returns false when no further deduction 
     * from the bee type can be made
     */
    public function testPerformhitWhenNotSatisfyDeductShouldReturnFalse(): void
    {  
        $this->hitBee->getName()->willReturn($this->beeName);
        $this->hitBee->getPoints()->willReturn(1);
	    $this->hitBee->getGameOverWhenDead()->willReturn(true);

	    $points = $this->prophesize(Points::class);
        $points->getPoints(Argument::any())->willReturn(0);
        $points->canDeductPoints(Argument::any())->willReturn(false);
        
	    $hive = new Hive($this->hitBee->reveal(), $points->reveal());
       
        $this->assertFalse($hive->performHit());
    }
    
	/**
     * -------------------------------------------
     * testShowscoreneeded[feature being tested][Should Result]
     * -------------------------------------------
     * Test the deduct points method should return zero when we pass points
     * of value less than zero
     * @dataProvider beeProvider
     */
    public function testShowscoreneededShouldAdd($a, $b, $c): void
    {
        $bee = $this->prophesize(Bee::class);
        $bee->getTotalPoints()->willReturn($a);
        $bee->getName()->willReturn($this->beeName);
        
        $bee2 = $this->prophesize(Bee::class);
        $bee2->getTotalPoints()->willReturn($b);
        $bee2->getName()->willReturn('Test2');
        
        $this->hive->addBee($bee->reveal());
        $this->hive->addBee($bee2->reveal());
        
        $this->assertEquals($c, $this->hive->showScoreNeeded());
    }

    /**
     * -------------------------------------------
     * testShowHitBeeName[feature being tested][Should Result]
     * -------------------------------------------
     * Test the show bee name returns the input string
     */
    public function testShowhitbeenameShouldReturnString(): void 
    {
        $hitBee = $this->prophesize(HitBee::class);
        $hitBee->getName()->willReturn($this->beeName);
        
        $hive = new Hive($hitBee->reveal(), $this->points->reveal());
        $this->assertEquals($this->beeName, $hive->showHitBeeName());
    }
    
    /**
     * -------------------------------------------
     * testShowHitBeeName[feature being tested][Should Result]
     * -------------------------------------------
     * Test the show bee points returns the input integer
     */
    public function testShowhitbeepointsShouldReturnInteger(): void 
    {
        $hitBee = $this->prophesize(HitBee::class);
        $hitBee->getPoints()->willReturn($this->beePoints);
        
        $hive = new Hive($hitBee->reveal(), $this->points->reveal());
        $this->assertEquals($this->beePoints, $hive->showHitBeePoints());
    }
    
    /**
     * @see PHPUnit\Framework\TestCase::tearDown()
     */
    public function tearDown(): void 
    {
        unset($this->hitBee);
        unset($this->points);
        unset($this->hive);
    }
   
}