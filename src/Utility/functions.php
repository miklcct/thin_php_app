<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Utility;

/**
 * Run a callback on an object if it is not NULL
 *
 * @param $object
 * @param callable $callback
 * @return mixed|null
 */
function nullable($object, callable $callback) {
    return $object !== NULL ? $callback($object) : NULL;
}