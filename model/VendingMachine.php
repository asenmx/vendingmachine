<?php

namespace vending\model;


include_once __DIR__ . '/../model/DAO/MachineDAO.php';
include_once __DIR__ . '/../model/DAO/ActiveDaysDAO.php';
include_once __DIR__ . '/../model/DAO/CellDAO.php';
include_once __DIR__ . '/../model/DAO/ProductsDAO.php';
include_once __DIR__ . '/Cell.php';
include_once __DIR__ . '/Product.php';

/**
 * Class VendingMachine.
 * Create cell objects and map them to the machine, allows you to buy products and check their expiredate.
 *
 * @package vending
 */
class VendingMachine
{
    private $rowNumber; //Row numbers.
    private $columnNumber; //Column numbers.
    private $cellSize; //Cell size.
    private $cellMatrix; //Cell Matrix cells to machine.
    private $machineId; //Id of machine.
    private $machineName; //Name of machine.
    private $machineDesc; //Description of machine.
    private $machineStatus; //Status of machine.
    private $machineActiveDays; //Active days of machine.


    /**
     * Sets cell size.
     *
     * @param $cellSize
     */
    public function setCellSize($cellSize)
    {
        $this->cellSize = $cellSize;
    }

    /**
     * Returns cell size.
     *
     * @return mixed
     */
    public function getCellSize()
    {
        return $this->cellSize;
    }

    /**
     * Returns machine id.
     *
     * @return mixed
     */
    public function getMachineId()
    {
        return $this->machineId;
    }

    /**
     * Sets machine id.
     *
     * @param mixed $machineId
     */
    public function setMachineId($machineId): void
    {
        $this->machineId = $machineId;
    }


    /**
     * Returns number of rows.
     * @return mixed
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * Sets number of rows.
     *
     * @param mixed $rowNumber
     */
    public function setRowNumber($rowNumber): void
    {
        $this->rowNumber = $rowNumber;
    }

    /**
     * Returns number of columns.
     * @return mixed
     */
    public function getColumnNumber()
    {
        return $this->columnNumber;
    }

    /**
     * Sets number of columns.
     * @param mixed $columnNumber
     */
    public function setColumnNumber($columnNumber): void
    {
        $this->columnNumber = $columnNumber;
    }

    /**
     * Returns cell matrix.
     * @return mixed
     */
    public function getCellMatrix()
    {
        return $this->cellMatrix;
    }

    /**
     * Sets cell matrix.
     * @param mixed $cellMatrix
     */
    public function setCellMatrix($cellMatrix)
    {
        $this->cellMatrix = $cellMatrix;
    }

    /**
     * Returns machine name.
     *
     * @return mixed
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * Sets machine name.
     *
     * @param mixed $machineName
     */
    public function setMachineName($machineName): void
    {
        $this->machineName = $machineName;
    }

    /**
     * Returns machine description.
     *
     * @return mixed
     */
    public function getMachineDesc()
    {
        return $this->machineDesc;
    }

    /**
     * Sets machine description.
     *
     * @param mixed $machineDesc
     */
    public function setMachineDesc($machineDesc): void
    {
        $this->machineDesc = $machineDesc;
    }

    /**
     * Returns machine status.
     *
     * @return mixed
     */
    public function getMachineStatus()
    {
        return $this->machineStatus;
    }

    /**
     * Sets machine status.
     *
     * @param mixed $machineStatus
     */
    public function setMachineStatus($machineStatus): void
    {
        $this->machineStatus = $machineStatus;
    }

    /**
     * Returns machine active days.
     * @return mixed
     */
    public function getMachineActiveDays()
    {
        return $this->machineActiveDays;
    }

    /**
     * Sets machine active days.
     *
     * @param mixed $machineActiveDays
     */
    public function setMachineActiveDays($machineActiveDays): void
    {
        $this->machineActiveDays = $machineActiveDays;
    }

    /**
     * Returns specific cell from the cell matrix.
     *
     * @param $row
     * @param $column
     * @return mixed
     */
    public function getCell($row, $column)
    {
        return $this->cellMatrix[$row][$column];
    }

    /**
     * Sets specific row and column from the cell matrix.
     *
     * @param $row
     * @param $column
     * @param $value
     */
    public function setCell($row, $column, $value): void
    {

        $this->cellMatrix[$row][$column] = $value;
    }
}
