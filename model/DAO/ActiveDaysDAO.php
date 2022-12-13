<?php

namespace vending\model\DAO;

use vending\model\DbConnector;

include_once __DIR__ . '/CRUDInterface.php';
include_once __DIR__ . '/../DbConnector.php';

class ActiveDaysDAO implements CRUDInterface
{


    /**
     * Selects all.
     */
    public function selectAll()
    {
        $sql = 'SELECT * FROM `active_days` ';
        $db = new DbConnector();
        $data = $db->selectAllQuery($sql);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select all by ID.
     *
     * @param $machineId
     * @return mixed
     */
    public function selectAllById($machineId)
    {
        $sql = 'SELECT * FROM `active_days` WHERE machine_id = ? ';
        $db = new DbConnector();
        $data = $db->selectAllByIdQuery($sql, $machineId);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select by ID.
     *
     * @param $machineId
     * @return mixed
     */
    public function select($machineId)
    {
        $sql = 'SELECT * FROM `active_days` WHERE machine_id = ?';
        $db = new DbConnector();
        $data = $db->selectByIdQuery($sql, $machineId);
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
        $sql = 'INSERT INTO `active_days` (`machine_id`, `day_id`)' .
            'VALUES (?, ?)';
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
        $sql = 'UPDATE `active_days` SET `machine_id` = ?, `day_id` = ? WHERE `machine_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $updateParam);
        $db->closeConnection();
    }

    /**
     * Delete from database.
     *
     * @param $machineId
     * @return mixed
     */
    public function delete($machineId)
    {
        $sql = 'DELETE FROM `active_days` WHERE `machine_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $machineId);
        $db->closeConnection();
    }
}