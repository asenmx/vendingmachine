<?php

namespace vending\model\DAO;

use vending\model\DbConnector;

include_once __DIR__ . '/CRUDInterface.php';
include_once __DIR__ . '/../DbConnector.php';


/**
 * This class lets you do CRUD operations to cells table.
 *
 * @package vending\model
 */
class CellDAO implements CRUDInterface
{
    /**
     *Select All cells
     */
    public function selectAll()
    {
        $sql = 'SELECT * FROM `cells`';
        $db = new DbConnector();
        $data = $db->selectAllQuery($sql);
        $db->closeConnection();

        return $data;

    }

    /**
     * Select cell by ID.
     *
     * @param $cellId
     * @return mixed
     * @internal param $cellid
     */
    public function select($cellId)
    {
        $sql = 'SELECT * FROM `cells` WHERE cell_id = ?';
        $db = new DbConnector();
        $data = $db->selectByIdQuery($sql, $cellId);
        $db->closeConnection();

        return $data;
    }

    /**
     * Select cell by  MachineID.
     *
     * @param $machineId
     * @return mixed
     */
    public function selectCellByMachineId($machineId)
    {
        $sql = 'SELECT * FROM `cells` WHERE vending_machine_id = ?';
        $db = new DbConnector();
        $data = $db->selectQuery($sql, $machineId);
        $db->closeConnection();

        return $data;
    }


    /**
     * Insert into cells: vending_machine_id, cell_row, cell_column, combined_cell, cell_date_created.
     *
     * @param $insertParam
     * @return string
     */
    public function insert(iterable $insertParam)
    {
        $sql = 'INSERT INTO `cells` ( `vending_machine_id`, `cell_row`, `cell_column`, `cell_date_created`) VALUES (?, ?, ?, now())';
        $db = new DbConnector();
        $data = $db->executeQuery($sql, $insertParam);
        $db->closeConnection();

        return $data;
    }

    /**
     * Update cells selected by ID: vending_machine_id, cell_row, cell_column, combined_cell, cell_date_updated.
     *
     * @param $updateParam
     * @return mixed|void
     */
    public function update(iterable $updateParam)
    {
        $sql = 'UPDATE `cells` SET `vending_machine_id` = ?, `cell_row` = ?, `cell_column` = ?, `cell_date_updated` = now() WHERE `cells`.`cell_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $updateParam);
        $db->closeConnection();

    }

    /**
     * Delete cell by ID.
     *
     * @param $cellId
     * @return mixed|void
     */
    public function delete($cellId)
    {
        $sql = 'DELETE FROM `cells` WHERE `cells`.`cell_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $cellId);
        $db->closeConnection();
    }

    /**
     * Delete cell by machine id.
     *
     * @param $machineId
     */
    public function deleteByMachineId($machineId)
    {
        $sql = 'DELETE FROM `cells` WHERE `cells`.`vending_machine_id` = ?';
        $db = new DbConnector();
        $db->executeQuery($sql, $machineId);
        $db->closeConnection();
    }
}


