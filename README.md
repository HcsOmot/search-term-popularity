#Search Term Popularity Calculator

##Description

Calculate relative popularity of a search term based on overly simplified approach of positive and negative term sentiments.

A `Sentiment` is a fixed word - `sucks` and `rocks`, which represents either something bad or good.

###Search Algorithm
A sentiment's value is appended to the search term to form a `search phrase`, e.g. `php sucks` or `php rocks`.


This phrase is then used to perform a search over a search provider.

The search result for a phrase represents the number of found documents.

The `TermPopularityService` calculates the relative popularity of the search term by comparing the amount of positive sentiment search results with the combined number of positive and negative sentiment search results.

###Search Providers
Currently there are two - GitHub's Issue search and a fake Twitter search (always returns a fake, fixed value).
The `GitHubIssueSearch` search provider connects to GH API and performs a search for a given term.
It depends on `GuzzleHttp` for making http requests.

You can implement your own search providers, as long as they make use of `SearchProvider` interface.

###Search Service
This is the central search of the application. It receives a string representation of a search term, and it handles the positive and negative sentiment search, returning a `SearchTermScore` object.

###SearchTermScore
Object representing the popularity of the search term for the search provider.


##Project setup
1. Clone the repo
2. Run composer install
3. Start built-in Php Server (php -S 127.0.0.1:8000 -t public)

###Usage
1. Perform a search request at `localhost:8000/search/_{search term}_
_Note:_ the search term is mandatory. If omitted, the search service will throw an exception

###Config
Current setup uses a concrete `GitHubIssueSearch` search provider. You can swap it out for another implementation and set up the config for autowiring.

###Tests
Almost all test were written using `PhpSpec`. You can run the tests by issuing the following command:
`composer run-script run-tests`

###Code Style
To automatically fix the code style, run the following command:
`composer run-script fix-cs`

###Static Analysis
To run static analysis using PhpStan, run the following command:
`composer run-script analyze-code`