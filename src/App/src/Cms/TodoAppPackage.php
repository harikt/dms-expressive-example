<?php declare(strict_types = 1);

namespace App\Cms;

use App\Cms\Modules\TodoItemModule;
use Dms\Core\Package\Definition\PackageDefinition;
use Dms\Core\Package\Package;

/**
 * The TodoApp package.
 */
class TodoAppPackage extends Package
{
    /**
     * Defines the structure of this cms package.
     *
     * @param PackageDefinition $package
     *
     * @return void
     */
    protected function define(PackageDefinition $package)
    {
        $package->name('todo-app');

        $package->metadata([
            'icon' => '',
        ]);

        $package->modules([
            'todo-item' => TodoItemModule::class,
        ]);
    }
}
