<?php

declare(strict_types=1);

namespace spec\App\Entity;

use App\Entity\PositiveSearchTerm;
use PhpSpec\ObjectBehavior;

class PositiveSearchTermSpec extends ObjectBehavior
{
    private $sentiment  = 'rocks';
    private $searchTerm = 'php';

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PositiveSearchTerm::class);
        $this->shouldImplement('App\Entity\SearchTerm');
    }

    public function let()
    {
        $this->beConstructedWith($this->searchTerm);
    }

    public function it_constructs_a_search_phrase()
    {
        $this->searchPhrase()->shouldReturn(sprintf('%s %s', $this->searchTerm, $this->sentiment));
    }

    public function it_retains_the_search_term()
    {
        $this->searchTerm()->shouldReturn($this->searchTerm);
    }
}
