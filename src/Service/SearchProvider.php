<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTerm;

interface SearchProvider
{
    public function search(SearchTerm $searchTerm): SearchResult;
}
