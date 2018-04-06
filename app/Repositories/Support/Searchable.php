<?php

namespace App\Repositories\Support;

use Illuminate\Http\Request;

trait Searchable
{
    /**
     * Search for a specific resource in the database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function search(Request $request)
    {
        return $this->resourceCollection(
            $this->searchQuery($this->model(), $this->findBy(), $request)->paginate($this->itemsPerPage())
        );
    }

    /**
     * Stictly search for a specific resource in the database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function searchStrict(Request $request)
    {
        return $this->resourceCollection(
            $this->searchStrictQuery($this->model(), $this->findBy(), $request)->paginate($this->itemsPerPage())
        );
    }

    /**
     * Builds the search strict query for the model.
     * 
     * @param string $class
     * @param array $columns
     * @return mixed
     */
    protected function searchStrictQuery(string $class, array $columns, Request $request)
    {
        return $class::query()->where(function($query) use($columns, $request) {
            foreach ($columns as $column) {
                if($request->has($column)) $query->where($column, 'like', $request->$column.'%');
            }
        }); 
    }

    /**
     * Builds the search query for the model.
     * 
     * @param string $class
     * @param array $columns
     * @return mixed
     */
    protected function searchQuery(string $class, array $columns, Request $request)
    {
        return $class::query()->where(function($query) use($columns, $request) {
            foreach ($columns as $column) {
                if($request->has($column)) $query->orWhere($column, 'like', $request->$column.'%');
            }
        }); 
    }
}