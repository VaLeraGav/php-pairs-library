<?php

namespace App\Solution;

//require_once '../src/Pairs.php';
//require_once '../src/Lists.php';

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\cons;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Pairs\Data\Lists\toString as listToString;

// BEGIN (write your solution here)

/**
 * checks whether the passed value is a list item
 */
function has($list, $value)
{
    if (isEmpty($list)) {
        return false;
    }
    if (head($list) === $value) {
        return true;
    }
    return has(tail($list), $value);
}

/**
 * connects two lists using a recursive process
 * @example
 * $numbers2 = l(3, 2, 9);
 * reverse($numbers2); // (9, 2, 3)
 */
function reverse($list)
{
    if (isEmpty($list)) {
        return l();
    }
    $iter = function ($reversed, $list) use (&$iter) {
        if (isEmpty($list)) {
            return $reversed;
        }
        $head = head($list);
        $tail = tail($list);
        $newList = cons($head, $reversed);
        return $iter($newList, $tail);
    };
    $end = head($list);
    $tail = tail($list);
    $reversed = l($end);

    return $iter($reversed, $tail);

// teacher`s decision
//    $iter = function ($items, $acc) use (&$iter) {
//        if (isEmpty($items)) {
//            return $acc;
//        } else {
//            return ($iter(tail($items), cons(head($items), $acc)));
//        }
//        //return isEmpty($items) ? $acc : $iter(tail($items), cons(head($items), $acc));
//    };
//  return $iter($list, l());
}


/**
 * flips the list using an iterative process
 * @example
 * $numbers = l(3, 4, 5, 8);
 * $numbers2 = l(3, 2, 9);
 * concat($numbers, $numbers2); // (3, 4, 5, 8, 3, 2, 9)
 */
function concat($list1, $list2)
{
    if (isEmpty($list1)) {
        return $list2;
    }
    if (isEmpty($list2)) {
        return $list1;
    }

// 1
//    $coll1 = explode(', ', trim(listToString($list1), '()'));
//    $arr = array_reverse($coll1);

// 2
//    $head = head($list1);
//    $tail = tail($list1);
//    $coll1[] = $head;
//    while (!isEmpty($tail)) {
//        $head = head($tail);
//        $tail = tail($tail);
//        $coll1[] = $head;
//    }
//    $arr = array_reverse($coll1);

    $lst1 = function ($list, $acc = []) use (&$lst1) {
        $first = head($list);
        $rest = tail($list);
        $acc[] += $first;
        if (isEmpty($rest)) {
            return $acc;
        }
        return $lst1($rest, $acc);
    };
    $arr = array_reverse($lst1($list1));

    // attaches to the end
    $result = array_reduce($arr, fn($acc, $item) => cons($item, $acc), $acc = $list2);

    return $result;

// teacher`s decision
//    if (isEmpty($list1)) {
//        return $list2;
//    }
//    return cons(head($list1), concat(tail($list1), $list2));
}


//$numbers = l(3, 4, 5, 8);
//$numbers2 = l(3, 2, 9);
//has($numbers, 8); // true
//has($numbers, 0); // false
//reverse($numbers2); // (9, 2, 3)
//concat($numbers, $numbers2); // (3, 4, 5, 8, 3, 2, 9)