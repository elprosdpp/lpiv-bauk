<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

///**
// * @method pageName()
// */
class CustomLengthAwarePaginator extends LengthAwarePaginator
{
    public function url($page): string
    {
        return Request::fullUrlWithQuery([
            'page' => $page,
        ]);
    }


    public function toInertiaArray(): array
    {
        $currentPage = $this->currentPage();
        $lastPage = $this->lastPage();
        $perPage = 10;

        $baseUrl = Str::before(Request::url(), '?');

        $links = [];

        for ($page = 1; $page <= $lastPage; $page++) {
            $links[$page] = [
                'url' => $baseUrl . '?' . 'page' . '=' . $page,
                'label' => $page,
                'active' => $currentPage != $page ? 'false' : 'true'

            ];
        }

        return [
            'data' => $this->items->toArray(),
            'links' => $links,
//            'meta' => [
            'current_page' => $currentPage,
            'from' => $this->firstItem(),
            'last_page' => $lastPage,
            'path' => $baseUrl,
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
//            ],
        ];
    }
}
