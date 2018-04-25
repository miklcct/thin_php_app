<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Psr\Http\Message\StreamInterface;

/**
 * Interface for all views
 *
 * It is impossible to pass data at the time of rendering, because every view needs different data.
 * It is not possible to define such interface.
 * Instead, view data should be passed in the constructor and stored inside the view.
 *
 * @package Miklcct\ThinPhpApp\View
 */
interface View {
    /**
     * Render the view as a stream.
     *
     * @return StreamInterface
     */
    public function render() : StreamInterface;

    /**
     * Render the view as a string.
     *
     * @return string
     */
    public function __toString() : string;

    /**
     * Get the content type of the view
     */
    public function getContentType() : ?string;
}