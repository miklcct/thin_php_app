<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Interop\Http\Factory\StreamFactoryInterface;

/**
 * View for PHP templates (commonly stored as .phtml extension)
 *
 * If the template does not need any data, implementing {@link getPathToTemplate()} method is enough to complete
 * the view.
 *
 * If the template needs data, you are recommended to override the constructor such that the data is passed into
 * the view in the required types.
 *
 * @package Miklcct\ThinPhpApp\View
 */
abstract class PhpTemplate implements Template {
    use StringToStream;

    public function __construct(StreamFactoryInterface $streamFactory) {
        $this->streamFactory = $streamFactory;
    }

    public function __toString() : string {
        ob_start();
        require $this->getPathToTemplate();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public function getContentType() : ?string {
        return 'text/html; charset=utf-8';
    }

    protected function getStreamFactory() : StreamFactoryInterface {
        return $this->streamFactory;
    }

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;
}