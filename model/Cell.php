<?php

namespace vending\model;

/**
 * Class Cell
 * contains objects of product class
 *
 * @package vending
 */
class Cell
{
    private $products; // contains the product object.
    private $size; // size of cell.
    private $cellId; // Id of the cell.

    /**
     * Sets size of cells.
     * Cell constructor.
     *
     * @param $size
     * @param $cellId
     */
    public function __construct($size, $cellId)
    {
        $this->size = $size;
        $this->cellId = $cellId;

    }

    /**
     * Returns product object.
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Sets product object.
     *
     * @param $product
     */
    public function setProduct($product)
    {
        $this->products[] = $product;
    }

    /**
     * Returns quantity of products in the cell.
     *
     * @return int
     */
    public function getQuantity()
    {
        return count($this->products);
    }


    /**
     * Returns size of cell.
     *
     * @return
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets size of cell.
     *
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }


    /**
     * Returns first product from the products array.
     *
     * @return mixed
     */
    public function getProductFromArray()
    {
        return $this->products[0];
    }

    /**
     * Pops product from array.
     *
     * @return mixed
     */
    public function popProduct()
    {
        array_pop($this->products);
    }

    /**
     * Remove product from products array and reformat it.
     *
     * @param $x
     */
    public function removeProduct($x)
    {
        unset($this->products[$x]);
        $this->products = array_values($this->products);
    }

    /**
     * Returns CellId.
     *
     * @return mixed
     */
    public function getCellId()
    {
        return $this->cellId;
    }

    /**
     * Sets CellId.
     *
     * @param mixed $cellId
     */
    public function setCellId($cellId)
    {
        $this->cellId = $cellId;
    }
}