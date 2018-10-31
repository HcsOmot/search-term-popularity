<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTermScore;
use App\Service\TermPopularityCalculator;
use PhpSpec\ObjectBehavior;

class TermPopularityCalculatorSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TermPopularityCalculator::class);
    }

    public function it_compares_only_same_term_search_results(
        SearchResult $positiveTermSearchResult,
        SearchResult $negativeTermSearchResult
    ): void {
        $positiveTermSearchResult->searchTerm()->shouldBeCalled()->willReturn('python');
        $negativeTermSearchResult->searchTerm()->shouldBeCalled()->willReturn('php');

        $this->shouldThrow(\DomainException::class)->during('calculateTermPopularity', [
            $positiveTermSearchResult,
            $negativeTermSearchResult,
        ]);
    }

    public function it_calculates_term_popularity(
        SearchResult $positiveTermSearchResult,
        SearchResult $negativeTermSearchResult
    ): void {
        $positiveTermSearchResult->searchTerm()->shouldBeCalled()->willReturn('php');
        $negativeTermSearchResult->searchTerm()->shouldBeCalled()->willReturn('php');

        $positiveTermSearchResult->countNumber()->shouldBeCalled()->willReturn(787);

        $negativeTermSearchResult->countNumber()->shouldBeCalled()->willReturn(1819);

        self::calculateTermPopularity($positiveTermSearchResult, $negativeTermSearchResult)
            ->shouldHaveType(SearchTermScore::class);
    }
}
