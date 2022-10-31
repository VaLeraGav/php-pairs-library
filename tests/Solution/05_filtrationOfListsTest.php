<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\toString as listToString;
use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\toString as htmlToString;
use function App\HtmlTags\filter;
use function App\HtmlTags\quotes;
use function App\HtmlTags\removeHeaders;

class FiltrationOfListsTest extends TestCase
{
    protected function setUp(): void
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'scheme'));
        $dom3 = append($dom2, node('p', 'is a lisp'));

        $dom4 = append($dom3, node('h1', 'haskell'));
        $dom5 = append($dom4, node('p', 'is a functional language'));

        $dom6 = append($dom5, node('h1', 'prolog'));
        $this->dom = append($dom6, node('p', 'is about logic'));
    }

    public function testRemoveHeaders()
    {
        $processedDom = removeHeaders($this->dom);

        $result = '<p>is a lisp</p><p>is a functional language</p><p>is about logic</p>';
        $this->assertEquals($result, htmlToString($processedDom));
    }

    public function testFilter()
    {
        $processedDom = filter($this->dom, fn($element) => is('h1', $element));
        $result = '<h1>scheme</h1><h1>haskell</h1><h1>prolog</h1>';
        $this->assertEquals($result, htmlToString($processedDom));

        $processedDom2 = filter($this->dom, fn($element) => is('p', $element));
        $result2 = '<p>is a lisp</p><p>is a functional language</p><p>is about logic</p>';
        $this->assertEquals($result2, htmlToString($processedDom2));
    }

    public function testQuotes()
    {
        $dom0 = make();
        $dom1 = append($dom0, node('h1', 'scheme'));
        $dom2 = append($dom1, node('blockquote', 'live is life'));
        $dom3 = append($dom2, node('p', 'is a lisp'));
        $dom4 = append($dom3, node('blockquote', 'i am sexy, and i know it'));
        $result = l('i am sexy, and i know it', 'live is life');
        $this->assertEquals(listToString($result), listToString(quotes($dom4)));
    }
}
