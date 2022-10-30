<?php

namespace App\HtmlTags;

require_once '../src/Pairs.php';
require_once '../src/Lists.php';

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\cons;
use function Php\Pairs\Data\Lists\reverse;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\map;

// BEGIN (write your solution here)

// END

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

$processedHtml = filter($html3, fn($element) => !is('h1', $element));

//<p>content</p>
htmlToString($processedHtml);

$dom1 = make();
$dom2 = append($dom1, node('h1', 'scheme'));
$dom3 = append($dom2, node('p', 'is a lisp'));
$dom4 = append($dom3, node('blockquote', 'live is life'));
$dom5 = append($dom4, node('blockquote', 'i am sexy, and i know it'));

listToString(quotes($dom5)); // ('i am sexy, and i know it', 'live is life');