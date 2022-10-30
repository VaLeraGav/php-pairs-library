<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function App\HtmlTags\make;
use function App\HtmlTags\append;
use function App\HtmlTags\node;
use function App\HtmlTags\getName;
use function App\HtmlTags\getValue;
use function App\HtmlTags\toString;

class MarkupTest extends TestCase
{
    public function testMake()
    {
        $dom1 = make();
        $this->assertEquals(l(), $dom1);
    }

    public function testNode()
    {
        $node1 = node('h1', 'hello, world');
        $this->assertEquals('h1', getName($node1));
        $this->assertEquals('hello, world', getValue($node1));
    }

    public function testAppend()
    {
        $dom1 = make();

        $dom2 = append($dom1, node('h1', 'hello, world'));
        $this->assertEquals('h1', getName(head($dom2)));
        $this->assertEquals('hello, world', getValue(head($dom2)));

        $dom = append($dom2, node('h2', 'header2'));
        $this->assertEquals('h2', getName(head($dom)));
        $this->assertEquals('header2', getValue(head($dom)));
        $this->assertEquals('h1', getName(head(tail($dom))));
        $this->assertEquals('hello, world', getValue(head(tail($dom))));
    }

    public function testToString1()
    {
        $result = '';
        $this->assertEquals($result, toString(make()));
    }

    public function testToString2()
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'hello, world'));

        $result = '<h1>hello, world</h1>';
        $this->assertEquals($result, toString($dom2));
    }

    public function testToString3()
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'hello, world'));
        $dom = append($dom2, node('h2', 'header2'));

        $result = '<h1>hello, world</h1><h2>header2</h2>';
        $this->assertEquals($result, toString($dom));
    }

    public function testToString4()
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'hello, world'));
        $dom3 = append($dom2, node('h2', 'hello, world'));
        $dom4 = append($dom3, node('h3', 'hello, world'));
        $dom5 = append($dom4, node('h4', 'hello, world'));
        $dom = append($dom5, node('h5', 'bye-bye!'));

        $result = '<h1>hello, world</h1><h2>hello, world</h2>' .
            '<h3>hello, world</h3><h4>hello, world</h4><h5>bye-bye!</h5>';
        $this->assertEquals($result, toString($dom));
    }
}