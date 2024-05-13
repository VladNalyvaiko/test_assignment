<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected function getDB()
    {
        static $db = null;
        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST
                . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    /**
     * Prepare query
     *
     * @param string $sql
     * 
     * @return mixed
     */
    protected function prepareQuery(string $sql)
    {
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt;
    }
}