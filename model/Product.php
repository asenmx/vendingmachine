<?php

namespace vending\model;

/**
 * Class Product.
 * Contains productName, size, and expireDate of the product.
 *
 * @package vending
 */
abstract class Product
{
    private $productName; // Name of product.
    private $size; // Size of product.
    private $expireDate; // Expire date of product.
    private $productId; // Id of product.

    /**
     * Product constructor.
     * Sets productName, quantity, size and expireDate.
     *
     * @param $productName sets productName
     * @param $size sets size of product
     * @param $expireDate set expire date of product
     * @param null $productId
     */
    public function __construct($productName, $size, $expireDate, $productId = null)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->size = $size;
        $this->expireDate = $expireDate;
    }

    /**
     * Sets price of  product.
     *
     * @param $price
     * @return mixed
     */
    abstract public function setPrice($price);

    /** Returns price of product.
     *
     * @return mixed
     */
    abstract public function getPrice();


    /**
     * Returns product name.
     *
     * @return product name
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Sets product name.
     *
     * @param $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }


    /**
     * Returns size of product.
     *
     * @return sets
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets size of product.
     *
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Returns expire date of product.
     *
     * @return set
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Sets expire date of product.
     *
     * @param $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
    }

    /**
     * Return productId.
     *
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Sets productId.
     *
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }
}