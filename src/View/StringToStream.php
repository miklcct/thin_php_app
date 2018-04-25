<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Interop\Http\Factory\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Trait for stream rendering if a string is provided
 *
 * Views are expected to use either StringToStream or StreamToString, but not both at the same time.
 *
 * @package Miklcct\ThinPhpApp\View
 */
trait StringToStream {
    public function render() : StreamInterface {
        return $this->getStreamFactory()->createStream($this->__toString());
    }

    abstract public function __toString() : string;

    abstract protected function getStreamFactory() : StreamFactoryInterface;
}