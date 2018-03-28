<?php

namespace App\Repositories\Contracts;

interface MustBeUnique {
    
    /**
     * Columns that should be unique in the storage.
     * 
     * @return array
     */
    public function uniqueBy();
}