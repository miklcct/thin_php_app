<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Interop\Http\Factory\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Base class for PHP template (.phtml) views
 *
 * In order to create a view using .phtml template, extend this class, pass the view data in constructor
 * @package Miklcct\ThinPhpApp\View
 */
class PhpTemplate implements Template {
    public function __construct(string $path, StreamFactoryInterface $factory) {
        $this->path = $path;
        $this->factory = $factory;
    }

    public function render() : StreamInterface {
        ob_start();
        require $this->getPathToTemplate();
        $result = ob_get_contents();
        ob_end_clean();
        return $this->factory->createStream($result);
    }

    public function getPathToTemplate() : string {
        return $this->path;
    }

    /**
     * @var string
     */
    private $path;
    /**
     * @var StreamFactoryInterface
     */
    private $factory;
}