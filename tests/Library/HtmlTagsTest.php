<?php


namespace Php\Html\Tags\tests;

use PHPUnit\Framework\TestCase;

use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\toString;
use function Php\Html\Tags\HtmlTags\addChild;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\map;
use function Php\Html\Tags\HtmlTags\filter;
use function Php\Html\Tags\HtmlTags\reduce;

class HtmlTagsTest extends TestCase
{
    protected function setUp(): void
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h2', 'hello, world'));
        $ul = node('ul');
        $ul2 = addChild($ul, node('li', 'body'));
        $ul3 = addChild($ul2, node('li', 'another body'));
        $dom3 = append($dom2, $ul3);
        $this->dom = append($dom3, node('h2', 'header2'));
    }

    public function testMap()
    {
        $processedDom = map($this->dom, function ($element) {
            if (is('h2', $element)) {
                return node('h3', getValue($element));
            }

            return $element;
        });

        $result = '<h3>hello, world</h3><ul><li>body</li><li>another body</li></ul><h3>header2</h3>';
        $this->assertEquals($result, toString($processedDom));
    }

    public function testFilter()
    {
        $processedDom = filter($this->dom, fn($element) => is('h2', $element));
        $result = '<h2>hello, world</h2><h2>header2</h2>';
        $this->assertEquals($result, toString($processedDom));
    }

    public function testReduce()
    {
        $count = reduce($this->dom, fn($element, $acc) => $acc + 1, 0);
        $this->assertEquals(3, $count);
    }

    public function testMake()
    {
        $tags = make(node('p', 'text'), node('p', 'text2'));
        $result = '<p>text</p><p>text2</p>';
        $this->assertEquals($result, toString($tags));
    }

    public function testToString()
    {
        $p = node('p', 'paragraph');
        $ul = node('ul');
        $ul2 = addChild($ul, node('li', 'body'));
        $ul3 = addChild($ul2, node('li', 'another body'));
        $dom1 = make();
        $dom2 = append($dom1, $p);
        $dom3 = append($dom2, $ul3);
        $result = '<p>paragraph</p><ul><li>body</li><li>another body</li></ul>';
        $this->assertEquals($result, toString($dom3));
    }
}