<?php declare(strict_types=1);

namespace App\Cms;

use App\Cms\Modules\TodoItemModule;
use Dms\Core\Package\Definition\PackageDefinition;
use Dms\Core\Package\Package;

/**
 * The todo package.
 */
class TodoPackage extends Package
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
        $package->name('todo');

        $package->metadata([
            'icon' => 'list',
        ]);

        $package->modules([
            'todo-item' => TodoItemModule::class,
        ]);
    }
}
