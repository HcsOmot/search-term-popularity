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

    public function setUp(): void
    {
        $this->positiveTermSearchResult = new SearchResult('php', 787);
        $this->negativeTermSearchResult = new SearchResult('php', 1819);
    }

    public function testCalculateTermPopularity()
    {
        $popularityCalculator = new TermPopularityCalculator();
        $popularity           = $popularityCalculator->calculateTermPopularity($this->positiveTermSearchResult,
            $this->negativeTermSearchResult);

        $this->assertEquals(3.31, $popularity->getScore());
    }
}
