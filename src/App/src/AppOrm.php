<?php declare(strict_types = 1);

namespace App;

use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;
use Dms\Web\Expressive\Persistence\Db\DmsOrm;
use Dms\Package\Blog\Infrastructure\Persistence\BlogOrm;


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
    }
}
