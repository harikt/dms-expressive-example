<?php

namespace App\Action;

use Dms\Core\ICms;
use Dms\Package\Blog\Domain\Services\Loader\BlogArticleLoader;
use Dms\Package\Blog\Domain\Entities\BlogArticle;
use Interop\Http\Server\RequestHandlerInterface;
use Interop\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class BlogAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $blogArticleLoader;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template,
        BlogArticleLoader $blogArticleLoader
    ) {
        $this->router   = $router;
        $this->template = $template;
        $this->blogArticleLoader = $blogArticleLoader;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query = $request->getQueryParams();
        $page = isset($query['page']) ? $query['page'] : 1;
        $itemsPerPage = 10;
        $articles = $this->blogArticleLoader->getPage($page, $itemsPerPage);
        return new HtmlResponse($this->template->render('app::blog', [
            'articles' => $articles,
            'total' => $this->blogArticleLoader->getAmountOfArticles(),
            'previous' => $page - 1,
            'next' => $page + 1,
        ]));
    }
}
