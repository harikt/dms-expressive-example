<?php
use Dms\Web\Expressive\Http\Controllers\Package\Module\ModuleController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\FieldRendererController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\FormRendererController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\FormStageController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\RunController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\ShowResultController;
use Dms\Web\Expressive\Http\Controllers\Package\Module\Action\ShowFormController;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Router\Route;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

$app->get('/', App\Action\HomePageAction::class, 'home');
// $app->get('/api/ping', App\Action\PingAction::class, 'api.ping');
$app->route('/dms/auth/login', Dms\Web\Expressive\Http\Controllers\Auth\LoginController::class, ['GET', 'POST'], 'dms::auth.login');
$app->get('/dms/auth/logout', Dms\Web\Expressive\Http\Controllers\Auth\LogoutController::class, 'dms::auth.logout');
// $app->get('/dms/auth/oauth/{provider}/redirect', 'OauthController@redirectToProvider', 'dms::auth.oauth.redirect');
// $app->get('/dms/auth/oauth/{provider}/response', 'OauthController@handleProviderResponse', 'dms::auth.oauth.response');
// PasswordController@showResetLinkEmailForm
// $app->post('/dms/auth/password/email', 'PasswordController@sendResetLinkEmail');
$app->route('/dms/auth/password/email', Dms\Web\Expressive\Http\Controllers\Auth\Password\ResetLinkEmailController::class, ['GET', 'POST'], 'dms::auth.password.forgot');
// $app->get('/dms/auth/password/reset[/{token}]', 'PasswordController@showPasswordResetForm', 'password.reset');
// $app->post('/dms/auth/password/reset', 'PasswordController@reset');
$app->get('/dms', Dms\Web\Expressive\Http\Controllers\IndexController::class, 'dms::index');

// Files
// FileController@upload
$app->post('/dms/file/upload', Dms\Web\Expressive\Http\Controllers\File\UploadController::class, 'dms::file.upload');
// FileController@preview
$app->get('/dms/file/preview/{token}', Dms\Web\Expressive\Http\Controllers\File\PreviewController::class, 'dms::file.preview');
// FileController@download
$app->get('/dms/file/download/{token}', Dms\Web\Expressive\Http\Controllers\File\DownloadController::class, 'dms::file.download');

// Packages
// Package\PackageController@showDashboard
$app->get(
	'/dms/package/{package}/dashboard',
	Dms\Web\Expressive\Http\Controllers\Package\PackageController::class,
	'dms::package.dashboard'
);

$router = app(RouterInterface::class);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}',
		ModuleController::class,
		['GET'],
		'dms::package.module.dashboard'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form[/{object_id}]',
		ShowFormController::class,
		['GET'],
		'dms::package.module.action.form'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form/stage/{stage}',
		FormStageController::class,
		['POST'],
		'dms::package.module.action.form.stage'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form/stage/{stage}/form[/{form_action}]',
		FormRendererController::class,
		Route::HTTP_METHOD_ANY,
		'dms::package.module.action.form.stage.action'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form/{object_id}/stage/{stage}/form[/{form_action}]',
		FormRendererController::class,
		Route::HTTP_METHOD_ANY,
		'dms::package.module.action.form.object.stage.action'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form/stage/{stage}/field/{field_name}[/{field_action}]',
		FieldRendererController::class,
		Route::HTTP_METHOD_ANY,
		'dms::package.module.action.form.stage.field.action'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/form/{object_id}/stage/{stage}/field/{field_name}[/{field_action}]',
		FieldRendererController::class,
		Route::HTTP_METHOD_ANY,
		'dms::package.module.action.form.object.stage.field.action'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/run',
		RunController::class,
		['POST'],
		'dms::package.module.action.run'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/action/{action}/show[/{object_id}]',
		ShowResultController::class,
		['GET'],
		'dms::package.module.action.show'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/table/{table}/{view}',
		'Dms\Web\Expressive\Http\Controllers\Package\Module\Table\ShowController',
		['GET'],
		'dms::package.module.table.view.show'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/table/{table}/{view}/load',
		'Dms\Web\Expressive\Http\Controllers\Package\Module\Table\LoadTableRowsController',
		['POST'],
		'dms::package.module.table.view.load'
	)
);

// Charts
$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/chart/{chart}/{view}',
		'Dms\Web\Expressive\Http\Controllers\Package\Module\ChartController@showChart',
		['GET'],
		'dms::package.module.chart.view.show'
	)
);

$router->addRoute(
	new Route(
		'/dms/package/{package}/{module}/chart/{chart}/{view}/load',
		'Dms\Web\Expressive\Http\Controllers\Package\Module\ChartController@loadChartData',
		['POST'],
		'dms::package.module.chart.view.load'
	)
);
// use Dms\Web\Expressive\Http\ModuleRequestRouter;
// Modules
/** @var ModuleRequestRouter $moduleRouter */
// $moduleRouter = app(ModuleRequestRouter::class);
// $moduleRouter->registerOnMainRouter(app(RouterInterface::class));

// $app->any('{catch_all}', 'ErrorController@notFound')->where('catch_all', '(.*)');
