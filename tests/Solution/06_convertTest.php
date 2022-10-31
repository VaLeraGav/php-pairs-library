<?php


namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;
use function App\HtmlTags\reduce;
use function App\HtmlTags\headersCount;
use function App\HtmlTags\emptyTagsCount;

class ConvertTest extends TestCase
{
    protected function setUp(): void
    {
        $dom1 = make();
        $dom2 = append($dom1, node('h1', 'scheme'));
        $dom3 = append($dom2, node('p', 'is a lisp'));

        $dom4 = append($dom3, node('h1', 'haskell'));
        $dom5 = append($dom4, node('p', 'is a functional language'));

        $dom6 = append($dom5, node('h1', 'prolog'));

        $dom7 = append($dom6, node('h2', ''));
        $dom8 = append($dom7, node('span', ''));
        $this->dom = append($dom8, node('p', 'is about logic'));
    }

    public function testRemoveHeaders()
    {
        $count = headersCount('h1', $this->dom);
        $this->assertEquals(3, $count);
    }

    public function testReduce()
    {
        $count = reduce($this->dom, fn($element, $acc) => is('h1', $element) ? $acc + 1 : $acc, 0);
        $this->assertEquals(3, $count);

        $count2 = reduce($this->dom, fn($element, $acc) => is('span', $element) ? $acc + 1 : $acc, 0);
        $this->assertEquals(1, $count2);

        $count3 = reduce($this->dom, function ($element, $acc) {
            $content = getValue($element);
            return is('h1', $element) ? "{$acc} {$content}" : $acc;
        }, 'Languages:');
        $expected3 = 'Languages: prolog haskell scheme';
        $this->assertEquals($expected3, $count3);

        $count4 = reduce($this->dom, fn($element, $acc) => $acc + 1, 0);
        $this->assertEquals(8, $count4);
    }

    public function testEmptyTagsCount()
    {
        $dom1 = append($this->dom, node('blockquote', ''));
        $dom2 = append($dom1, node('blockquote', ''));
        $dom3 = append($dom2, node('blockquote', 'quote'));
        $dom4 = append($dom3, node('blockquote', ''));
        $dom5 = append(make(), node('blockquote', 'smth'));

        $this->assertEquals(2, emptyTagsCount('blockquote', $dom3));
        $this->assertEquals(3, emptyTagsCount('blockquote', $dom4));
        $this->assertEquals(0, emptyTagsCount('blockquote', $dom5));
        $this->assertEquals(0, emptyTagsCount('p', $dom4));
    }
}