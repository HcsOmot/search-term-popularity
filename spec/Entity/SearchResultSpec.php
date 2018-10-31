<?php

declare(strict_types=1);

namespace spec\App\Entity;

use App\Entity\SearchResult;
use PhpSpec\ObjectBehavior;

class SearchResultSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SearchResult::class);
    }

    public function let(): void
    {
        $searchTerm  = 'php sucks';
        $countNumber = 1819;
        $this->beConstructedWith($searchTerm, $countNumber);
    }

    public function it_has_search_term(): void
    {
        $this->searchTerm()->shouldReturn('php sucks');
    }

    public function it_has_a_count_value(): void
    {
        $this->countNumber()->shouldReturn(1819);
    }
}
