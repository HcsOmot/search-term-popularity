<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchTermScoreRepository")
 */
class SearchTermScore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @var string
     */
    private $term;

    /**
     * @ORM\Column(type="float", scale=2, nullable=false)
     *
     * @var float
     */
    private $score;

    public function __construct(string $value, float $score)
    {
        $this->term  = $value;
        $this->score = $score;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}
