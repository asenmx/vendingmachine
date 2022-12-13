<?php

namespace vending\model;

include_once __DIR__ . '/Product.php';

/**
 * Class Chips.
 * Extends product class.
 * Sets properties of extend product class
 * and adds price as property.
 *
 * @package vending
 */
class Chips extends Product
{
    CONST TYPEID = 2;
    CONST SIZE = 2;

    private $price;

    /**
     * Cola constructor.
     * Sets productName,size and expire date of product in abstract class and sets price.
     *
     * @param sets $price
     * @param sets $expireDate
     */
    public function __construct($price, $expireDate)
    {
        $productName = (new \ReflectionClass($this))->getShortName();

        $this->price = $price;
        parent::__construct($productName, self::SIZE, $expireDate);
    }

    /**
     * Returns price of product.
     *
     * @return sets
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Sets a price.
     * @param $price
     * @return mixed|void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Returns typeId of product.
     *
     * @return int
     */
    public function getTypeId(): int
    {
        return self::TYPEID;
    }

}
