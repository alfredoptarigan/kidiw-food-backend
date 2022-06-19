<?php

namespace App\Traits;

trait HasScope
{
    public function scopePerPage($query, $perPage)
    {
        if ($perPage == "all") {
            $perPage = $query->count();
        }

        return $perPage;
    }
}
