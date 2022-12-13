<?php

namespace vending\controller;


use vending\model\Cell;
use vending\model\Chips;
use vending\model\Cola;
use vending\model\DAO\CellDAO;
use vending\model\Snikers;
use vending\model\VendingMachine;
use vending\model\DAO\ActiveDaysDAO;
use vending\model\DAO\MachineDAO;
use vending\model\DAO\ProductsDAO;
use vending\model\DAO\DaysDAO;
use vending\model\DAO\ProductTypeDAO;
use vending\model\DAO\StatusDAO;

include_once __DIR__ . '/../model/DAO/MachineDAO.php';
include_once __DIR__ . '/../model/DAO/ActiveDaysDAO.php';
include_once __DIR__ . '/../model/DAO/CellDAO.php';
include_once __DIR__ . '/../model/DAO/ProductsDAO.php';
include_once __DIR__ . '/../model/Cell.php';
include_once __DIR__ . '/../model/VendingMachine.php';
include_once __DIR__ . '/Product.php';
include_once __DIR__ . '/../model/DAO/ProductTypeDAO.php';
include_once __DIR__ . '/../model/DAO/StatusDAO.php';
include_once __DIR__ . '/../model/DAO/DaysDAO.php';
include_once __DIR__ . '/../model/Chips.php';
include_once __DIR__ . '/../model/Cola.php';
include_once __DIR__ . '/../model/Snikers.php';


class VendingMachineController
{
    /**
     * Create new machine.
     * @param $rowNumber
     * @param $columnNumber
     * @param $cellSize
     * @param $machineName
     * @param $machineDesc
     * @param $machineStatus
     * @param $machineActiveDays
     */
    public function createMachine($rowNumber, $columnNumber, $cellSize, $machineName, $machineDesc, $machineStatus, $machineActiveDays)
    {
        $vendingMachine = new VendingMachine();
        $machineDao = new MachineDAO();
        $activeDaysDB = new ActiveDaysDAO();
        $machineId = $machineDao->insert(array($rowNumber, $columnNumber, $cellSize, $machineName, $machineDesc, $machineStatus));
        $vendingMachine->setMachineId($machineId);
        $vendingMachine->setColumnNumber($columnNumber);
        $vendingMachine->setRowNumber($rowNumber);
        $vendingMachine->setCellSize($cellSize);
        $vendingMachine->setMachineName($machineName);
        $vendingMachine->setMachineDesc($machineDesc);
        $vendingMachine->setMachineStatus($machineStatus);
        $vendingMachine->setMachineActiveDays($machineActiveDays);
        foreach ($machineActiveDays as $dayId) {
            $activeDaysDB->insert([$vendingMachine->getMachineId(), $dayId]);
        }
        $this->defineMachine($vendingMachine);
    }

    /**
     * Create new cell and cellMatrix it to machine.
     *
     * @param $vendingMachine
     */
    public function defineMachine($vendingMachine)
    {
        $cellDAO = new CellDAO();
        $vendingMachine->setCellMatrix([]);
        for ($row = 0; $row < $vendingMachine->getRowNumber(); $row++) {
            for ($column = 0; $column < $vendingMachine->getColumnNumber(); $column++) {
                $cellId = $cellDAO->insert([$vendingMachine->getMachineId(), $row, $column]);
                $cellMatrix[$row][$column] = new Cell($vendingMachine->getCellSize(), $cellId);
            }
        }
        $vendingMachine->setCellMatrix($cellMatrix);
    }

    /**
     * Loads machine data from the Mysql Database.
     *
     * @param $machineId
     * @return VendingMachine
     */
    public function loadMachine($machineId)
    {
        $vendingMachine = new VendingMachine();
        $machineDao = new MachineDAO();
        $machineData = $machineDao->select([$machineId]);
        if (($machineData) != null) {
            $vendingMachine->setMachineId($machineData['vendingMachineId']);
            $vendingMachine->setRowNumber($machineData['vendingMachineRows']);
            $vendingMachine->setColumnNumber($machineData['vendingMachineColumns']);
            $vendingMachine->setCellSize($machineData['vendingMachineSize']);
            $cellDAO = new CellDAO();
            $productData = new ProductsDAO();
            $cellDB = $cellDAO->selectCellByMachineId([$machineId]);
            if (($cellDB) != null) {
                $cellMatrix = [];
                $vendingMachine->setCellMatrix($cellMatrix);
                $counter = 0;
                for ($row = 0; $row < $vendingMachine->getRowNumber(); $row++) {
                    for ($column = 0; $column < $vendingMachine->getColumnNumber(); $column++) {
                        $value = new Cell($vendingMachine->getCellSize(), $cellDB[$counter]['cellId']);
                        $vendingMachine->setCell($cellDB[$counter]['cellRow'], $cellDB[$counter]['cellColumn'], $value);
                        $counter++;
                        $productDB = $productData->selectProductByCellId([$vendingMachine->getCell($row, $column)->getCellId()]);
                        if ($productDB != null) {
                            foreach ($productDB as $product) {
                                switch ($product['productTypeId']) {
                                    case Cola::TYPEID:
                                        $productOBJ = new Cola($product['productPrice'], $product['productExpireDate']);
                                        break;
                                    case Chips::TYPEID:
                                        $productOBJ = new Chips($product['productPrice'], $product['productExpireDate']);

                                        break;
                                    case Snikers::TYPEID:
                                        $productOBJ = new Snikers($product['productPrice'], $product['productExpireDate']);

                                        break;
                                }
                                $productOBJ->setProductId($product['productId']);

                                $vendingMachine->getCell($row, $column)->setProduct($productOBJ);
                            }
                        }
                    }
                }
            }

            return $vendingMachine;
        }
    }

    /**
     * Loads product objects into cells.
     *
     * @param array|iterable $productArray array of objects of products
     * @return array
     */
    public static function loadProducts(iterable $productArray, $vendingMachine)
    {
        $productDAO = new ProductsDAO();
        foreach ($productArray as $key => $product) {
            foreach ($vendingMachine->getCellMatrix() as $matrix) {
                foreach ($matrix as $cell) {
                    if ($product->getSize() <= $cell->getSize()) {
                        if ((is_null($cell->getProducts())) ||
                            ($cell->getProductFromArray() != null &&
                                (($cell->getProductFromArray()->getProductName()) == ($product->getProductName())
                                    && (($cell->getSize() / $product->getSize()) > $cell->getQuantity())))
                        ) {
                            $cell->setProduct($product);
                            $productId = $productDAO->insert([
                                $product->getTypeId(),
                                $product->getPrice(),
                                $product->getExpireDate()->format('Y/m/d h:m:s'),
                                $product->getSize(),
                                $cell->getCellId()
                            ]);
                            $product->setProductId($productId);
                            unset($productArray[$key]);
                            break 2;
                        }
                    }
                }
            }
        }
        if ($productArray == !null) {
            return $productArray;
        }
    }

    /**
     *Delete Machine and everything in it.
     */
    public static function deleteMachine($vendingMachine)
    {
        $productDAO = new ProductsDAO();
        $cellDAO = new CellDAO();
        $machineDAO = new MachineDAO();
        if ($vendingMachine->getCellMatrix() !== null) {
            foreach ($vendingMachine->getCellMatrix() as $cells) {
                foreach ($cells as $cell) {
                    $cellIdArray[] = $cell->getCellId();
                }
            }
            $productDAO->deleteByCellId($cellIdArray);
        }
        $cellDAO->deleteByMachineId([$vendingMachine->getMachineId()]);
        if ($vendingMachine->getMachineId() !== null) {
            $machineDAO->delete([$vendingMachine->getMachineId()]);
        }
    }

    /**
     * Merge 2 cells into one from left to right.
     * Example: cell with coordinates 1,1 merged with 2,2
     *
     * @param $firstCellRow - row of the first cell you want to combine
     * @param $firstCellColumn - column of first the cell you want to combine
     * @param $secondCellRow - row of the second cell you want to combine
     * @param $secondCellColumn - column of second the cell you want to combine
     * @throws \Exception
     */
    public static function combineCells($firstCellRow, $firstCellColumn, $secondCellRow, $secondCellColumn, $vendingMachine)
    {
        $vendingMachine = new VendingMachine();

        if (($firstCellRow == $secondCellRow) && ($secondCellColumn == $firstCellColumn + 1)) {
            if (($vendingMachine->getCell($firstCellRow, $firstCellColumn)) && ($vendingMachine->getCell($secondCellRow, $secondCellColumn))) {
                $vendingMachine->getCell($firstCellRow, $firstCellColumn)->setSize($vendingMachine->getCell($firstCellRow, $firstCellColumn)->getSize() * 2);
                $vendingMachine->getCell($secondCellRow, $secondCellColumn)->setSize(0);
            } else {
                throw new \Exception("Cell doesn't exist");
            }
        } else {
            throw new \Exception("You can combine only cells on same row from left to right");
        }
    }

    /**
     *Lets you buy a product.
     *
     * @param $row
     * @param $column
     * @param $price
     * @return string
     * @throws \Exception
     */
    public static function buyProduct($row, $column, $price, $vendingMachine)
    {
        $productDAO = new ProductsDAO();
        if ((count($vendingMachine->getCell([$row][$column])->getProducts()) > 0)) {
            if ($price >= ($vendingMachine->getCell([$row][$column])->getProductFromArray()->getPrice())) {
                $vendingMachine->getCell([$row][$column])->removeProduct(0);
                $productDAO->delete([$vendingMachine->getCell([$row][$column])->getProductFromArray()->getProductId()]);
                return ($price - ($vendingMachine->getCell([$row][$column])->getProductFromArray()->getPrice()));
            } else {
                return ($price - ($vendingMachine->getCell([$row][$column])->getProductFromArray()->getPrice()));

            }
        } else {
            throw new \Exception(" Product not found.");
        }
    }

    /**
     * Displays all products from machine.
     */
    public static function listItems($vendingMachine)
    {

        if ($vendingMachine->getCellMatrix() !== null) {
            foreach ($vendingMachine->getCellMatrix() as $matrix) {
                foreach ($matrix as $cell) {
                    if (null !== $cell->getProductFromArray()) {
                        return $cell->getProductFromArray()->getProductName() . ' ' . ($cell->getQuantity()) . "\n";
                    }
                }
            }
        }
    }

    /**
     *Checks if there are expired products and remove them.
     */
    public static function removeExpiredProducts($vendingMachine)
    {
        $productDAO = new ProductsDAO();
        $productDAO->deleteExpired();
        foreach ($vendingMachine->getCellMatrix() as $matrix) {
            $counter = 0;
            foreach ($matrix as $cell) {
                if ($cell->getProducts() !== null) {
                    foreach ($cell->getProducts() as $products) {
                        if ((strtotime($products->getExpireDate())) < strtotime(new \DateTime())) {
                            $cell->removeProduct($counter);
                        } else {
                            $counter++;
                        }
                    }
                }
            }
        }
    }

    /**
     * Checks if the input form is valid and if it's valid edit's the machine, otherwise returns you to the form.
     *
     * @return mixed
     */
    public static function editMachine()
    {
        $machine = new MachineDAO();
        $activeDaysDB = new ActiveDaysDAO();
        if (isset($_GET['machineId'])) {
            $array['checkedDays'] = $activeDaysDB->selectAllById([$_GET['machineId']]);
        } else {
            $array['checkedDays'] = $activeDaysDB->selectAllById([$_POST['vendingMachineId']]);
        }
        $array['days'] = VendingMachineController::machineDaysView();
        if (isset($_GET['machineId'])) {
            $array['machineData'] = $machine->select([$_GET['machineId']]);
        } else {
            $array['machineData'] = $machine->select([$_POST['vendingMachineId']]);
        }
        $array['status'] = VendingMachineController::machineStatusView();
        $checks = [];
        if (!empty($_POST)) {
            if (($_POST['machineRows'] != '') || ($_POST['machineColumns'] != '') || ($_POST['machineSize'] != '')) {

                if (($_POST['machineRows'] > 0) && ($_POST['machineRows'] != '') && ctype_digit($_POST['machineRows'])) {
                    $checks[] = true;
                    $validValues['validRows'] = $_POST['machineRows'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidRowsRed'] = true;
                    $invalidValues['invalidRows'] = $_POST['machineRows'];
                }

                if (($_POST['machineColumns'] > 0) && ($_POST['machineColumns'] != '') && ctype_digit($_POST['machineColumns'])) {
                    $checks[] = true;
                    $validValues['validColumns'] = $_POST['machineColumns'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidColumnsRed'] = true;
                    $invalidValues['invalidColumns'] = $_POST['machineColumns'];
                }

                if (($_POST['machineSize'] > 0) && ($_POST['machineSize'] != '') && ctype_digit($_POST['machineSize'])) {
                    $checks[] = true;
                    $validValues['validSize'] = $_POST['machineSize'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidSizeRed'] = true;
                    $invalidValues['invalidSize'] = $_POST['machineSize'];
                }

                if (trim($_POST['machineDesc']) != '') {
                    $checks[] = true;
                    $validValues['validDesc'] = trim(htmlentities($_POST['machineDesc']));
                } else {
                    $checks[] = false;
                    $invalidValues['invalidDescRed'] = true;
                    $invalidValues['invalidDesc'] = trim(htmlentities($_POST['machineDesc']));
                }

                if (trim($_POST['machineName']) != '') {
                    $checks[] = true;
                    $validValues['validName'] = trim(htmlentities($_POST['machineName']));
                } else {
                    $checks[] = false;
                    $invalidValues['invalidNameRed'] = true;
                    $invalidValues['invalidName'] = trim(htmlentities($_POST['machineName']));
                }

                if (isset($_POST['machineStatus'])) {
                    if (($_POST['machineStatus'] > 0) && ($_POST['machineStatus'] != '') && ctype_digit($_POST['machineStatus'])) {
                        $statusDb = new StatusDAO();
                        $data = $statusDb->select([$_POST['machineStatus']]);
                        if (!empty($data)) {
                            $checks[] = true;
                            $validValues['validStatus'] = $_POST['machineStatus'];
                        } else {
                            $checks[] = false;
                            $invalidValues['invalidStatusRed'] = true;
                            $invalidValues['invalidStatus'] = $_POST['machineStatus'];
                        }
                    }
                } else {
                    $checks[] = false;
                    $invalidValues['invalidStatusRed'] = true;
                    $validValues['invalidStatus'] = '';
                }
                $validValues['validDays'] = [];
                if (isset($_POST['days'])) {
                    foreach ($_POST['days'] as $day) {
                        if (($day > 0) && ($day != '') && ctype_digit($day)) {
                            $daysDb = new DaysDAO();
                            $data = $daysDb->select([$day]);
                            if (!empty($data)) {
                                $checks[] = true;
                                $validValues['validDays'][] = $day;
                            } else {
                                $checks[] = false;
                                $invalidValues['invalidDaysRed'] = true;
                            }
                        } else {
                            $checks[] = false;
                            $invalidValues['invalidDaysRed'] = true;
                        }
                    }
                } else {
                    $checks[] = false;
                    $invalidValues['invalidDaysRed'] = true;
                }
            }
        }
        if (!in_array(false, $checks) && ($checks != null)) {
            $machine->update(array($_POST['machineRows'], $_POST['machineColumns'], $_POST['machineSize'],
                $_POST['machineStatus'], $_POST['machineName'], $_POST['machineDesc'], $_POST['vendingMachineId']));
            $activeDaysDB->delete([$_POST['vendingMachineId']]);
            foreach ($_POST['days'] as $dayId) {
                $activeDaysDB->insert([$_POST['vendingMachineId'], $dayId]);
            }
            header('location: index.php?action=displayMachineView');
        } else {
            if (isset($validValues) && isset($invalidValues)) {
                $array['validValues'] = $validValues;
                $array['invalidValues'] = $invalidValues;
            }

            return $array;
        }

        return $array;
    }


    /**
     * Checks if the input form is valid and if it's valid creates the machine, otherwise returns you to the form.
     *
     * @return mixed
     */
    public static function createMachineView()
    {

        $array['days'] = VendingMachineController::machineDaysView();
        $array['status'] = VendingMachineController::machineStatusView();
        $checks = [];
        if (!empty($_POST)) {
            if (($_POST['machineRows'] != '') || ($_POST['machineColumns'] != '') || ($_POST['machineSize'] != '')) {

                if (($_POST['machineRows'] > 0) && ($_POST['machineRows'] != '') && ctype_digit($_POST['machineRows'])) {
                    $checks[] = true;
                    $validValues['validRows'] = $_POST['machineRows'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidRowsRed'] = true;
                    $invalidValues['invalidRows'] = $_POST['machineRows'];
                }

                if (($_POST['machineColumns'] > 0) && ($_POST['machineColumns'] != '') && ctype_digit($_POST['machineColumns'])) {
                    $checks[] = true;
                    $validValues['validColumns'] = $_POST['machineColumns'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidColumnsRed'] = true;
                    $invalidValues['invalidColumns'] = $_POST['machineColumns'];
                }

                if (($_POST['machineSize'] > 0) && ($_POST['machineSize'] != '') && ctype_digit($_POST['machineSize'])) {
                    $checks[] = true;
                    $validValues['validSize'] = $_POST['machineSize'];
                } else {
                    $checks[] = false;
                    $invalidValues['invalidSizeRed'] = true;
                    $invalidValues['invalidSize'] = $_POST['machineSize'];
                }

                if (trim($_POST['machineDesc']) != '') {
                    $checks[] = true;
                    $validValues['validDesc'] = trim(htmlentities($_POST['machineDesc']));
                } else {
                    $checks[] = false;
                    $invalidValues['invalidDescRed'] = true;
                    $invalidValues['invalidDesc'] = trim(htmlentities($_POST['machineDesc']));
                }

                if (trim($_POST['machineName']) != '') {
                    $checks[] = true;
                    $validValues['validName'] = trim(htmlentities($_POST['machineName']));
                } else {
                    $checks[] = false;
                    $invalidValues['invalidNameRed'] = true;
                    $invalidValues['invalidName'] = trim(htmlentities($_POST['machineName']));
                }

                if (isset($_POST['machineStatus'])) {
                    if (($_POST['machineStatus'] > 0) && ($_POST['machineStatus'] != '') && ctype_digit($_POST['machineStatus'])) {
                        $statusDb = new StatusDAO();
                        $data = $statusDb->select([$_POST['machineStatus']]);
                        if (!empty($data)) {
                            $checks[] = true;
                            $validValues['validStatus'] = $_POST['machineStatus'];
                        } else {
                            $checks[] = false;
                            $invalidValues['invalidStatusRed'] = true;
                            $invalidValues['invalidStatus'] = $_POST['machineStatus'];
                        }
                    }
                } else {
                    $checks[] = false;
                    $invalidValues['invalidStatusRed'] = true;
                    $validValues['invalidStatus'] = '';
                }

                $validValues['validDays'] = [];
                if (isset($_POST['days'])) {
                    foreach ($_POST['days'] as $day) {
                        if (($day > 0) && ($day != '') && ctype_digit($day)) {
                            $daysDb = new DaysDAO();
                            $data = $daysDb->select([$day]);
                            if (!empty($data)) {
                                $checks[] = true;
                                $validValues['validDays'][] = $day;
                            } else {
                                $checks[] = false;
                                $invalidValues['invalidDaysRed'] = true;
                            }
                        } else {
                            $checks[] = false;
                            $invalidValues['invalidDaysRed'] = true;
                        }
                    }
                } else {
                    $checks[] = false;
                    $invalidValues['invalidDaysRed'] = true;
                }
            }
        }

        if (!in_array(false, $checks) && ($checks != null)) {

            self::createMachine($_POST['machineRows'], $_POST['machineColumns'], $_POST['machineSize'], $_POST['machineName'], $_POST['machineDesc'], $_POST['machineStatus'], $_POST['days']);
            header('location: index.php?action=loadMachineView');
            $array['validValues'] = null;
            $array['invalidValues'] = null;
        } else {
            if (isset($validValues) && isset($invalidValues)) {
                $array['validValues'] = $validValues;
                $array['invalidValues'] = $invalidValues;
            }
            return $array;
        }
    }


    /**
     * Displays machine status in input form.
     *
     * @return array
     */
    public static function displayMachine()
    {

        $counter = 0;
        $machine = new MachineDAO();
        $status = new StatusDAO();
        $days = new ActiveDaysDAO();
        $machineData['machineData'] = $machine->selectAll();
        foreach ($machineData['machineData'] as $machine) {
            $statusData = $status->select([$machine['vendingMachineStatusId']]);
            $daysData = $days->selectAllById([$machine['vendingMachineId']]);
            $machineData['machineData'][$counter]['vendingMachineDays'] = $daysData;
            $machineData['machineData'][$counter++]['vendingMachineStatus'] = $statusData['status'];
        }
        $machineData['daysList'] = VendingMachineController::machineDaysView();

        return $machineData;
    }

    /**
     * Displays Machine Id and Products type in input form.
     *
     * @return array
     */
    public static function loadMachineView()
    {
        $machine = new MachineDAO();
        $machineData = $machine->selectAll();
        $productTypes = new ProductTypeDAO();
        $productTypesArray = $productTypes->selectAll();
        $result = ['machineData' => $machineData, 'productType' => $productTypesArray];

        return $result;
    }

    /**
     * Calls createProduct method from Product class that creates products and then loads them in the machine.
     * @return mixed
     */
    public static function loadProductsView()
    {

        $result = Product::createProducts();
        if ($result['productArray'] != null) {
            $machineObj = self::loadMachine($_POST['machineId']);
            self::loadProducts($result['productArray'], $machineObj);
            header('location: index.php?action=displayMachineView');
        }

        return $result['values'];
    }

    /**
     * Gets all statues from db and returns them.
     *
     * @return array|StatusDAO
     */
    public static function machineStatusView()
    {
        $status = new StatusDAO();
        $status = $status->selectAll();

        return $status;
    }

    /**
     * Gets all week days from db and returns them.
     *
     * @return array
     */
    public static function machineDaysView()
    {
        $daysDb = new DaysDAO();
        $daysData = $daysDb->selectAll();

        return $daysData;
    }

    /**
     * Gets all cells that aren't empty and returns their content.
     * @return mixed
     */
    public static function machineContentView()
    {

        $machine = new MachineDAO();
        $machineData = $machine->machineContent([$_GET['machineId']]);

        return $machineData;
    }
}