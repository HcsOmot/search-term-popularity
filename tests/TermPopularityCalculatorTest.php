<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\SearchResult;
use App\Service\TermPopularityCalculator;
use PHPUnit\Framework\TestCase;

class TermPopularityCalculatorTest extends TestCase
{
    private $positiveTermSearchResult;
    private $negativeTermSearchResult;
    private $notFoundTermSearchResult;

    public function setUp(): void
    {
        $this->positiveTermSearchResult = new SearchResult('php', 787);
        $this->negativeTermSearchResult = new SearchResult('php', 1819);
        $this->notFoundTermSearchResult = new SearchResult('php', 0);
    }

    public function testCalculateTermPopularity()
    {
        $popularityCalculator = new TermPopularityCalculator();
        $popularity           = $popularityCalculator->calculateTermPopularity($this->positiveTermSearchResult,
            $this->negativeTermSearchResult);

        $this->assertEquals(3.31, $popularity->getScore());
    }

    public function testCanDeclareTermPopularityAsZeroIfTermNotFound()
    {
        $popularityCalculator = new TermPopularityCalculator();
        $popularity           = $popularityCalculator->calculateTermPopularity($this->notFoundTermSearchResult,
            $this->notFoundTermSearchResult);

        $this->assertEquals(0, $popularity->getScore());
    }
}
