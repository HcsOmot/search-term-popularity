<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SearchResult;
use App\Entity\SearchTerm;
use GuzzleHttp\ClientInterface;

class GitHubIssueSearch implements SearchProvider
{
    private const GITHUB_API_URL = 'https://api.github.com';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;
    /**
     * @var SearchTerm
     */
    private $searchTerm;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function search(SearchTerm $searchTerm): SearchResult
    {
        $this->searchTerm = $searchTerm;

        $issueSearchUrl = $this->buildIssueSearchUrl($searchTerm->searchPhrase());

        $response = $this->client->request('GET', $issueSearchUrl);

        return $this->buildSearchResult($response->getBody()->getContents());
    }

    private function buildIssueSearchUrl(string $searchPhrase): string
    {
        return sprintf('%s/search/issues?q=%s+type=issue', self::GITHUB_API_URL, $searchPhrase);
    }

    private function buildSearchResult(string $responseContents): SearchResult
    {
        $resultArray = json_decode($responseContents, true);

        return new SearchResult($this->searchTerm->searchTerm(), $resultArray['total_count']);
    }
}
