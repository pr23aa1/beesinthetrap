<?php
declare(strict_types=1);

namespace Tests\Classes;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use App\Classes\Application;
use App\Classes\Hive;
use App\Constants\Strings;
use App\Constants\Status;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class ApplicationTest extends TestCase
{
    /**
     * @var App\Classes\Hive
     */
    private $simpleHive;
    
    /**
     * @var App\Classes\Hive
     */
    private $hive;
    
    /**
     * @var string
     */
    private $test = 'Test';
    
    /**
     * @var int
     */
    private $points = 0;
    
    /**
     * @see PHPUnit\Framework\TestCase::setup()
     */
    public function setUp(): void
    {
       $this->simpleHive = $this->prophesize(Hive::class);
       
       $this->hive = $this->prophesize(Hive::class);
       $this->hive->showHitBeeName()->willReturn($this->test);
       $this->hive->showHitBeePoints()->willReturn($this->points);    
    }
    
	/**
     * -------------------------------------------
     * testRun[feature being tested]
     * -------------------------------------------
     * Test that run method sets the no hit message and 
     * set the status to terminate
     */
    public function testRunWhenCmdIsNotHitShouldOutputNoHitMessageAndStatusContinue(): void
    {
        $s = 'fake';
        $msg = Strings::CMD_HASH .  sprintf(Strings::MSG_CMD_NOT_FOUND, $s) . Strings::LINE_RETURN;
        
        $this->expectOutputString($msg);
             
        $obj = new Application($this->simpleHive->reveal(), $s, 1);  
        $obj->run();
        $this->assertEquals(Status::APP_CONTINUE, $obj->getStatus());       
    }
    
    /**
     * Test that run method sets the no hit message and 
     * set the status to continue whne hit is false
     */
    public function testRunWhenHitIsFalseShouldOutputNoHitMessageAndStatusContinue(): void
    {
        $this->expectOutputString(Strings::CMD_HASH . Strings::MSG_NO_HIT . Strings::LINE_RETURN);
        
        $this->hive->getGameOver()->willReturn(false);
        $this->hive->detectHit(Argument::any())->willReturn(false);
                        
        $obj = new Application($this->hive->reveal(), Strings::CMD_HIT, 1);  
        $obj->run();
        $this->assertEquals(Status::APP_CONTINUE, $obj->getStatus());     
    }
 
    /**
     * Test that run method sets the no hit message and 
     * set the status to continue when the perform hit is false
     */
    public function testRunWhenPerformHitIsFalseShouldOutputNoHitMessageAndStatusContinue(): void
    {
        $this->expectOutputString(Strings::CMD_HASH . Strings::MSG_NO_HIT . Strings::LINE_RETURN);
        
        $this->hive->getGameOver()->willReturn(false);
        $this->hive->detectHit(Argument::any())->willReturn(false);
        $this->hive->performHit()->willReturn(false);
                        
        $obj = new Application($this->hive->reveal(), Strings::CMD_HIT, 1);  
        $obj->run();
        $this->assertEquals(Status::APP_CONTINUE, $obj->getStatus());    
    }
    
    /**
     * Test that run method sets the hit message and 
     * set the status to continue when the perform hit is true
     */
    public function testRunWhenPerformHitIsTrueShouldOutputHitMessageAndStatusContinue(): void
    {   
        $this->expectOutputString(Strings::CMD_HASH . sprintf(Strings::MSG_HIT, $this->test, $this->points) . Strings::LINE_RETURN);
        
        $this->hive->getGameOver()->willReturn(false);
        $this->hive->detectHit(Argument::any())->willReturn(true);
        $this->hive->performHit()->willReturn(true);
                        
        $obj = new Application($this->hive->reveal(), Strings::CMD_HIT, 1);  
        $obj->run();    
        $this->assertEquals(Status::APP_CONTINUE, $obj->getStatus());  
    }
    
    /**
     * Test that run method sets the game over message and 
     * set the status to terminate when the game over is triggered
     */
    public function testRunWhenGameOverShouldOutputGameOverMessageAndStatusTerminate(): void
    {
        $this->expectOutputString(Strings::CMD_HASH . Strings::MSG_GAME_OVER . Strings::LINE_RETURN);
        
        $this->hive->getGameOver()->willReturn(true);
        $this->hive->detectHit(Argument::any())->willReturn(true);
        $this->hive->performHit()->willReturn(true);
                        
        $obj = new Application($this->hive->reveal(), Strings::CMD_HIT, 1);  
        $obj->run();
        $this->assertEquals(Status::APP_TERMINATE, $obj->getStatus());  
    }
    
 	/**
     * Test that run method sets the game quit message and 
     * set the status to terminate when the user uses the quit game cmd
     */
    public function testRunWhenQuitCmdShouldOutputScoreMessageAndStatusTerminate(): void
    {
        $score = 100;
        
        $this->expectOutputString(Strings::CMD_HASH . sprintf(Strings::MSG_GAME_QUIT, $score) . Strings::LINE_RETURN);
        
        $this->hive->showScoreNeeded()->willReturn($score);
                        
        $obj = new Application($this->hive->reveal(), Strings::CMD_QUIT, 1);  
        $obj->run();
        $this->assertEquals(Status::APP_TERMINATE, $obj->getStatus());     
    }
        
    /**
     * -------------------------------------------
     * testEchoGameIntro[feature being tested]
     * -------------------------------------------
     * Test that the echo game intro echos
     * a specific string
     */
    public function testEchoGameIntroShouldOutputString(): void
    {
        $m = Strings::INTRO;
        $m .= Strings::INTRO_1;
        $m .= Strings::INTRO_2;
        $m .= Strings::INTRO_3;
        
        $this->expectOutputString($m);    
        $obj = new Application( $this->simpleHive->reveal(), null, 1);
        $obj->echoGameIntro();
    }
   

    /**
     * -------------------------------------------
     * testWriteMessage[feature being tested]
     * -------------------------------------------
     * Test that the write message returns a specific string
     */
    public function testWriteMessageShouldReturnString(): void
    {
        $obj = new Application($this->simpleHive->reveal(), null, 1);  
        $this->assertEquals(Strings::MSG_NO_HIT . Strings::LINE_RETURN, $obj->writeMessage()); 
    }
    
	/**
     * -------------------------------------------
     * testWriteNoticeMessage[feature being tested]
     * -------------------------------------------
     * Test that the write notice message returns a specific string
     */
    public function testWriteNoticeMessageShouldReturnString(): void
    {
        $cmd = 'foo';
        $msg = sprintf(Strings::MSG_CMD_NOT_FOUND, $cmd) . Strings::LINE_RETURN;
        
        $obj = new Application($this->simpleHive->reveal(), null, 1);  
        $this->assertEquals($msg, $obj->writeNoticeMessage('cmdNotFound', $cmd));
    }

	/**
     * -------------------------------------------
     * testWriteQuitMessage[feature being tested]
     * -------------------------------------------
     * Test that the write quit message returns a specific string
     */
    public function testWriteQuitMessageShouldReturnString(): void
    {
        $i = 10;
        $msg = sprintf(Strings::MSG_GAME_QUIT, $i) . Strings::LINE_RETURN;
        
        $obj = new Application($this->simpleHive->reveal(), null, 1);  
        $this->assertEquals($msg, $obj->writeQuitMessage('gameQuit', $i)); 
    }
    
    /**
     * -------------------------------------------
     * testWriteHitMessage[feature being tested]
     * -------------------------------------------
     * Test that the write hit message returns a specific string
     */
    public function testWriteHitMessageShouldReturnString(): void
    {
        $s = 'Test';
        $i = 1;
        $msg = "You hit a Test, 1 point have been deducted" . Strings::LINE_RETURN;
        
        $obj = new Application($this->simpleHive->reveal(), null, 1);  
        $this->assertEquals($msg, $obj->writeHitMessage('hit', $s, $i)); 
    }

    /**
     * @see PHPUnit\Framework\TestCase::tearDown()
     */
    public function tearDown(): void 
    {
        unset($this->simpleHive);
        unset($this->hive);
    }
}