<?php

namespace App\HtmlTags;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';

use function Php\Pairs\Pairs\cons;
use function Php\Pairs\Pairs\car;
use function Php\Pairs\Pairs\cdr;
use function Php\Pairs\Pairs\toString as pairToString;
use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Pairs\Data\Lists\cons as consList;
use function Php\Pairs\Data\Lists\toString as listToString;

function make()
{
    return l();
}

/**
 * creat new tag
 */
function node(string $nameTag, $body)
{
    return cons($nameTag, $body);
}

function getName($node): string
{
    return car($node);
}

function getValue($node)
{
    return cdr($node);
}

/**
 * add an element (tag) created with node() to the html list
 */
function append($dom, $node)
{
    return cons($node, $dom);
}

/**
 * returns an html text representation based on html list
 */
function toString($dom): string
{
    if (isEmpty($dom)) {
        return '';
    }
    $iter = function ($dom, $html = '') use (&$iter) {
        if (isEmpty($dom)) {
            return $html;
        }
        $node = head($dom);
        $rest = tail($dom);

        $tag = car($node); // getName($node)
        $body = cdr($node); // getValue($node)

        $newHtml = "<{$tag}>{$body}</{$tag}>{$html}";
        return $iter($rest, $newHtml);
    };
    return $iter($dom);

// teacher`s decision
//    if (isEmpty($html)) {
//        return '';
//    }
//    $element = head($html);
//    $tag = getName($element);
//    $value = getValue($element);
//    $restOfHtml = toString(tail($html));
//    return "{$restOfHtml}<{$tag}>{$value}</{$tag}>";
}

//// Создаем новый html-список
//$dom1 = make();
//
//// Создаем тег и сразу добавляем его в html
//$dom2 = append($dom1, node('h1', 'hello, world'));
//// Еще раз
//$dom3 = append($dom2, node('h2', 'header2'));
//
//// Создаем новый тег
//$tag = node('h3', 'header3');
//// Добавляем созданный тег в html-список
//$dom = append($dom3, $tag);
//
//// Преобразуем html-список в строчку
//(toString($dom);
//// <h1>hello, world</h1><h2>header2</h2><h3>header3</h3>

//// Пример без создания промежуточных переменных
//toString(append(make(), node('p', 'this is Sparta!')));
//// <p>this is Sparta!</p>