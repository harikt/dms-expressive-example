<?php

namespace App\Action;

use Dms\Core\ICms;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class AboutAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    public function __construct(Router\RouterInterface $router, ICms $cms, Template\TemplateRendererInterface $template = null)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->cms = $cms;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new HtmlResponse($this->template->render('app::about', []));
    }
}
