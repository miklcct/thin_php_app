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
abstract class PhpTemplate extends AbstractView implements Template {
    public function __construct(StreamFactoryInterface $factory) {
        $this->factory = $factory;
    }

    public function render() : StreamInterface {
        ob_start();
        require $this->getPathToTemplate();
        $result = ob_get_contents();
        ob_end_clean();
        return $this->factory->createStream($result);
    }

    /**
     * @var StreamFactoryInterface
     */
    private $factory;
}