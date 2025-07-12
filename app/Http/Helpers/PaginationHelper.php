<?php
namespace App\Http\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginationHelper
{
     public static function format(LengthAwarePaginator $paginator, $resourceClass = null)
    {
        $items = $paginator->items();

        if ($resourceClass) {
            $items = $resourceClass::collection($items);
        }

        return [
            'data' => $items,
            'current_page' => $paginator->currentPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'next_page' => $paginator->nextPageUrl(),
            'prev_page' => $paginator->previousPageUrl(),
        ];
    }
}