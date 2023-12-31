<?php

namespace App\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;

final class PaginatorService
{
    public function paginate($query) : array
    {
        $paginator = new Paginator($query);
        $result['data'] = $paginator->getIterator();
        $result['dataAsArray'] = $result['data']->getArrayCopy(); 
        $result['total'] = $paginator->count();
        
        return $result;
    }
}