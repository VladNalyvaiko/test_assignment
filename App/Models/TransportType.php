<?php

namespace App\Models;

use Core\Model;
use PDO;

class TransportType extends Model
{
    public $name;
    public $id;
    public $showLink;
    public $updateLink;

    /**
     * Create TransportType
     * 
     * @param string $name
     *
     * @return bool
     */
    public function create(string $name)
    {
        $sql = "INSERT INTO transport_types (name)
                VALUES (:name)";
        
        $stmt = $this->prepareQuery($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    /**
     * Delete TransportType
     * 
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $sql = 'DELETE FROM transport_types WHERE id=' . $id;

        $stmt = $this->prepareQuery($sql);
        return $stmt->execute();
    }

    /**
     * Update TransportType
     * 
     * @param int    $id
     * @param string $name
     *
     * @return bool
     */
    public function update(int $id, string $name)
    {
        $sql = 'UPDATE transport_types
            SET name=' . $name . '
            WHERE id=' . $id;

        $stmt = $this->prepareQuery($sql);
        return $stmt->execute();
    }

    /**
     * Get all TransportTypes
     *
     * @return array|bool
     */
    public function getAll()
    {
        $sql = "SELECT * FROM transport_types";

        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get TransportTypes by id
     * 
     * @param int $id
     *
     * @return TransportType|bool
     */
    public function getById(int $id)
    {
        $sql = "SELECT * FROM transport_types WHERE id =" . $id;
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Get TransportTypes by name
     * 
     * @param string $name
     *
     * @return TransportType|bool
     */
    public function getByName(string $name)
    {
        $sql = "SELECT * FROM transport_types WHERE name = '" . $name . "'";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();

        return $stmt->fetch();
    }
}
