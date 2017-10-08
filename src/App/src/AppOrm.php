<?php declare(strict_types = 1);

namespace App;

use App\Domain\Entities\TodoItem;
use App\Infrastructure\Persistence\TodoItemMapper;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;
use Dms\Package\Analytics\Persistence\AnalyticsOrm;
use Dms\Package\Blog\Infrastructure\Persistence\BlogOrm;
use Dms\Package\ContactUs\Persistence\ContactUsOrm;
use Dms\Package\Content\Persistence\ContentOrm;
use Dms\Web\Expressive\Persistence\Db\DmsOrm;

/**
 * The application's orm.
 */
class AppOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->enableLazyLoading();

        $orm->encompass(DmsOrm::inDefaultNamespace());

        // TODO: Register your mappers...

        $orm->encompass((new BlogOrm($this->iocContainer))->inNamespace('blog_'));
        $orm->encompass(new ContentOrm($this->iocContainer));
        $orm->encompass(new ContactUsOrm());
        $orm->encompass(new AnalyticsOrm());
        $orm->entities([
            TodoItem::class => TodoItemMapper::class
        ]);
    }
}
