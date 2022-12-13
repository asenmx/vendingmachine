<?php
/**
 * Created by PhpStorm.
 * User: toorhax
 * Date: 12/20/17
 * Time: 2:32 PM
 */

namespace vending\model\DAO;


use vending\model\DbConnector;

include_once __DIR__ . '/CRUDInterface.php';
include_once __DIR__ . '/../DbConnector.php';

class StatusDAO implements CRUDInterface
{

    /**
     * Selects all.
     */
    public function selectAll()
    {
        $sql = 'SELECT * FROM `status`';
        $db = new DbConnector();
        $data = $db->selectAllQuery($sql);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select by ID.
     * @param $statusId
     * @return mixed
     */
    public function select($statusId)
    {
        $sql = 'SELECT * FROM `status` WHERE status_id = ?';
        $db = new DbConnector();
        $data = $db->selectByIdQuery($sql, $statusId);
        $db->closeConnection();

        return $data;

    }

    /**
     * Insert into database.
     *
     * @param $insertParam
     * @return string
     */
    public function insert(iterable $insertParam)
    {
        $sql = 'INSERT INTO `status` (`status`)' .
            'VALUES (?)';
        $db = new DbConnector();
        $data = $db->executeQuery($sql, $insertParam);
        $db->closeConnection();

        return $data;
    }

    /**
     * Update the database.
     *
     * @param iterable $updateParam
     * @return mixed
     */
    public function update(iterable $updateParam)
    {
        $sql = 'UPDATE `status` SET `status` = ? WHERE `status_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $updateParam);
        $db->closeConnection();
    }

    /**
     * Delete from database.
     *
     * @param $statusId
     * @return mixed
     */
    public function delete($statusId)
    {
        $sql = 'DELETE FROM `status` WHERE `status_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $statusId);
        $db->closeConnection();
    }
}