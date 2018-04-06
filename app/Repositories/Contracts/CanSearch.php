<?php

namespace App\Repositories\Contracts;

interface CanSearch 
{
    /**
     * Column index for searching.
     * 
     * @return array
     */
    public function findBy();
}