<?php

namespace vending\model\DAO;

use vending\model\DbConnector;

include_once __DIR__ . '/CRUDInterface.php';
include_once __DIR__ . '/../DbConnector.php';

class DaysDAO implements CRUDInterface
{

    /**
     * Selects all.
     */
    public function selectAll()
    {
        $sql = 'SELECT * FROM `days` ';
        $db = new DbConnector();
        $data = $db->selectAllQuery($sql);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select by ID.
     *
     * @param $dayId
     * @return mixed
     */
    public function select($dayId)
    {
        $sql = 'SELECT * FROM `days` WHERE `day_id` = ?';
        $db = new DbConnector();
        $data = $db->selectByIdQuery($sql, $dayId);
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
        $sql = 'INSERT INTO `days` (`days`) VALUES (?)';
        $db = new DbConnector();
        $data = $db->executeQuery($sql, $insertParam);
        $db->closeConnection();

        return $data;
    }

    /**
     * Update the database.
     *
     * @param iterable $updateParam
     * @return mixed|void
     */
    public function update(iterable $updateParam)
    {
        $sql = 'UPDATE `days` SET `days` = ? WHERE `day_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $updateParam);
        $db->closeConnection();
    }

    /**
     * Delete from database.
     *
     * @param $dayId
     * @return mixed|void
     */
    public function delete($dayId)
    {
        $sql = 'DELETE FROM `days` WHERE `day_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $dayId);
        $db->closeConnection();
    }
}