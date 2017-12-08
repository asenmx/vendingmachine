<?php

namespace vending\controller;

use vending\model\Chips;
use vending\model\Cola;
use vending\model\Snikers;

include_once __DIR__ . '/../model/Chips.php';
include_once __DIR__ . '/../model/Cola.php';
include_once __DIR__ . '/../model/Snikers.php';

class Product
{

    public function createProducts()
    {
        $productArray = [];
        $checks = [];
        for ($x = 0; $x < (count($_POST) - 2) / 4; $x++) {
            if (($_POST["productExpireDate$x"] != '') || ($_POST["productCounter$x"] != '') || ($_POST["productPrice$x"] != '')) {
                $today = new \DateTime();
                if (($_POST["productCounter$x"] > 0) && ($_POST["productCounter$x"] != '')) {
                    $checks[] = true;
                    $validCounter = $_POST["productCounter$x"];
                    $validValues[$x]['validCounter'] = $validCounter;
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['invalidQuantity'] = true;
                }
                if ($_POST["productExpireDate$x"] != '') {
                    $htmlDate = $_POST["productExpireDate$x"];
                    $date = \DateTime::createFromFormat("Y-m-d", "$htmlDate");
                    if ($date->getTimestamp() >= $today->getTimestamp()) {
                        $checks[] = true;
                        $validValues[$x]['validDate'] = $date;
                    } else {
                        $checks[] = false;
                        $invalidValues[$x]['invalidDate'] = true;
                    }
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['invalidDate'] = true;
                }
                if (($_POST["productPrice$x"] > 0) && ($_POST["productPrice$x"] != '')) {
                    $checks[] = true;
                    $validPrice = $_POST["productPrice$x"];
                    $validValues[$x]['validPrice'] = $validPrice;
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['validPrice'] = true;

                }
            }
        }

        if (!in_array(false, $checks) && ($checks != null)) {
            for ($x = 0; $x < (count($_POST) - 2) / 4; $x++) {
                for ($y = 0; $y < $_POST["productCounter$x"]; $y++) {
                    switch ($_POST["productName$x"]) {
                        case "Cola":
                            $productOBJ = new Cola($_POST["productPrice$x"], $date);
                            break;
                        case "Chips":
                            $productOBJ = new Chips($_POST["productPrice$x"], $date);
                            break;
                        case "Snikers":
                            $productOBJ = new Snikers($_POST["productPrice$x"], $date);
                            break;
                    }
                    $productArray[] = $productOBJ;
                }
            }
        } else {
            $_SESSION['validValues'] = $validValues;
            header('location: index.php?action=loadMachineView');
        }
        $result = ["productArray" => $productArray];


        return $result;
    }
}





