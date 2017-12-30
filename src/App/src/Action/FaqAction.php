<?php

namespace App\Action;

use Dms\Package\Faq\Core\FaqLoaderService;
use Interop\Http\Server\RequestHandlerInterface;
use Interop\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class FaqAction implements ServerMiddlewareInterface
{
    private $template;

    protected $faqLoaderService;

    public function __construct(Template\TemplateRendererInterface $template, FaqLoaderService $faqLoaderService)
    {
        $this->template = $template;
        $this->faqLoaderService = $faqLoaderService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::faq', [
            'faqs' => $this->faqLoaderService->loadFaqs(),
        ]));
    }
}
