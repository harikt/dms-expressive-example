<?php declare(strict_types = 1);

namespace App\Domain\Services\Persistence;

use Dms\Core\Model\ICriteria;
use Dms\Core\Model\ISpecification;
use Dms\Core\Persistence\IRepository;
use App\Domain\Entities\TodoItem;

/**
 * The repository for the App\Domain\Entities\TodoItem entity.
 */
interface ITodoItemRepository extends IRepository
{
    /**
     * {@inheritDoc}
     *
     * @return TodoItem[]
     */
    public function getAll() : array;

    /**
     * {@inheritDoc}
     *
     * @return TodoItem
     */
    public function get($id);

    /**
     * {@inheritDoc}
     *
     * @return TodoItem[]
     */
    public function getAllById(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return TodoItem|null
     */
    public function tryGet($id);

    /**
     * {@inheritDoc}
     *
     * @return TodoItem[]
     */
    public function tryGetAll(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return TodoItem[]
     */
    public function matching(ICriteria $criteria) : array;

    /**
     * {@inheritDoc}
     *
     * @return TodoItem[]
     */
    public function satisfying(ISpecification $specification) : array;
}
