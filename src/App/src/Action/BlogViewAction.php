<?php

namespace App\Action;

use Dms\Core\ICms;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleRepository;
use Dms\Package\Blog\Domain\Entities\BlogArticle;
use Interop\Http\Server\RequestHandlerInterface;
use Interop\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class BlogViewAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $blogArticleRepository;

    public function __construct(
        Router\RouterInterface $router, 
        Template\TemplateRendererInterface $template,
        IBlogArticleRepository $blogArticleRepository
    ) {
        $this->router   = $router;
        $this->template = $template;
        $this->blogArticleRepository = $blogArticleRepository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $articles = $this->blogArticleRepository->matching(
            $this->blogArticleRepository->criteria()
                ->where(BlogArticle::SLUG, '=', $request->getAttribute('slug'))
        );

        if (count($articles) == 0) {
            return new RedirectResponse('/blog');
        }

        return new HtmlResponse($this->template->render('app::blog-view', [
            'article' => $articles[0]
        ]));
    }
}
