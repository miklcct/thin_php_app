<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Factory;
use Interop\Http\Factory\ResponseFactoryInterface;
use Miklcct\ThinPhpApp\View\View;
use Psr\Http\Message\ResponseInterface;

class ViewResponseFactory implements ViewResponseFactoryInterface {
    public function __construct(ResponseFactoryInterface $responseFactory) {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(View $view) : ResponseInterface {
        $response = $this->responseFactory->createResponse()->withBody($view->render());
        $content_type = $view->getContentType();
        return $content_type !== NULL ? $response->withHeader('Content-Type', $content_type) : $response;
    }

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;
}