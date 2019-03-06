<?php
declare(strict_types=1);

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;
use App\Classes\Bee;

/*
 * This file is part of the Hive Game Tests
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
final class BeeTest extends TestCase
{
    /**
     * Test that the total points returned from getTotalPoints
     * is equal to points * volume
     */
    public function testGetTotalPointsShouldMultiply(): void
    {    
        $obj = new Bee('Test', 7, 1, 1, false, 8);
        $this->assertEquals((7*8), $obj->getTotalPoints());
    }
}