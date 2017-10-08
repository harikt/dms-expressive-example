<?php declare(strict_types = 1);

namespace App;

use App\Cms\MyContentPackage;
use App\Cms\TodoAppPackage;
use Dms\Core\Cms;
use Dms\Core\CmsDefinition;
use Dms\Package\Analytics\AnalyticsPackage;
use Dms\Package\Blog\Cms\BlogPackage;
use Dms\Package\ContactUs\Cms\ContactUsPackage;
use Dms\Web\Expressive\Auth\AdminPackage;
use Dms\Web\Expressive\Document\PublicFilePackage;

/**
 * The application's cms.
 */
class AppCms extends Cms
{
    /**
     * Defines the structure and installed packages of the cms.
     *
     * @param CmsDefinition $cms
     *
     * @return void
     */
    protected function define(CmsDefinition $cms)
    {
        $cms->packages([
            'admin'     => AdminPackage::class,
            'documents' => PublicFilePackage::class,
            'analytics' => AnalyticsPackage::class,

            // TODO: Register your application cms packages...
            'blog' => BlogPackage::class,
            'content' => MyContentPackage::class,
            'contact-us' => ContactUsPackage::class,
            'todo-app' => TodoAppPackage::class,
        ]);
    }
}
