<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\NegativeSearchTerm;
use App\Entity\PositiveSearchTerm;
use App\Entity\SearchTermScore;

class Search
{
    /**
     * @var SearchProvider
     */
    private $searchProvider;
    /**
     * @var \App\Service\TermPopularityCalculator
     */
    private $termPopularityCalculator;

    public function __construct(SearchProvider $searchProvider, TermPopularityCalculator $termPopularityCalculator)
    {
        $this->searchProvider           = $searchProvider;
        $this->termPopularityCalculator = $termPopularityCalculator;
    }

    public function search(string $searchTerm): SearchTermScore
    {
        $positiveSearchTerm = new PositiveSearchTerm($searchTerm);

        $negativeSearchTerm = new NegativeSearchTerm($searchTerm);

        $positiveTermSearchResult = $this->searchProvider->search($positiveSearchTerm);

        $negativeTermSearchResult = $this->searchProvider->search($negativeSearchTerm);

        return $this->termPopularityCalculator->calculateTermPopularity($positiveTermSearchResult, $negativeTermSearchResult);
    }
}
