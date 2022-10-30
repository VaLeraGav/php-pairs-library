<?php

namespace App\HtmlTags;

use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Html\Tags\HtmlTags\getValue;
use function Php\Html\Tags\HtmlTags\is;

// BEGIN (write your solution here)

// END

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

$html1 = make();
$html2 = append($html1, node('h1', 'scheme'));
$html3 = append($html2, node('p', 'is a lisp'));
$html4 = append($html3, node('blockquote', ''));
$html5 = append($html4, node('blockquote', ''));
$html6 = append($html5, node('blockquote', 'quote'));

emptyTagsCount('blockquote', html6); // 2