<?php

namespace App\Repositories;

use App\Models\TransportType;

class TransportTypeRepository
{
    public $transportType;

    /**
     * Constructor
     * 
     * @param TransportType $transportType
     *
     * @return void
     */
    public function __construct(TransportType $transportType)
    {
        $this->transportType = $transportType;
    }

    /**
     * Create TransportType
     * 
     * @param string $name
     *
     * @return void
     */
    public function create(string $name)
    {
        $this->transportType->create($name);
    }

    /**
     * Delete TransportType
     * 
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id)
    {
        $this->transportType->delete($id);
    }

    /**
     * Get all TransportTypes
     *
     * @return array
     */
    public function getAll()
    {
        $items = $this->transportType->getAll();

        foreach ($items as $key => $item) {
            $items[$key]->showLink = '/transportType/' . $item->id;
            $items[$key]->updateLink = '/transportType/update/' . $item->id;
        }

        return $items;
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
        return $this->transportType->update($id, $name);
    }

    /**
     * Get TransportType by id
     * 
     * @param int $id
     *
     * @return TransportType
     */
    public function getById(int $id)
    {
        return $this->transportType->getById($id);
    }

    /**
     * Check has same name
     * 
     * @param string $name
     *
     * @return bool
     */
    public function nameExists(string $name)
    {
        return $this->transportType->getByName($name);
    }
}
