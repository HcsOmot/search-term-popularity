<?php

declare(strict_types=1);

namespace App\Entity;

class PositiveSearchTerm implements SearchTerm
{
    private const SENTIMENT = 'rocks';

    private $searchTerm;
    private $searchPhrase;

    public function __construct(string $searchTerm)
    {
        $this->searchTerm   = $searchTerm;
        $this->searchPhrase = sprintf('%s %s', $searchTerm, self::SENTIMENT);
    }

    public function searchTerm(): string
    {
        return $this->searchTerm;
    }

    public function searchPhrase(): string
    {
        return $this->searchPhrase;
    }
}
