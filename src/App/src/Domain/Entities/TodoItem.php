<?php declare(strict_types = 1);

namespace App\Domain\Entities;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;

/**
 * Your first entity.
 *
 * An item on the TODO list.
 */
class TodoItem extends Entity
{
    // Define constants for property names
    const DESCRIPTION = 'description';
    const COMPLETED = 'completed';

    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $completed;

    /**
     * Initialises a new TODO item.
     *
     * @param string $description
     */
    public function __construct(string $description)
    {
        parent::__construct();
        $this->description = $description;
        $this->completed   = false;
    }

    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        // Enables strong typing for this entity
        $class->property($this->description)->asString();

        $class->property($this->completed)->asBool();
    }
}
