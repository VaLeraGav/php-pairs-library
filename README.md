# php-pairs

[hexlet-components/php-pairs](https://github.com/hexlet-components/php-pairs)

Functions for working with Pairs.

## Examples

```php
<?php
use function Php\Pairs\Pairs\cons;
use function Php\Pairs\Pairs\car;
use function Php\Pairs\Pairs\cdr;
use function Php\Pairs\Pairs\toString;
$pair = cons(1, 2);
$one = car($pair); // $one = 1;
$two = cdr($pair); // $two = 2;
$str = toString($pair); // '(1, 2)'
```

---

# php-pairs-data

[hexlet-components/php-pairs-data](https://github.com/hexlet-components/php-pairs-data)

Functions for working with Lists.

## Examples

```php
<?php
use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\length;
use function Php\Pairs\Data\Lists\filter;
use function Php\Pairs\Data\Lists\toString;
$list = l(1, 2, 3, 4, 5, 6);
$length = length($list); // $length = 6;
$filter = filter($list, fn($x) => $x % 2 == 0);
$result = toString($filter); // $result = "(2, 4, 6)";
```

---

[![Hexlet Ltd. logo](https://raw.githubusercontent.com/Hexlet/assets/master/images/hexlet_logo128.png)](https://hexlet.io?utm_source=github&utm_medium=link&utm_campaign=php-pairs)

This repository is created and maintained by the team and the community of Hexlet, an educational
project. [Read more about Hexlet](https://hexlet.io?utm_source=github&utm_medium=link&utm_campaign=php-pairs).

See most active contributors on [hexlet-friends](https://friends.hexlet.io/).