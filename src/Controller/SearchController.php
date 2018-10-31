<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\SearchTermScoreRepository;
use App\Service\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class SearchController
{
    /**
     * @var Search
     */
    private $searchService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SearchTermScoreRepository
     */
    private $searchTermScoreRepository;

    public function __construct(
        Search $searchService,
        EntityManagerInterface $entityManager,
        SearchTermScoreRepository $searchTermScoreRepository
    ) {
        $this->searchService             = $searchService;
        $this->entityManager             = $entityManager;
        $this->searchTermScoreRepository = $searchTermScoreRepository;
    }

    /**
     * @param string              $searchTerm
     * @param SerializerInterface $serializer
     *
     * @return JsonResponse
     */
    public function search(string $searchTerm, SerializerInterface $serializer): JsonResponse
    {
        if ($searchTermScore = $this->searchTermScoreRepository->findOneBy(['term' => $searchTerm])) {
            return new JsonResponse(json_decode($serializer->serialize($searchTermScore, 'json', ['groups' => ['data']])));
        }

        $searchTermScore = $this->searchService->search($searchTerm);

        $this->entityManager->persist($searchTermScore);
        $this->entityManager->flush();

        return new JsonResponse(json_decode($serializer->serialize($searchTermScore, 'json', [])));
    }
}
