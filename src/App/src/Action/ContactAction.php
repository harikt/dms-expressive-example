<?php
namespace App\Action;

use Dms\Core\ICms;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Core\ContactEnquiryService;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class ContactAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $contactEnquiryService;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        ContactEnquiryService $contactEnquiryService,
        ICms $cms
    ) {
        $this->router   = $router;
        $this->template = $template;
        $this->contactEnquiryService = $contactEnquiryService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // $this->validate($request, [
        //     'name'    => 'required',
        //     'email'   => 'required|email',
        //     'subject' => 'required',
        //     'message' => 'required',
        // ]);

        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
            $this->contactEnquiryService->recordEnquiry(
                $post['email'],
                $post['name'],
                $post['subject'],
                $post['message'],
                function (ContactEnquiry $enquiry) {
                    // Send the notification email...
                }
            );

            return (new Response('php://temp', 302))
                ->withHeader('Location', $this->router->generateUri('app::contact'));
        }

        return new HtmlResponse($this->template->render('app::contact', []));
    }
}
