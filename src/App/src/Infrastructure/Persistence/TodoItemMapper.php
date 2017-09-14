<?php declare(strict_types = 1);

namespace App\Infrastructure\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\EntityMapper;
use App\Domain\Entities\TodoItem;


/**
 * The App\Domain\Entities\TodoItem entity mapper.
 */
class TodoItemMapper extends EntityMapper
{
    /**
     * Defines the entity mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(TodoItem::class);
        $map->toTable('todo_items');

        $map->idToPrimaryKey('id');

        $map->property(TodoItem::DESCRIPTION)->to('description')->asVarchar(255);

        $map->property(TodoItem::COMPLETED)->to('completed')->asBool();


    }
}