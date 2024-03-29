<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use ExceptionWithThrowable;
use Psr\Http\Message\StreamFactoryInterface;
use RuntimeException;
use Throwable;
use function is_string;
use function ob_end_clean;

/**
 * View for PHP templates (commonly stored as .phtml extension)
 *
 * If the template does not need any data, implementing {@link getPathToTemplate()} method is enough to complete
 * the view.
 *
 * If the template needs data, you are recommended to override the constructor such that the data is passed into
 * the view in the required types.
 *
 *
 */
abstract class PhpTemplate extends Template {
    use StringToStream;

    public function __construct(StreamFactoryInterface $streamFactory) {
        $this->streamFactory = $streamFactory;
    }

    public function __toString() : string {
        ob_start();
        try {
            /** @noinspection PhpIncludeInspection */
            require $this->getPathToTemplate();
            $result = ob_get_contents();
            if (!is_string($result)) {
                if (PHP_VERSION_ID >= 70400) {
                    /** @noinspection PhpLanguageLevelInspection */
                    throw new RuntimeException('output buffering does not work correctly.');
                } else {
                    return '';
                }
            }
            return $result;
        } finally {
            ob_end_clean();
        }
    }

    protected function getStreamFactory() : StreamFactoryInterface {
        return $this->streamFactory;
    }

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;
}