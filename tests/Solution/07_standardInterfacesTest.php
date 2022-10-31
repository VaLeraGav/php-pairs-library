<?php


namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\toString as htmlToString;
use function App\HtmlTags\extractHeaders;
use function App\HtmlTags\wordsCount;

class StandardInterfacesTest extends TestCase
{
    protected function setUp(): void
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'scheme'));
        $dom3 = append($dom2, node('p', 'is a lisp'));

        $dom4 = append($dom3, node('h2', 'haskell'));
        $dom5 = append($dom4, node('p', 'is a functional language'));

        $dom6 = append($dom5, node('h2', 'prolog'));
        $dom7 = append($dom6, node('p', 'sicp'));
        $dom8 = append($dom7, node('blockquote', 'haskell haskell'));
        $dom9 = append($dom8, node('blockquote', 'quote'));
        $dom10 = append($dom9, node('h2', 'haskell'));
        $this->dom = append($dom10, node('p', 'is about logic haskell'));
    }

    public function testExtractHeaders()
    {
        $headersAsP = extractHeaders($this->dom);
        $result = '<p>haskell</p><p>prolog</p><p>haskell</p>';
        $this->assertEquals($result, htmlToString($headersAsP));
    }

    public function testWordsCount()
    {
        $this->assertEquals(0, wordsCount('i', 'scheme', $this->dom));
        $this->assertEquals(0, wordsCount('h1', 'undefined', $this->dom));
        $this->assertEquals(1, wordsCount('h1', 'scheme', $this->dom));
        $this->assertEquals(2, wordsCount('blockquote', 'haskell', $this->dom));
        $this->assertEquals(2, wordsCount('h2', 'haskell', $this->dom));
        $this->assertEquals(0, wordsCount('h2', 'h2', $this->dom));
    }
}
