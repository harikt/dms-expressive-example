<?php
use App\ExpressiveLaravelIocConfig;
use Dms\Core\Language\ILanguageProvider;
use App\AppOrm;

use Psr\Cache\CacheItemPoolInterface;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Dms\Core\Event\IEventDispatcher;
use Illuminate\Events\Dispatcher;
use Dms\Web\Expressive\Auth\HktAuthSystem;
use Doctrine\DBAL\Connection;
use Zend\Expressive\Helper\UrlHelper;

use Dms\Common\Structure\FileSystem\IApplicationDirectories;
use Dms\Core\Auth\IAdminRepository;
use Dms\Core\Auth\IAuthSystem;
use Dms\Core\Auth\IRoleRepository;
use Dms\Core\Exception\InvalidOperationException;
use Dms\Core\ICms;
use Dms\Core\Ioc\IIocContainer;
use Dms\Core\Model\Object\TypedObjectAccessibilityAssertion;
use Dms\Core\Persistence\Db\Connection\IConnection;
use Dms\Core\Persistence\Db\Doctrine\Migration\CustomColumnDefinitionEventSubscriber;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Util\DateTimeClock;
use Dms\Core\Util\IClock;
use Dms\Web\Expressive\Action\ActionExceptionHandlerCollection;
use Dms\Web\Expressive\Action\ActionInputTransformerCollection;
use Dms\Web\Expressive\Action\ActionResultHandlerCollection;
use Dms\Web\Expressive\Auth\AdminDmsUserProvider;
use Dms\Web\Expressive\Auth\GenericDmsUserProvider;
use Dms\Web\Expressive\Auth\Oauth\OauthProvider;
use Dms\Web\Expressive\Auth\Oauth\OauthProviderCollection;
use Dms\Web\Expressive\Auth\Password\BcryptPasswordHasher;
use Dms\Web\Expressive\Auth\Password\IPasswordHasherFactory;
use Dms\Web\Expressive\Auth\Password\IPasswordResetService;
use Dms\Web\Expressive\Auth\Password\PasswordHasherFactory;
use Dms\Web\Expressive\Auth\Password\PasswordResetService;
use Dms\Web\Expressive\Auth\Persistence\AdminRepository;
use Dms\Web\Expressive\Auth\Persistence\RoleRepository;
use Dms\Web\Expressive\Document\DirectoryTree;
use Dms\Web\Expressive\Document\PublicFileModule;
use Dms\Web\Expressive\Event\LaravelEventDispatcher;
use Dms\Web\Expressive\File\Command\ClearTempFilesCommand;
use Dms\Web\Expressive\File\ITemporaryFileService;
use Dms\Web\Expressive\File\LaravelApplicationDirectories;
use Dms\Web\Expressive\File\Persistence\ITemporaryFileRepository;
use Dms\Web\Expressive\File\Persistence\TemporaryFileRepository;
use Dms\Web\Expressive\File\TemporaryFileService;
use Dms\Web\Expressive\Http\Middleware\Authenticate;
use Dms\Web\Expressive\Http\Middleware\EncryptCookies;
use Dms\Web\Expressive\Http\Middleware\RedirectIfAuthenticated;
use Dms\Web\Expressive\Http\Middleware\VerifyCsrfToken;
use Dms\Web\Expressive\Http\ModuleRequestRouter;
use Dms\Web\Expressive\Install\DmsInstallCommand;
use Dms\Web\Expressive\Install\DmsUpdateCommand;
use Dms\Web\Expressive\Ioc\LaravelIocContainer;
use Dms\Web\Expressive\Language\LaravelLanguageProvider;
use Dms\Web\Expressive\Language\LanguageProvider;
use Dms\Web\Expressive\Persistence\Db\DmsOrm;
use Dms\Web\Expressive\Persistence\Db\LaravelConnection;
use Dms\Web\Expressive\Persistence\Db\Migration\AutoGenerateMigrationCommand;
use Dms\Web\Expressive\Renderer\Chart\ChartRendererCollection;
use Dms\Web\Expressive\Renderer\Form\FieldRendererCollection;
use Dms\Web\Expressive\Renderer\Form\FormRendererCollection;
use Dms\Web\Expressive\Renderer\Module\ModuleRendererCollection;
use Dms\Web\Expressive\Renderer\Package\PackageRendererCollection;
use Dms\Web\Expressive\Renderer\Table\ColumnComponentRendererCollection;
use Dms\Web\Expressive\Renderer\Table\ColumnRendererFactoryCollection;
use Dms\Web\Expressive\Renderer\Widget\WidgetRendererCollection;
use Dms\Web\Expressive\Scaffold\ScaffoldCmsCommand;
use Dms\Web\Expressive\Scaffold\ScaffoldPersistenceCommand;
use Dms\Web\Expressive\View\DmsNavigationViewComposer;
// use Illuminate\Auth\AuthManager;
// use Illuminate\Console\Scheduling\Schedule;
// use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
// use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
// use Illuminate\Database\Connection;
// use Illuminate\Database\MySqlConnection;
// use Illuminate\Foundation\Application;
// use Illuminate\Routing\Middleware\SubstituteBindings;
// use Illuminate\Routing\Middleware\ThrottleRequests;
// use Illuminate\Routing\Router;
// use Illuminate\Session\Middleware\StartSession;
// use Illuminate\Support\ServiceProvider;
// use Illuminate\View\Middleware\ShareErrorsFromSession;

require_once __DIR__ . '/ExpressiveLaravelIocConfig.php';
// require_once __DIR__ . '/ExpressiveAuraDelegatorFactory.php';

// Load configuration
$config = require __DIR__ . '/config.php';

// Build container
// new Illuminate\Container\Container()
$container = LaravelIocContainer::getInstance();
new ExpressiveLaravelIocConfig($container, $config);

$container->bindValue(Illuminate\Contracts\Container\Container::class, $container->getLaravelContainer());

use Aura\Session\Session;

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, Session::class, function () {
	$session_factory = new \Aura\Session\SessionFactory;
	$session = $session_factory->newInstance($_COOKIE);
    return $session;
});

$container->bind(IIocContainer::SCOPE_SINGLETON, AdminDmsUserProvider::class, AdminDmsUserProvider::class);
// $container->bind(IIocContainer::SCOPE_SINGLETON, IAuthSystem::class, LaravelAuthSystem::class);

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, IPasswordHasherFactory::class, function () {
    return new PasswordHasherFactory(
        [
            BcryptPasswordHasher::ALGORITHM => function ($costFactor) {
                return new BcryptPasswordHasher($costFactor);
            },
        ],
        BcryptPasswordHasher::ALGORITHM,
        10
    );
});

// $container->bind(IIocContainer::SCOPE_SINGLETON, Zend\Cache\Storage\StorageInterface::class, \Zend\Session\Storage\ArrayStorage::class);

// $container->bind(IIocContainer::SCOPE_SINGLETON, IAuthSystem::class, ZendAuthSystem::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, IAuthSystem::class, HktAuthSystem::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IOrm::class, AppOrm::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IAdminRepository::class, AdminRepository::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, IRoleRepository::class, RoleRepository::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, IPasswordResetService::class, PasswordResetService::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, \Psr\Http\Message\ResponseInterface::class, \Zend\Diactoros\Response::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, \Zend\Authentication\Storage\StorageInterface::class, \Zend\Authentication\Storage\Session::class);

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, PackageRendererCollection::class, function () use ($container) {
	return new PackageRendererCollection($container->makeAll(
		config('dms.services.renderers.packages')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, FormRendererCollection::class, function () use ($container) {
	return new FormRendererCollection($container->makeAll(
		config('dms.services.renderers.forms')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, FieldRendererCollection::class, function () use ($container) {
	return new FieldRendererCollection($container->makeAll(
		config('dms.services.renderers.form-fields')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ColumnComponentRendererCollection::class, function () use ($container) {
	return new ColumnComponentRendererCollection($container->makeAll(
		array_merge(
			config('dms.services.renderers.table.column-components'),
			config('dms.services.renderers.form-fields')
		)
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ColumnRendererFactoryCollection::class, function () use ($container) {
	return new ColumnRendererFactoryCollection(
		$container->make(ColumnComponentRendererCollection::class),
		$container->makeAll(
			config('dms.services.renderers.table.columns')
		)
	);
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ChartRendererCollection::class, function () use ($container) {
	return new ChartRendererCollection($container->makeAll(
		config('dms.services.renderers.charts')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, WidgetRendererCollection::class, function () use ($container) {
	return new WidgetRendererCollection($container->makeAll(
		config('dms.services.renderers.widgets')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ModuleRendererCollection::class, function () use ($container) {
	return new ModuleRendererCollection($container->makeAll(
		config('dms.services.renderers.modules')
	));
});

use App\AppCms;
$container->bind(IIocContainer::SCOPE_SINGLETON, ICms::class, AppCms::class);

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, IIocContainer::class, function () use ($container) {
    return $container;
});

$container->bind(IIocContainer::SCOPE_SINGLETON, ILanguageProvider::class, LanguageProvider::class);

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, CacheItemPoolInterface::class, function () {
    return new FilesystemCachePool(new Filesystem(new Local(storage_path('dms/cache'))));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, IEventDispatcher::class, function () {
    /** @var LaravelEventDispatcher $eventDispatcher */
    $eventDispatcher = new LaravelEventDispatcher(new Dispatcher());

    return $eventDispatcher->inNamespace('dms::');
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, \Illuminate\Contracts\Cache\Store::class, function() use($container) {
	return $container->make(\Illuminate\Cache\ArrayStore::class);
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, \Dms\Common\Structure\FileSystem\Directory::class, function() {
	return new \Dms\Common\Structure\FileSystem\Directory('/home/hari/experiments/php/dms-expressive-integration/public');
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, \Dms\Web\Expressive\Document\DirectoryTree::class, function() use ($container) {
	$directory = $container->get(\Dms\Common\Structure\FileSystem\Directory::class);
	return new \Dms\Web\Expressive\Document\DirectoryTree($directory, [], []);
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, IConnection::class, function () {
    /** @var Connection $connection */
    // $connection = $container->get(Connection::class);
    //
    // if ($this->isRunningInConsole()) {
    //     $connection->getDoctrineConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum',
    //         'string');
    //     $connection->getDoctrineConnection()->getEventManager()->addEventSubscriber(new CustomColumnDefinitionEventSubscriber());
    // }
    //
    // if ($connection instanceof MySqlConnection
    //     && version_compare($connection->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION), '5.7.6', '>=')
    // ) {
    //     $connection->statement('SET optimizer_switch = \'derived_merge=off\'');
    // }

    $config = new \Doctrine\DBAL\Configuration();

    $connectionParams = array(
        'url' => getenv('DATABASE_URL'),
    );
    $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

    return new \Dms\Core\Persistence\Db\Doctrine\DoctrineConnection($connection);
    // new LaravelConnection($connection);
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, OauthProviderCollection::class, function () {
    $providers = [];

    // foreach ($this->app['config']->get('dms.auth.oauth-providers', []) as $providerConfig) {
    //     /** @var OauthProvider $providerClass */
    //     $providerClass = $providerConfig['provider'];
    //     $providers[]   = $providerClass::fromConfiguration($providerConfig);
    // }

    return new OauthProviderCollection($providers);
});

$container->bindValue('path.storage', dirname(__DIR__) . '/data/cache');
$container->bindValue('path.storage', dirname(__DIR__) . '/data/cache');
$container->bindValue('url', $container->get(UrlHelper::class));
$container->bindValue('route', $container->get(UrlHelper::class));
// $sessionManager = new \Illuminate\Session\SessionManager($container);
// $sessionManager->driver();
// $container->bindValue('session', $sessionManager);
// $container->bindValue('session.store', $container->get(\Illuminate\Session\Store::class));

$container->bindValue('path.public', dirname(__DIR__) . '/public');

$dmsconfig = require dirname(__DIR__) . '/vendor/harikt/web.expressive/config/dms.php';

$container->bindValue('laravel.config', new \Illuminate\Config\Repository(['dms' => $dmsconfig]));

$container->alias('laravel.config', \Illuminate\Config\Repository::class);
$container->alias('laravel.config', \Illuminate\Contracts\Config\Repository::class);

$container->bind(IIocContainer::SCOPE_SINGLETON, IClock::class, DateTimeClock::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, ITemporaryFileService::class, TemporaryFileService::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, ITemporaryFileRepository::class, TemporaryFileRepository::class);
$container->bind(IIocContainer::SCOPE_SINGLETON, IApplicationDirectories::class, LaravelApplicationDirectories::class);

use Dms\Package\Blog\Domain\Services\Persistence\IBlogCategoryRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogCategoryRepository;
$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogCategoryRepository::class, DbBlogCategoryRepository::class);

use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleCommentRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogArticleCommentRepository;
$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogArticleCommentRepository::class, DbBlogArticleCommentRepository::class);

use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogArticleRepository;
$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogArticleRepository::class, DbBlogArticleRepository::class);

use Dms\Package\Blog\Domain\Services\Persistence\IBlogAuthorRepository;
use Dms\Package\Blog\Infrastructure\Persistence\DbBlogAuthorRepository;
$container->bind(IIocContainer::SCOPE_SINGLETON, IBlogAuthorRepository::class, DbBlogAuthorRepository::class);

use Dms\Package\Blog\Domain\Entities\BlogArticle;
use Dms\Package\Blog\Domain\Services\Config\BlogConfiguration;
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

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;

// $container->bindCallback(IIocContainer::SCOPE_SINGLETON, Illuminate\View\Engines\EngineResolver::class, function () use ($container) {
// 	$viewResolver = $container->get(Illuminate\View\Engines\EngineResolver::class);
//
// 	$config = $container->has('config') ? $container->get('config') : [];
// 	$config = isset($config['blade']) ? $config['blade'] : [];
//
// 	$pathToCompiledTemplates = $config['cache_dir'];
//
// 	$viewResolver->register('blade', function () use ($container) {
// 		$bladeCompiler = $container->makeWith(BladeCompiler::class, [
// 			'files' => $container->get(IlluminateFilesystem::class),
// 			'cachePath' => $pathToCompiledTemplates,
// 		]);
//
// 		return $container->makeWith(CompilerEngine::class, [
// 			'compiler' => $bladeCompiler,
// 		]);
// 	});
//
// 	$viewResolver->register('php', function () {
// 	    return new PhpEngine();
// 	});
//
// 	return $viewResolver;
// });

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, Illuminate\View\ViewFinderInterface::class, function () use ($container) {
	return $container->makeWith(Illuminate\View\FileViewFinder::class, [
		'paths' => [],
	]);
});

$container->bind(IIocContainer::SCOPE_SINGLETON, Illuminate\Contracts\Events\Dispatcher::class, Illuminate\Events\Dispatcher::class);

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, Illuminate\Contracts\View\Factory::class, function() use ($container) {
	$viewResolver = $container->get(EngineResolver::class);

	$config = $container->has('config') ? $container->get('config') : [];
	$config = isset($config['blade']) ? $config['blade'] : [];

	$pathToCompiledTemplates = $config['cache_dir'];

	$bladeCompiler = $container->makeWith(BladeCompiler::class, [
		'files' => $container->get(IlluminateFilesystem::class),
		'cachePath' => $pathToCompiledTemplates,
	]);

	$viewResolver->register('blade', function () use ($container, $pathToCompiledTemplates, $bladeCompiler) {
		return $container->makeWith(CompilerEngine::class, [
			'compiler' => $bladeCompiler,
		]);
	});

	$viewResolver->register('php', function () {
	    return new PhpEngine();
	});

	$finder = $container->get(Illuminate\View\ViewFinderInterface::class);
	$dispatcher = $container->get(Illuminate\Contracts\Events\Dispatcher::class);

	$factory = new \Illuminate\View\Factory($viewResolver, $finder, $dispatcher);

	return $factory;
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ActionInputTransformerCollection::class, function () use ($container) {
	return new ActionInputTransformerCollection($container->makeAll(
		config('dms.services.actions.input-transformers')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ActionResultHandlerCollection::class, function () use ($container) {
	return new ActionResultHandlerCollection($container->makeAll(
		config('dms.services.actions.result-handlers')
	));
});

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, ActionExceptionHandlerCollection::class, function () use ($container) {
	return new ActionExceptionHandlerCollection($container->makeAll(
		config('dms.services.actions.exception-handlers')
	));
});

use Aura\Router\RouterContainer as Router;
$container->bind(IIocContainer::SCOPE_SINGLETON, Router::class, Router::class);

use Dms\Web\Expressive\Middleware\AuthenticationMiddleware;
$container->bind(IIocContainer::SCOPE_SINGLETON, AuthenticationMiddleware::class, AuthenticationMiddleware::class);

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;

$container->bindCallback(IIocContainer::SCOPE_SINGLETON, Translator::class, function () {
	return new Translator('fr_FR', new MessageSelector());
});

$container->alias(Translator::class, 'translator');

use Dms\Package\ContactUs\Core\IContactEnquiryRepository;
use Dms\Package\ContactUs\Persistence\DbContactEnquiryRepository;

$container->bind(IIocContainer::SCOPE_SINGLETON, IContactEnquiryRepository::class, DbContactEnquiryRepository::class);

return $container;
