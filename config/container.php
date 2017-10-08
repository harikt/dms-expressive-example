<?php
use App\AppCms;
use App\AppOrm;
use App\Domain\Services\Persistence\ITodoItemRepository;
use App\ExpressiveDmsConfig;
use App\Infrastructure\Persistence\DbTodoItemRepository;
use Dms\Core\ICms;
use Dms\Core\Ioc\IIocContainer;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Package\Blog\Domain\Entities\BlogArticle;
use Dms\Package\Blog\Domain\Services\Config\BlogConfiguration;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleCommentRepository;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleRepository;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogAuthorRepository;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogCategoryRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogArticleCommentRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogArticleRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogAuthorRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogCategoryRepository;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;
use Dms\Package\ContactUs\Persistence\DbContactEnquiryRepository;
use Dms\Package\Content\Core\ContentLoaderService;
use Dms\Web\Expressive\Ioc\LaravelIocContainer;
use Illuminate\Contracts\View\Factory as ViewFactory;

require_once __DIR__ . '/ExpressiveDmsConfig.php';

// Load configuration
$config = require __DIR__ . '/config.php';

// Build container
// new Illuminate\Container\Container()
$container = LaravelIocContainer::getInstance();
$configurator = new ExpressiveDmsConfig($container);
$configurator($config);

$container->bindValue('config', $config);

$dmsExpressiveContainerConfig = new Dms\Web\Expressive\ContainerConfig();
$dmsExpressiveContainerConfig->define($container);

$dmsCliContainerConfig = new Dms\Cli\Expressive\ContainerConfig();
$dmsCliContainerConfig->define($container);

$container->bind(IIocContainer::SCOPE_SINGLETON, IOrm::class, AppOrm::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, ICms::class, AppCms::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogCategoryRepository::class, DbBlogCategoryRepository::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogArticleCommentRepository::class, DbBlogArticleCommentRepository::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogArticleRepository::class, DbBlogArticleRepository::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogAuthorRepository::class, DbBlogAuthorRepository::class);
$container->bindCallback(IIocContainer::SCOPE_SINGLETON, BlogConfiguration::class, function () {
    return BlogConfiguration::builder()
        ->setFeaturedImagePath(public_path('app/images/blog'))
        ->useDashedSlugGenerator()
        // Supply a preview callback to provide article previews
        // directly from the backend. This can be omitted to disable this feature.
        ->setArticlePreviewCallback(function (BlogArticle $article) {
            return view('blog.article', ['article' => $article])->render();
        })
        ->build();
});

$container->bind(IIocContainer::SCOPE_SINGLETON, IContactEnquiryRepository::class, DbContactEnquiryRepository::class);

$laravelContainer = $container->getLaravelContainer();

$laravelContainer->when('Dms\Package\Content\Core\ContentConfig')
     ->needs('$imageStorageBasePath')
     ->give(public_path('/app/content/images/'));

$laravelContainer->when('Dms\Package\Content\Core\ContentConfig')
  ->needs('$imageBaseUrl')
  ->give('/app/content/images/');

$laravelContainer->when('Dms\Package\Content\Core\ContentConfig')
   ->needs('$fileStorageBasePath')
   ->give(public_path('/app/content/files/'));

$container->bind(IIocContainer::SCOPE_SINGLETON, ITodoItemRepository::class, DbTodoItemRepository::class);
$viewFactory = $container->get(ViewFactory::class);
$viewFactory->composer('*', function ($view) use ($container) {
    $view->with('contentLoader', $container->get(ContentLoaderService::class));
});

return $container;
