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

    /**
     * Validates if input form for products is valid and if it's valid create products.
     * @return array
     */
    public static function createProducts()
    {
        $array = [];
        $productArray = [];
        $checks = [];
        for ($x = 0; $x < (count($_POST) - 2) / 4; $x++) {
            if (($_POST["productExpireDate$x"] != '') || ($_POST["productQuantity$x"] != '') || ($_POST["productPrice$x"] != '')) {
                $today = new \DateTime();
                if (($_POST["productQuantity$x"] > 0) && ($_POST["productQuantity$x"] != '') && (ctype_digit($_POST["productQuantity$x"]))) {
                    $checks[] = true;
                    $validValues[$x]['validQuantity'] = $_POST["productQuantity$x"];
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['invalidQuantityRed'] = true;
                    $invalidValues[$x]['invalidQuantity'] = $_POST["productQuantity$x"];
                }
                if ($_POST["productExpireDate$x"] != '') {
                    $htmlDate = $_POST["productExpireDate$x"];
                    $date = \DateTime::createFromFormat("Y-m-d", "$htmlDate");
                    if ($date->getTimestamp() >= $today->getTimestamp()) {
                        $checks[] = true;
                        $validValues[$x]['validDate'] = $htmlDate;

                    } else {
                        $checks[] = false;
                        $invalidValues[$x]['invalidDateRed'] = true;
                        $invalidValues[$x]['invalidDate'] = $htmlDate;
                    }
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['invalidDateRed'] = true;
                }
                if (($_POST["productPrice$x"] > 0) && ($_POST["productPrice$x"] != '')) {
                    $checks[] = true;
                    $validValues[$x]['validPrice'] = $_POST["productPrice$x"];
                } else {
                    $checks[] = false;
                    $invalidValues[$x]['invalidPriceRed'] = true;
                    $invalidValues[$x]['invalidPrice'] = $_POST["productPrice$x"];
                }
            }
        }
        if (!in_array(false, $checks) && ($checks != null)) {
            for ($x = 0; $x < (count($_POST) - 2) / 4; $x++) {
                for ($y = 0; $y < $_POST["productQuantity$x"]; $y++) {
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
                $array['validValues'] = null;
                $array['invalidValues'] = null;
            }
        } else {
            if (isset($validValues) && isset($invalidValues)) {
                $array['validValues'] = $validValues;
                $array['invalidValues'] = $invalidValues;
            }
        }
        $result = ['productArray' => $productArray, 'values' => $array];



        return $result;
    }
}





