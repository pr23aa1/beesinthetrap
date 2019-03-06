<?php
declare(strict_types=1);

namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\BeeFactory;
use App\Classes\Bee;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class ApplicationTest extends TestCase
{
    /**
     * Test the bee factory make method returns an
     * instance of App\Classes\Bee
     */
    public function testMakeShouldReturnInstanceOfBee(): void
    {    
        $this->assertInstanceOf(Bee::class, BeeFactory::make('Test', 1, 1, 1, false, 1));      
    }
}