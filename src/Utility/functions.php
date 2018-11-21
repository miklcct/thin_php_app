<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Utility;

/**
 * Run a callback on a value if it is not NULL
 *
 * @param mixed|null $value A value which may possibly be NULL
 * @param callable $callback Called when $object is not NULL
 * @param mixed|null $default Value returned when $object is NULL
 * @return mixed|null
 */
function nullable($value, callable $callback, $default = NULL) {
    return $value !== NULL ? $callback($value) : $default;
}