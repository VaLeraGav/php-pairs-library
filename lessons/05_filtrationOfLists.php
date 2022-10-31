<?php

namespace App\HtmlTags;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';
//require_once '../src/HtmlTags.php';

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\cons;
use function Php\Pairs\Data\Lists\reverse;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Pairs\Data\Lists\toString as listToString;

use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\map;
use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\toString as htmlToString;

function filter($dom, callable $func)
{
    if (isEmpty($dom)) {
        return l();
    }
    $iter = function ($dom, $acc) use ($func, &$iter) {
        if (isEmpty($dom)) {
            return reverse($acc);
        }
        $node = head($dom);
        $rest = tail($dom);
        if ($func($node)) {
            return $iter($rest, cons($node, $acc));
        }
        return $iter(tail($dom), $acc);
    };
    return $iter($dom, l());

// teacher`s decision
//    $iter = function ($items, $acc) use (&$iter, $func) {
//        if (isEmpty($items)) {
//            return reverse($acc);
//        }
//
//        $item = head($items);
//        $newAcc = $func($item) ? cons($item, $acc) : $acc;
//        return $iter(tail($items), $newAcc);
//    };
//
//    return $iter($elements, l());

//  рекурсивный вариант
//    $tag = head($dom);
//    $rest = tail($dom);
//    if ($func($tag)) {
//        return cons($tag, filter($rest, $func));
//    }
//    return filter($rest, $func);
}

function quotes($dom)
{
    $cite = filter($dom, fn($tag) => is('blockquote', $tag));
    return map($cite, fn($tag) => getValue($tag));
}


function removeHeaders($elements)
{
    if (isEmpty($elements)) {
        return l();
    }

    $element = head($elements);
    $tailElements = tail($elements);
    if (is('h1', $element)) {
        return removeHeaders($tailElements);
    }
    return cons($element, removeHeaders($tailElements));
}

$html1 = append(make(), node('h1', 'header1'));
$html2 = append($html1, node('h1', 'header2'));
$html3 = append($html2, node('p', 'content'));
$html4 = append($html3, node('h4', 'header3'));

$processedHtml = filter($html4, fn($element) => !is('h1', $element));

htmlToString($processedHtml);
// <p>content</p>


$dom1 = make();
$dom2 = append($dom1, node('h1', 'scheme'));
$dom3 = append($dom2, node('p', 'is a lisp'));
$dom4 = append($dom3, node('blockquote', 'live is life'));
$dom5 = append($dom4, node('blockquote', 'i am sexy, and i know it'));

listToString(quotes($dom5)); // ('i am sexy, and i know it', 'live is life');