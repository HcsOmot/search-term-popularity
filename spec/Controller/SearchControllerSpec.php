<?php

declare(strict_types=1);

namespace spec\App\Controller;

use App\Controller\SearchController;
use App\Entity\SearchTermScore;
use App\Repository\SearchTermScoreRepository;
use App\Service\Search;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class SearchControllerSpec extends ObjectBehavior
{
    private $searchTerm = 'php';

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SearchController::class);
    }

    public function let(Search $searchService,
        EntityManagerInterface $entityManager,
        SearchTermScoreRepository $searchTermScoreRepository)
    {
        $this->beConstructedWith($searchService, $entityManager, $searchTermScoreRepository);
    }

    public function it_performs_a_local_search_for_search_term(SearchTermScoreRepository $searchTermScoreRepository, SearchTermScore $searchTermScore, SerializerInterface $serializer)
    {
        $serializedData = json_encode(['term' => 'php', 'score' => 3.31]);
        $searchTermScoreRepository->findOneBy(['term' => $this->searchTerm])->shouldBeCalled()->willReturn($searchTermScore);
        $serializer->serialize($searchTermScore, 'json')->shouldBeCalled()->willReturn($serializedData);
//        $searchService->search($this->searchTerm)->shouldBeCalled()->willReturn($searchTermScore);
        $this->search('php', $serializer)->shouldHaveType(JsonResponse::class);
    }

    public function it_performs_api_search_for_search_term(Search $searchService, SearchTermScoreRepository $searchTermScoreRepository, EntityManagerInterface $entityManager, SearchTermScore $searchTermScore, SerializerInterface $serializer)
    {
        $serializedData = json_encode(['term' => 'php', 'score' => 3.31]);
        $searchTermScoreRepository->findOneBy(['term' => $this->searchTerm])->shouldBeCalled()->willReturn(null);
        $serializer->serialize($searchTermScore, 'json')->shouldBeCalled()->willReturn($serializedData);
        $searchService->search($this->searchTerm)->shouldBeCalled()->willReturn($searchTermScore);
        $entityManager->persist($searchTermScore)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->search('php', $serializer)->shouldHaveType(JsonResponse::class);
    }
}
