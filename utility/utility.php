<?php

/**
 * Checks if value from array is set and returns it.
 *
 * @param $array
 * @param $value
 * @return mixed
 */
function showInput($array, $value)
{
    if (isset($array['validValues']["valid" . "$value"]) || isset($array['invalidValues']["invalid" . "$value"])) {
        if (isset($array['validValues']["valid" . "$value"])) {
            return $array['validValues']["valid" . "$value"];
        } else {
            return $array['invalidValues']["invalid" . "$value"];
        }
    }
}

/**
 * Checks if value is true and if its true returns "incorrect".
 * @param $array
 * @param $value
 * @return string
 */
function showInputRed($array, $value)
{
    if ($array['invalidValues']["invalid" . "$value" . "Red"] ?? false) {
        return 'incorrect';
    }
}

/**
 * Checks if value from array is set and returns it.
 *
 * @param $array
 * @param $value
 * @return mixed
 */
function showEditInput($array, $value)
{
    if (isset($array['validValues']["valid" . "$value"]) || isset($array['invalidValues']["invalid" . "$value"])) {
        if (isset($array['validValues']["valid" . "$value"])) {
            return $array['validValues']["valid" . "$value"];
        } else {
            return $array['invalidValues']["invalid" . "$value"];
        }
    } else {
        if (isset($array['machineData']["vendingMachine" . "$value"])) {
            return $array['machineData']["vendingMachine" . "$value"];
        }
    }
}

/**
 * Checks if value is true and if its true returns "incorrect".
 * @param $array
 * @param $counter
 * @param $value
 * @return string
 */
function showLoadInputRed($array, $counter, $value)
{
    if ($array['invalidValues'][$counter]["invalid" . "$value" . "Red"] ?? false) {
        return 'incorrect';
    }
}

/**
 * Checks if value from array is set and returns it.
 *
 * @param $array
 * @param $counter
 * @param $value
 * @return mixed
 */
function showLoadInput($array, $counter, $value)
{
    if (isset($array['validValues'][$counter]["valid" . "$value"]) || isset($array['invalidValues'][$counter]["ivalid" . "$value"])) {
        if (isset($array['validValues'][$counter]["valid" . "$value"])) {
            return $array['validValues'][$counter]["valid" . "$value"];
        } else {
            return $array['invalidValues'][$counter]["invalid" . "$value"];
        }
    }
}