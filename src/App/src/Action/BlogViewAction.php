<?php

namespace App\Action;

use Dms\Core\ICms;
use Dms\Common\Structure\Web\EmailAddress;
use Dms\Package\Blog\Domain\Services\BlogKernel;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Dms\Core\Model\EntityNotFoundException;

class BlogViewAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $blogKernel;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template,
        BlogKernel $blogKernel
    ) {
        $this->router   = $router;
        $this->template = $template;
        $this->blogKernel = $blogKernel;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $article = $this->blogKernel->articles()->loadFromSlug($request->getAttribute('slug'));
        } catch (EntityNotFoundException $e) {
            return new RedirectResponse('/blog');
        }

        if ($request->getMethod() == 'POST') {
            // @Todo : validate and filter
            $post = $request->getParsedBody();
            $comment = $this->blogKernel->comments()->postComment(
                $article->getId(),
                $post['name'],
                new EmailAddress($post['email']),
                $post['comment']
            );
        }

        return new HtmlResponse($this->template->render('app::blog-view', [
            'item' => $article,
        ]));
    }
}
