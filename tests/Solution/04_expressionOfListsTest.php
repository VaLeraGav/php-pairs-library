<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\toString as htmlToString;
use function App\HtmlTags\map;
use function App\HtmlTags\mirror;
use function App\HtmlTags\b2p;

class ExpressionOfListsTest extends TestCase
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

    public function testB2p()
    {
        $dom1 = append(make(), node('blockquote', 'quote'));
        $processedDom = b2p($dom1);

        $result = '<p>quote</p>';
        $this->assertEquals($result, htmlToString($processedDom));
    }

    public function testMapAsB2p()
    {
        $dom1 = append(make(), node('blockquote', 'quote'));
        $processedDom = map($dom1, function ($element) {
            if (is('blockquote', $element)) {
                return node('p', getValue($element));
            }
            return $element;
        });

        $result = '<p>quote</p>';
        $this->assertEquals($result, htmlToString($processedDom));
    }

    public function testMap()
    {
        $result = map(make(), function () {
        });
        $this->assertEquals('', $result);

        $processedDom = map($this->dom, function ($element) {
            if (is('h1', $element)) {
                return node('h2', getValue($element));
            }
            return $element;
        });

        $result2 = '<h2>scheme</h2><p>is a lisp</p><h2>haskell</h2>' .
            '<p>is a functional language</p><h2>prolog</h2><p>is about logic</p>';
        $this->assertEquals($result2, htmlToString($processedDom));
    }

    public function testMirror()
    {
        $result = '<h1>emehcs</h1><p>psil a si</p><h1>lleksah</h1>' .
            '<p>egaugnal lanoitcnuf a si</p><h1>golorp</h1><p>cigol tuoba si</p>';
        $this->assertEquals($result, htmlToString(mirror($this->dom)));
    }
}