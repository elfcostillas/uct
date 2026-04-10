<?php

namespace App\Service;

class BaseService
{
    /**
     * Create a new class instance.
     */

    public function create($request)
    {
        return $this->model->create($request);
    }

    public function update($request)
    {
        $record = $this->model->find($request[$this->primaryKey]);

        if (!$record) {
            return null; // or throw an exception
        }

        $record->update($request);

        return $record;
    }   
}
