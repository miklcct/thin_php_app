<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * View for static template (e.g. HTML templates)
 *
 * Implement {@link getPathToTemplate()} to complete the class.
 *
 * Class StaticTemplate
 *
 */
abstract class StaticTemplate extends Template {
    use StreamToString;

    public function __construct(StreamFactoryInterface $streamFactory) {
        $this->streamFactory = $streamFactory;
    }

    /**
     * Render the view as a stream.
     *
     * @return StreamInterface
     */
    public function render() : StreamInterface {
        return $this->streamFactory->createStreamFromFile($this->getPathToTemplate());
    }

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;
}