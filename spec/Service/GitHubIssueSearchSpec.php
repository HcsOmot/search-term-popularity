<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTerm;
use App\Service\GitHubIssueSearch;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PhpSpec\ObjectBehavior;

class GitHubIssueSearchSpec extends ObjectBehavior
{
    private $gitHubIssueSearchEndpoint = 'https://api.github.com/search/issues?q=%s+type=issue';

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GitHubIssueSearch::class);
    }

    public function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
        $this->shouldImplement('App\Service\SearchProvider');
    }

    public function it_searches_for_a_term(SearchTerm $positiveSearchTerm, Client $client, Response $response, Stream $body): void
    {
        $contents = json_encode(['total_count' => 280]);

        $positiveSearchTerm->searchPhrase()->shouldBeCalled()->willReturn('php rocks');

        $positiveSearchTerm->searchTerm()->shouldBeCalled()->willReturn('php');

        $searchTerm = 'php rocks';

        $client->request('GET', sprintf($this->gitHubIssueSearchEndpoint, $searchTerm))
            ->shouldBeCalled()->willReturn($response);

        $response->getBody()->shouldBeCalled()->willReturn($body);

        $body->getContents()->shouldBeCalled()->willReturn($contents);

        $this->search($positiveSearchTerm)->shouldHaveType(SearchResult::class);
    }
}
