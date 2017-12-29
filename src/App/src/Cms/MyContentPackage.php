<?php declare(strict_types = 1);

namespace App\Cms;

use Dms\Core\Ioc\IIocContainer;
use Dms\Package\Content\Cms\ContentPackage;
use Dms\Package\Content\Cms\Definition\ContentConfigDefinition;
use Dms\Package\Content\Cms\Definition\ContentGroupDefiner;
use Dms\Package\Content\Cms\Definition\ContentModuleDefinition;
use Dms\Package\Content\Cms\Definition\ContentPackageDefinition;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MyContentPackage extends ContentPackage
{

    protected $template;

    public function __construct(IIocContainer $container)
    {
        parent::__construct($container);
        $this->template = $container->get(TemplateRendererInterface::class);
    }

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
                ->withArrayOf('features', 'Features', function (ContentGroupDefiner $item) {
                    $item
                        ->withText('feature_heading', 'Feature Heading')
                        ->withHtml('feature_content', 'Feature Content')
                        ->withImage('feature_image', 'Feature Image')
                        ->withText('feature_image_caption', 'Feature Image Caption');
                })
                ->withMetadata('title', 'Meta - Title')
                ->withMetadata('description', 'Meta - Description')
                // Optionally define a preview callback to enable
                // live content previews in the CMS
                ->setPreviewCallback(function () {
                    return $this->template->render('app::home-page');
                })
                ;

            $module->group('about', 'About')
                    ->withText('title', 'Title')
                    ->withHtml('content', 'Content')
                    ->withMetadata('title', 'Meta - Title')
                    ->withMetadata('description', 'Meta - Description')
                    ->setPreviewCallback(function () {
                        return $this->template->render('app::about');
                    })
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
