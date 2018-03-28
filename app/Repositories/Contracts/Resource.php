<?php

namespace App\Repositories\Contracts;

interface Resource 
{
    /**
     * Number of items per paging.
     * 
     * @return integer
     */
    public function itemsPerPage();
    
    /**
     * Get the path for the Eloquent model.
     * 
     * @return string
     */
    public function model();

    /**
     * Create a resource instance for the Eloquent model.
     * 
     * @param mixed
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function resource($model);

    /**
     * Create a resource collection instance for the Eloquent model.
     * 
     * @param mixed
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function resourceCollection($model);
}