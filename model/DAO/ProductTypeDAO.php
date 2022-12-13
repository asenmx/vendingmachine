<?php

namespace vending\model\DAO;

use vending\model\DbConnector;

include_once __DIR__ . '/CRUDInterface.php';
include_once __DIR__ . '/../DbConnector.php';

/**
 * This class lets you do CRUD operations to product table.
 *
 * @package vending\model
 */
class ProductTypeDAO implements CRUDInterface
{
    /**
     * Selects all from product_types.
     */
    public function selectAll()
    {
        $sql = 'SELECT * FROM `product_types`';
        $db = new DbConnector();
        $data = $db->selectAllQuery($sql);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select Product_types by ID.
     *
     * @param $product_type_id
     * @return mixed
     */
    public function select($product_type_id)
    {
        $sql = 'SELECT * FROM `product_types` WHERE product_type_id = ?';
        $db = new DbConnector;
        $data = $db->selectByIdQuery($sql, $product_type_id);
        $db->closeConnection();

        return $data;
    }

    /**
     * Insert into Products:
     * product_type_id, product_type_name.
     *
     * @param $insertParam
     * @return string
     */
    public function insert(iterable $insertParam)
    {
        $sql = 'INSERT INTO `product_types` (`product_type_id`, `product_type_name`) VALUES (?, ?)';
        $db = new DbConnector();
        $data = $db->executeQuery($sql, $insertParam);
        $db->closeConnection();

        return $data;
    }

    /**
     * Update product_types selected by ID : product_type_name.
     *
     * @param $updateParam
     * @return mixed|void
     */
    public function update(iterable $updateParam)
    {
        $sql = 'UPDATE `product_types` SET `product_type_name` = ? WHERE `product_types`.`product_type_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $updateParam);
        $db->closeConnection();
    }

    /**Delete product_type by ID.
     *
     * @param $product_type_id
     * @return mixed|void
     */
    public function delete($product_type_id)
    {
        $sql = 'DELETE FROM `product_types` WHERE `product_types`.`product_type_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $product_type_id);
        $db->closeConnection();
    }
}