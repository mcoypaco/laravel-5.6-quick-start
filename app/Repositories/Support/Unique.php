<?php

namespace App\Repositories\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait Unique
{
    /**
     * Check in the specified resource exists in the storage.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function checkDuplicate(Request $request)
    {
        return response()->json(
            $this->checkDuplicateQuery($this->model(), $this->uniqueBy(), $request)->first() ? true : false
        );
    }

    /**
     * Builds the search query for the model.
     * 
     * @param string $class
     * @param array $columns
     * @return mixed
     */
    protected function checkDuplicateQuery(string $class, array $columns, Request $request)
    {   
        // Build the query with the parameters in the request.
        $query = $class::query()->where(function($query) use($columns, $request) {
            foreach ($columns as $column) {
                if($request->has($column)) $query->where($column, $request->$column);
            }
        });
        
        // Exclude the record by the id of the request.
        if($request->has('id')) $query->whereNotIn('id', [$request->id]);
        
        // Include deleted records if class has a deleted_at property.
        if (Schema::hasColumn((new $class)->getTable(), 'deleted_at')) $query->withTrashed();

        return $query;
    }
}
