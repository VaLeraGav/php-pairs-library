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

function reduce($html, callable $func, $acc)
{
    $iter = function ($dom, $acc) use (&$iter, $func) {
        if (isEmpty($dom)) {
            return $acc;
        }
        $node = head($dom);
        $newAcc = $func($node, $acc);
        return $iter(tail($dom), $newAcc);
    };

    return $iter($html, $acc);

// teacher`s decision
//    if (isEmpty($elements)) {
//        return $acc;
//    }
//    return reduce(tail($elements), $func, $func(head($elements), $acc));
}

function emptyTagsCount(string $tagName, $html)
{
    return reduce($html, function ($tag, $acc) use ($tagName) {
        return (is($tagName, $tag) && getValue($tag) === '') ? $acc + 1 : $acc;
    }, 0);

// teacher`s decision
//    $predicate = function ($element) use ($tagName) {
//        return is($tagName, $element) && getValue($element) === '';
//    };
//    return reduce($elements, fn($element, $acc) => $predicate($element) ? $acc + 1 : $acc, 0);
}

function headersCount($tagName, $elements)
{
    $iter = function ($items, $acc) use (&$iter, $tagName) {
        if (isEmpty($items)) {
            return $acc;
        }

        $item = head($items);
        $newAcc = is($tagName, $item) ? $acc + 1 : $acc;
        return $iter(tail($items), $newAcc);
    };

    return $iter($elements, 0);
}


$html1 = append(make(), node('h1', 'header1'));
$html2 = append($html1, node('h1', 'header2'));
$html3 = append($html2, node('p', 'content'));

reduce($html3, fn($element, $acc) => is('h1', $element) ? $acc + 1 : $acc, 0); // 2

//$html1 = make();
//$html2 = append($html1, node('h1', 'scheme'));
//$html3 = append($html2, node('p', 'is a lisp'));
//$html4 = append($html3, node('blockquote', ''));
//$html5 = append($html4, node('blockquote', ''));
//$html6 = append($html5, node('blockquote', 'quote'));
//
//emptyTagsCount('blockquote', html6); // 2