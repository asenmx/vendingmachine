<?php

namespace vending\model;

/**
 * This Class connects you to database and perform Queries.
 *
 * @package vending
 */
class DbConnector
{
    const DSN = "mysql:dbname=vending_machine;host=127.0.0.1";
    const USER = "work";
    const PASSWORD = "workpass";

    private $dataBase;

    /**
     * DbConnector constructor.
     * Opens a connection to database.
     */
    public function __construct()
    {
        try {
            $this->dataBase = new \PDO(self::DSN, self::USER, self::PASSWORD);
            $this->dataBase->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Close the database connection.
     */
    public function closeConnection()
    {
        $this->dataBase = null;
    }

    /**
     * Takes sql and parameters for sql and performs  insert, update, delete query.
     *
     * @param $sql | holds the sql.
     * @param iterable| $parameters holds parameters for sql
     * @return string
     */
    public function executeQuery($sql, iterable $parameters)
    {
        $query = $this->dataBase->prepare($sql);
        $counter = 1;
        foreach ($parameters as $param) {
            $query->bindValue($counter++, $param);
        }
        try {
            $query->execute();
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }


        return $this->dataBase->lastInsertId();
    }

    /**
     * Takes sql and parameters for sql and performs select query.
     *
     * @param $sql | holds the sql.
     * @param iterable $parameters
     * @return array of the query
     */
    public function selectQuery($sql, iterable $parameters)
    {
        $query = $this->dataBase->prepare($sql);
        $counter = 1;
        foreach ($parameters as $param) {
            $query->bindValue($counter++, $param);
        }
        try {
            $query->execute();
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $camelCaseQuery = [];
        $result = $query->fetchAll();
        if ($result) {
            foreach ($result as $item) {
                $camelKeys = [];
                foreach ($item as $key => $value) {
                    $camelKey = lcfirst(implode('', array_map('ucfirst', explode('_', $key))));
                    $camelKeys[] = $camelKey;
                }
                $value2 = array_combine($camelKeys, $item);
                $camelCaseQuery[] = $value2;
            }

        }
        return $camelCaseQuery;
    }

    /**
     * Takes sql and parameters for sql and performs select query by id.
     *
     * @param $sql
     * @param $parameters
     * @return mixed
     */
    public function selectByIdQuery($sql, $parameters)
    {

        $query = $this->dataBase->prepare($sql);
        $counter = 1;
        foreach ($parameters as $param) {
            $query->bindValue($counter, $param);
            $counter++;
        }
        try {
            $query->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        $camelKeys = [];
        $camelCaseQuery = [];
        $result = $query->fetch();
        if ($result) {
            foreach ($result as $key => $value) {
                $camelKey = lcfirst(implode('', array_map('ucfirst', explode('_', $key))));
                $camelKeys[] = $camelKey;
            }
            $camelCaseQuery = array_combine($camelKeys, $result);
        }

        return $camelCaseQuery;
    }

    /**
     * Takes sql and parameters for sql and performs select query by id.
     *
     * @param $sql
     * @param $parameters
     * @return mixed
     */
    public function selectAllByIdQuery($sql, $parameters)
    {

        $query = $this->dataBase->prepare($sql);
        $counter = 1;
        foreach ($parameters as $param) {
            $query->bindValue($counter, $param);
            $counter++;
        }
        try {
            $query->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        $camelKeys = [];
        $camelCaseQuery = [];
        $result = $query->fetchAll();
        if ($result) {
            foreach ($result as $key => $value) {
                $camelKey = lcfirst(implode('', array_map('ucfirst', explode('_', $key))));
                $camelKeys[] = $camelKey;
            }
            $camelCaseQuery = array_combine($camelKeys, $result);
        }

        return $camelCaseQuery;
    }

    /** Select everything from Database.
     * @param $sql
     * @return array
     */
    public function selectAllQuery($sql)
    {
        $query = $this->dataBase->prepare($sql);
        try {
            $query->execute();
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $camelCaseQuery = [];
        $result = $query->fetchAll();
        if ($result) {
            foreach ($result as $item) {
                $camelKeys = [];
                foreach ($item as $key => $value) {
                    $camelKey = lcfirst(implode('', array_map('ucfirst', explode('_', $key))));
                    $camelKeys[] = $camelKey;
                }
                $value2 = array_combine($camelKeys, $item);
                $camelCaseQuery[] = $value2;
            }

        }
        return $camelCaseQuery;
    }

}

