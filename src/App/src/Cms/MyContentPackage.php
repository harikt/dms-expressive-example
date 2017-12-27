<?php declare(strict_types = 1);

namespace App\Cms;

// use App\Http\Controllers\PageController;
use Dms\Package\Content\Cms\ContentPackage;
use Dms\Package\Content\Cms\Definition\ContentConfigDefinition;
use Dms\Package\Content\Cms\Definition\ContentGroupDefiner;
use Dms\Package\Content\Cms\Definition\ContentModuleDefinition;
use Dms\Package\Content\Cms\Definition\ContentPackageDefinition;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MyContentPackage extends ContentPackage
{
    protected static function defineConfig(ContentConfigDefinition $config)
    {
        $cwd = dirname(dirname(dirname(dirname(__DIR__))));
        $config
            ->storeImagesUnder($cwd . '/public/app/content/images')
            ->mappedToUrl('/app/content/images')
            ->storeFilesUnder($cwd . '/public/app/content/files');
    }

    /**
     * Defines the structure of the content.
     *
     * @param ContentPackageDefinition $content
     *
     * @return void
     */
    protected function defineContent(ContentPackageDefinition $content)
    {
        $content->module('pages', 'file-text', function (ContentModuleDefinition $module) {
            $module->group('home', 'Home')
                ->withText('title', 'Title')
                ->withHtml('content', 'Content')
                ->withArrayOf('carousel-item', 'Hero Carousel', function (ContentGroupDefiner $item) {
                    $item
                        ->withText('caption', 'Caption')
                        ->withImage('image', 'Image');
                })
                ->withText('heading1', 'Heading One')
                ->withHtml('content1', 'Content One')
                ->withImage('image1', 'Image One')
                ->withText('caption1', 'Image Caption One')
                ->withText('heading2', 'Heading Two')
                ->withHtml('content2', 'Content Two')
                ->withImage('image2', 'Image Two')
                ->withText('caption2', 'Image Caption Two')
                ->withMetadata('title', 'Meta - Title')
                ->withMetadata('description', 'Meta - Description')
                // Optionally define a preview callback to enable
                // live content previews in the CMS
                // ->setPreviewCallback(function () {
                //     return \app()->call(PageController::class . '@showHomePage')->render();
                // })
                ;

            $module->group('about', 'About')
                    ->withText('title', 'Title')
                    ->withHtml('content', 'Content')
                    ->withMetadata('title', 'Meta - Title')
                    ->withMetadata('description', 'Meta - Description')
                    ;
            // Add more pages here ...
        });

        // Define additional modules here...

        // Optionally, register your own custom modules if you want to include
        // them in your content package...
        // $content->customModules([
        //     'custom' => CustomModule::class
        // ]);
    }
}
