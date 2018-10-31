<?php

declare(strict_types=1);

namespace App\Entity;

interface SearchTerm
{
    public function searchTerm(): string;

    public function searchPhrase(): string;
}
