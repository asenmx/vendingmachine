<?php

namespace vending\model\DAO;

/**
 * CRUD operations.
 *
 * Interface CRUDInterface
 * @package vending\model
 */
interface CRUDInterface
{
    /**
     * Selects all.
     */
    public function selectAll();

    /**
     * Select by ID.
     *
     * @param $productId
     */
    public function select($productId);

    /**
     * Insert into database.
     *
     * @param $insertParam
     */
    public function insert(iterable $insertParam);

    /**
     * Update the database.
     *
     * @param iterable $updateParam
     * @return mixed
     */
    public function update(iterable $updateParam);

    /**
     * Delete from database.
     *
     * @param $productId
     * @return mixed
     */
    public function delete($productId);

}