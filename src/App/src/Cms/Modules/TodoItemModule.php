<?php declare(strict_types = 1);

namespace App\Cms\Modules;

use Dms\Core\Auth\IAuthSystem;
use Dms\Core\Common\Crud\CrudModule;
use Dms\Core\Common\Crud\Definition\CrudModuleDefinition;
use Dms\Core\Common\Crud\Definition\Form\CrudFormDefinition;
use Dms\Core\Common\Crud\Definition\Table\SummaryTableDefinition;
use App\Domain\Services\Persistence\ITodoItemRepository;
use App\Domain\Entities\TodoItem;
use Dms\Common\Structure\Field;

/**
 * The todo-item module.
 */
class TodoItemModule extends CrudModule
{

    public function __construct(ITodoItemRepository $dataSource, IAuthSystem $authSystem)
    {

        parent::__construct($dataSource, $authSystem);
    }

    /**
     * Defines the structure of this module.
     *
     * @param CrudModuleDefinition $module
     */
    protected function defineCrudModule(CrudModuleDefinition $module)
    {
        $module->name('todo-item');

        $module->labelObjects()->fromProperty(TodoItem::DESCRIPTION);

        $module->metadata([
            'icon' => ''
        ]);

        $module->crudForm(function (CrudFormDefinition $form) {
            $form->section('Details', [
                $form->field(
                    Field::create('description', 'Description')->string()->required()
                )->bindToProperty(TodoItem::DESCRIPTION),
                //
                $form->field(
                    Field::create('completed', 'Completed')->bool()
                )->bindToProperty(TodoItem::COMPLETED),
                //
            ]);

        });

        $module->removeAction()->deleteFromDataSource();

        $module->summaryTable(function (SummaryTableDefinition $table) {
            $table->mapProperty(TodoItem::DESCRIPTION)->to(Field::create('description', 'Description')->string()->required());
            $table->mapProperty(TodoItem::COMPLETED)->to(Field::create('completed', 'Completed')->bool());


            $table->view('all', 'All')
                ->loadAll()
                ->asDefault();
        });
    }
}
