<?php


namespace App\HtmlTags;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';
//require_once '../src/HtmlTags.php';

use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\filter;
use function Php\Html\Tags\HtmlTags\map;
use function Php\Html\Tags\HtmlTags\reduce;

use function Php\Html\Tags\HtmlTags\toString as htmlToString;

function extractHeaders($html)
{
    $headers = filter($html, function ($node) {
        return is('h2', $node);
    });
    return map($headers, fn($node) => node('p', getValue($node)));
}


function wordsCount(string $tagName, string $word, $html)
{
    $filtered = filter($html, fn($node) => is($tagName, $node));
    return reduce($filtered, function ($node, $acc) use ($word) {
        return $acc + \substr_count(getValue($node), $word);
    }, 0);

//    $filtered = filter($elements, fn($element) => is($tagName, $element));
//    $values = map($filtered, fn($element) => getValue($element));
//    return reduce($values, fn($text, $acc) => substr_count($text, $word) + $acc, 0);
}

//$html1 = append(make(), node('h2', 'header1'));
//$html2 = append($html1, node('h2', 'header2'));
//$html3 = append($html2, node('p', 'content'));
//
//print_r(htmlToString(extractHeaders($html3)));
//// <h2>header1</h2><h2>header2</h2><p>content</p>

//$html1 = append(make(), node('h2', 'header1 lisp'));
//$html2 = append($html1, node('p', 'content'));
//$html3 = append($html2, node('h2', 'lisp header2 lisp'));
//$html4 = append($html3, node('p', 'content lisp'));
//
//print_r(wordsCount('h2', 'lisp', $html4)); // 3