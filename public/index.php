<?php

use \vending\controller\VendingMachineController;

include_once __DIR__ . '/../controller/Product.php';
include_once __DIR__ . '/../model/VendingMachine.php';
include_once __DIR__ . '/../controller/VendingMachineController.php';

if (!isset($_GET['action'])) {
    $action = 'default';
} else {
    $action = $_GET['action'];
}

switch ($action) {
    //Creates products and loads them in machine.
    case 'loadMachineView':
        $array = VendingMachineController::loadProductsView();
        $result = VendingMachineController::loadMachineView();
        $include = '../view/loadMachine.php';
        break;
    //Create machine.
    case 'createMachineView':
        $array = VendingMachineController::createMachineView();
        $include = '../view/createMachine.php';
        break;
    //Edit machine.
    case 'editMachineView':
        $array = VendingMachineController::editMachine();
        $include = '../view/editMachine.php';
        break;
    //Display machine.
    case 'displayMachineView':
        $machineData = VendingMachineController::displayMachine();
        $include = '../view/machine.php';
        break;
    //Display content of machine.
    case 'showContent':
        $machineData = VendingMachineController::machineContentView();
        $include = '../view/machineContent.php';
        break;
    //If url is invalid redirects you to the index page.
    case 'default':
        $include = '../view/index.php';
        break;
    //If url is invalid redirects you to the index page.
    default:
        $include = '../view/index.php';
}
include '../view/header.php';
include "$include";
include '../view/footer.php';
