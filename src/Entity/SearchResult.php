<?php

declare(strict_types=1);

namespace App\Entity;

class SearchResult
{
    private $searchTerm;
    private $countNumber;

    public function __construct(string $searchTerm, int $countNumber)
    {
        $this->searchTerm = $searchTerm;

        $this->countNumber = $countNumber;
    }

    public function searchTerm(): string
    {
        return $this->searchTerm;
    }

    public function countNumber(): int
    {
        return $this->countNumber;
    }
}
