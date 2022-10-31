<?php

namespace App\Select;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';
//require_once '../src/HtmlTags.php';

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\cons as consList;
use function Php\Pairs\Data\Lists\concat;
use function Php\Html\Tags\HtmlTags\is;
use function Php\Html\Tags\HtmlTags\hasChildren;
use function Php\Html\Tags\HtmlTags\children;
use function Php\Html\Tags\HtmlTags\reduce;
use function Php\Html\Tags\HtmlTags\toString as htmlToString;
use function Php\Html\Tags\HtmlTags\make;
use function Php\Html\Tags\HtmlTags\append;
use function Php\Html\Tags\HtmlTags\node;

function select(string $tagName, $dom)
{
    return reduce($dom, function ($node, $acc) use ($tagName) {
        $acc2 = hasChildren($node) ? concat(select($tagName, children($node)), $acc) : $acc;
        return is($tagName, $node) ? consList($node, $acc2) : $acc2;
    }, l());

//    return reduce($html, function ($node, $acc) use ($tagName) {
//        if (is($tagName, $node)) {
//            return !hasChildren($node) ?
//                concat($acc, l($node)) :
//                concat(concat($acc, l($node)), select($tagName, children($node)));
//        } else {
//            return !hasChildren($node) ?
//                $acc :
//                concat($acc, select($tagName, children($node)));
//        }
//    }, l());

//    return reduce(
//        $dom,
//        function ($node, $acc) use ($tagName) {
//            $acc2 = hasChildren($node) ? concat(select($tagName, children($node)), $acc) : $acc;
//            if (is($tagName, $node)) {
//                return consList($node, $acc2);
//            }
//            return $acc2;
//        },
//        l()
//    );
}

$dom1 = make(); // Список нод, то есть это лес, а не дерево
$dom2 = append($dom1, node('h1', 'scheme'));
$dom3 = append($dom2, node('p', 'is a lisp'));

$children1 = l(node('li', 'item 1'), node('li', 'item 2'));
$dom4 = append($dom3, node('ul', $children1));
$children2 = l(node('li', 'item 1'), node('li', 'item 2'));
$dom5 = append($dom4, node('ol', $children2));
$dom6 = append($dom5, node('p', 'is a functional language'));
$children3 = l(node('li', 'item'));
$dom7 = append($dom6, node('ul', $children3));
$dom8 = append($dom7, node('div', l(node('p', 'text'))));
$dom9 = append($dom8, node('div', l(node('div', l(node('p', 'text'))))));

$dom10 = append($dom9, node('h1', 'prolog'));
$dom = append($dom10, node('p', 'is about logic'));

select('li', $dom);
// [('li', 'item 1'), ('li', 'item 2'), ('li', 'item 1'), ('li', 'item 2'), ('li', 'item')]

select('p', $dom);
// [('p', 'is a lisp'), ('p', 'text'), ('p', 'text'), ('p', 'is about logic'), ('p', 'is a functional language')]
