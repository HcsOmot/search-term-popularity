<?php

declare(strict_types=1);

namespace spec\App\Entity;

use App\Entity\SearchTermScore;
use PhpSpec\ObjectBehavior;

class SearchTermScoreSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SearchTermScore::class);
    }

    public function let(): void
    {
        $termValue = 'php';
        $termScore = 3.31;
        $this->beConstructedWith($termValue, $termScore);
    }

    public function it_has_value(): void
    {
        $this->getTerm()->shouldReturn('php');
    }

    public function it_has_score(): void
    {
        $this->getScore()->shouldReturn(3.31);
    }
}
