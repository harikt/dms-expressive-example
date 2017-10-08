<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\TodoItem;
use App\Domain\Services\Persistence\ITodoItemRepository;
use Dms\Core\Persistence\Db\Connection\IConnection;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Persistence\DbRepository;

/**
 * The database repository implementation for the App\Domain\Entities\TodoItem entity.
 */
class DbTodoItemRepository extends DbRepository implements ITodoItemRepository
{
    public function __construct(IConnection $connection, IOrm $orm)
    {
        parent::__construct($connection, $orm->getEntityMapper(TodoItem::class));
    }
}
