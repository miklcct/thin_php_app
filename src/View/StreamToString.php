<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Psr\Http\Message\StreamInterface;

/**
 * Trait for string rendering if a stream is provided
 **
 * Views are expected to use either StringToStream or StreamToString, but not both at the same time.
 *
 *
 */
trait StreamToString {
    abstract public function render() : StreamInterface;

    public function __toString() : string {
        return $this->render()->getContents();
    }
}