<?php

namespace App\Tests;

//require_once '../lessons/02_RepresentationOfSequences.php';

use PHPUnit\Framework\TestCase;

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\toString as listToString;
use function App\Solution\has;
use function App\Solution\reverse;
use function App\Solution\concat;

class RepresentationOfSequencesTest extends TestCase
{
    public function testHas()
    {
        $numbers = l(3, 4, 5, 8);

        $this->assertTrue(has($numbers, 3));
        $this->assertTrue(has($numbers, 8));
        $this->assertFalse(has($numbers, 0));
        $this->assertFalse(has($numbers, 7));
    }

    public function testConcat()
    {
        $numbers = l(3, 4, 5, 8);
        $numbers2 = l(3, 2, 9);

        $this->assertEquals('(3, 4, 5, 8, 3, 2, 9)', listToString(concat($numbers, $numbers2)));
        $this->assertEquals('(3, 4, 5, 8)', listToString(concat($numbers, l())));
        $this->assertEquals('(3, 2, 9)', listToString(concat(l(), $numbers2)));
        $this->assertEquals(
            '(1, 7, 8, 13, 5, 17, 22, 99, 53, 19, 3, 2, 9)',
            listToString(concat(l(1, 7, 8, 13, 5, 17, 22, 99, 53, 19), $numbers2))
        );
    }

    public function testReverse()
    {
        $numbers = l(3, 4, 5);
        $numbers2 = l(1, 5, 2, 8);

        $this->assertEquals('(5, 4, 3)', listToString(reverse($numbers)));
        $this->assertEquals('(8, 2, 5, 1)', listToString(reverse($numbers2)));
        $this->assertEquals('()', listToString(reverse(l())));
        $this->assertEquals('(1)', listToString(reverse(l(1))));
        $this->assertEquals('(2, 1)', listToString(reverse(l(1, 2))));
    }
}