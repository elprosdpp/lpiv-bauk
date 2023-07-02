<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\CustomLengthAwarePaginator;

trait PaginatableAndSearchableTrait
{
    public function paginateAndSearch($collection, $perPage, $page, $searchQuery, $searchableColumns): array
    {
        // Proses pencarian
        if (!empty($searchQuery)) {
            $collection = array_filter($collection, function ($item) use ($searchQuery, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    if (stripos($item[$column], $searchQuery) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }

        $offset = ($page - 1) * $perPage;
        $items = array_slice($collection, $offset, $perPage);
        $collectCount = count($collection);


        $customPaginator = new CustomLengthAwarePaginator(
            $items,
            $collectCount,
            $perPage,
            $page
        );

        return $customPaginator->toInertiaArray();
    }
}


