<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Entity\NegativeSearchTerm;
use App\Entity\PositiveSearchTerm;
use App\Entity\SearchResult;
use App\Entity\SearchTermScore;
use App\Service\Search;
use App\Service\SearchProvider;
use App\Service\TermPopularityCalculator;
use PhpSpec\ObjectBehavior;

class SearchSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Search::class);
    }

    public function let(SearchProvider $gitHubIssueSearch, TermPopularityCalculator $termPopularityCalculator): void
    {
        $this->beConstructedWith($gitHubIssueSearch, $termPopularityCalculator);
    }

    public function it_searches_for_a_term(
        SearchTermScore $searchTermScore,
        SearchResult $positiveTermSearchResult,
        SearchResult $negativeTermSearchResult,
        TermPopularityCalculator $termPopularityCalculator,
        SearchProvider $gitHubIssueSearch
    ) {
        $searchTerm = 'php';

        $positiveSearchTerm = new PositiveSearchTerm('php');

        $negativeSearchTerm = new NegativeSearchTerm('php');

        $gitHubIssueSearch->search($positiveSearchTerm)->shouldBeCalled()->willReturn($positiveTermSearchResult);

        $gitHubIssueSearch->search($negativeSearchTerm)->shouldBeCalled()->willReturn($negativeTermSearchResult);

        $termPopularityCalculator->calculateTermPopularity($positiveTermSearchResult, $negativeTermSearchResult)
            ->shouldBeCalled()->willReturn($searchTermScore);

        $this->search($searchTerm);
    }
}
