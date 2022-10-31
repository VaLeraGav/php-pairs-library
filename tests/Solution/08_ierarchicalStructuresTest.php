<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\length;
use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function App\Select\select;

class IerarchicalStructuresTest extends TestCase
{
    protected function setUp(): void
    {
        $dom1 = make();
        $children1 = l(node('a', l(node('span', 'scheme'))));
        $dom2 = append($dom1, node('h1', $children1));
        $dom3 = append($dom2, node('p', 'is a lisp'));
        $children2 = l(node('li', 'item 1'), node('li', 'item 2'));
        $dom4 = append($dom3, node('ul', $children2));
        $children3 = l(node('li', 'item 1'), node('li', 'item 2'));
        $dom5 = append($dom4, node('ol', $children3));
        $dom6 = append($dom5, node('p', 'is a functional language'));
        $children4 = l(node('li', 'item'));
        $dom7 = append($dom6, node('ul', $children4));
        $dom8 = append($dom7, node('div', l(node('p', 'another text'))));
        $dom9 = append($dom8, node('div', l(node('div', l(node('p', l(node('span', 'text'))))))));
        $dom10 = append($dom9, node('h1', 'prolog'));
        $this->dom = append($dom10, node('p', 'is about logic'));
    }

    public function testExtractHeaders()
    {
        $this->assertEquals(2, length(select('span', $this->dom)));
        $this->assertEquals(0, length(select('section', $this->dom)));
        $this->assertEquals(5, length(select('li', $this->dom)));
        $this->assertEquals(5, length(select('p', $this->dom)));
        $this->assertEquals(2, length(select('h1', $this->dom)));
        $this->assertEquals(3, length(select('div', $this->dom)));
    }
}