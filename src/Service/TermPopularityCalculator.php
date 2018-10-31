<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTermScore;

class TermPopularityCalculator
{
    public function calculateTermPopularity(SearchResult $positiveTermSearchResult,
        SearchResult $negativeTermSearchResult): SearchTermScore
    {
        $this->preventSearchTermMismatch($positiveTermSearchResult, $negativeTermSearchResult);

        $totalResultsCount = $positiveTermSearchResult->countNumber() + $negativeTermSearchResult->countNumber();

        $popularity = round($totalResultsCount / $positiveTermSearchResult->countNumber(), 2);

        return new SearchTermScore($positiveTermSearchResult->searchTerm(), $popularity);
    }

    private function preventSearchTermMismatch(
        SearchResult $positiveTermSearchResult,
        SearchResult $negativeTermSearchResult
    ) {
        if ($positiveTermSearchResult->searchTerm() !== $negativeTermSearchResult->searchTerm()) {
            throw new \DomainException('Search Terms don\'t match.');
        }

        return true;
    }
}
