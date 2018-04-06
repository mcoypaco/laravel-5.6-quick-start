<?php

namespace App\Repositories;

use App\Repositories\Contracts\Resource; 
use App\Repositories\Support\Resourceful; 

class Repository implements Resource
{
    use Resourceful;

    /**
     * Number of items per paging.
     * 
     * @return integer
     */
    public function itemsPerPage()
    {
        return isset($this->limit) ? $this->limit : 10;
    }

    /**
     * Get the path for the Eloquent model.
     * 
     * @return string
     */
    public function model()
    {
        return $this->modelPath;
    }

    /**
     * Create a resource instance for the Eloquent model.
     * 
     * @param mixed $model
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function resource($model)
    {
        return new $this->resourcePath($model);
    }

    /**
     * Create a resource collection instance for the Eloquent model.
     * 
     * @param mixed $model
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function resourceCollection($model)
    {
        return new $this->resourceCollectionPath($model);
    }
}