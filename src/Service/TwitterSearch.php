<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTerm;

class TwitterSearch implements SearchProvider
{
    public function search(SearchTerm $searchTerm): SearchResult
    {
        return new SearchResult($searchTerm->searchTerm(), rand(50, 500));
    }
}
