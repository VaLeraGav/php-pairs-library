<?php

namespace App\HtmlTags;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\cons;
use function Php\Pairs\Data\Lists\reverse;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Html\Tags\HtmlTags\getName;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\node;
use function Php\Html\Tags\HtmlTags\is;

function map($dom, callable $func)
{
// Рекурсивный процесс
    if (isEmpty($dom)) {
        return l();
    }
    $newNode = $func(head($dom));

    return cons($newNode, map(tail($dom), $func));

// teacher`s decision Итеративный процесс,  (рекурсивно)
//    function map($elements, callable $func)
//    {
//        $iter = function ($items, $acc) use (&$iter, $func) {
//            if (isEmpty($items)) {
//                return reverse($acc);
//            }
//            return $iter(tail($items), cons($func(head($items)), $acc));
//        };
//        return $iter($elements, l());
//    }
}

/**
 * flips the contents of the tags so that it needs to be read from right to left, not from left to right.
 */
function mirror($dom)
{
    return map($dom, function ($node) {
        $body = getValue($node);
        $mirroredBody = strrev($body);
        return node(getName($node), $mirroredBody);
    });
}

function b2p($elements)
{
    if (isEmpty($elements)) {
        return l();
    }

    $element = head($elements);
    if (is('blockquote', $element)) {
        $newElement = node('p', getValue($element));
    } else {
        $newElement = $element;
    }

    return cons($newElement, b2p(tail($elements)));
}

$dom1 = make();
$dom2 = append($dom1, node('h1', 'scheme'));
$dom3 = append($dom2, node('p', 'is a lisp'));

// Отображение в результате которого в html-списке заменяются теги h1 на теги h2
//$processedDom = map($dom3, function ($element) {
//    if (is('h1', $element)) {
//        return node('h2', value($element));
//    }
//    return $element;
//});

// htmlToString(mirror($dom3));
// <h1>emehcs</h1>
// <p>psil a si</p>