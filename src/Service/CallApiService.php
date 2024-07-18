<?php
/**
 * CallApiService.php
 *
 * This file defines the CallApiService class, responsible for making API calls to fetch data.
 * It abstracts the logic for interacting with external APIs, allowing other parts of the application
 * to retrieve data without needing to know the specifics of the API endpoints or handling HTTP requests.
 *
 * @category Services
 * @package  App\Service
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/http_client.html
 * @since    PHP 8.2
 */

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * CallApiServiceController
 *
 * @category Service
 *
 * @package App\Service\CallApiService
 *
 * @author Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/http_client.html
 */
class CallApiService
{
    /**
     * Constructor to inject the HttpClientInterface.
     *
     * @param HttpClientInterface $client The HTTP client to make API requests.
     */
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * Fetches US data from the API.
     *
     * @return array The fetched data as an associative array.
     */
    public function getUsaData(): array
    {
        return $this->getApi('us');
    }

    /**
     * Fetches all states data from the API.
     *
     * @return array The fetched data as an associative array.
     */
    public function getAllData(): array
    {
        return $this->getApi('states');
    }

    /**
     * Fetches data for a specific department from the API.
     *
     * @param string $department The department identifier.
     * @return array The fetched data as an associative array.
     */
    public function getDepartmentData($department): array
    {
        return $this->getApi('states/' . $department);
    }

    /**
     * Fetches data for a specific state and date from the COVID Tracking API.
     *
     * @param string $state The state abbreviation.
     * @param string $date The date in YYYY-MM-DD format.
     * @return array The fetched data as an associative array.
     */

    public function getAllDataByDate($state, $date): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.covidtracking.com/v1/states/'
            . $state . '/' . $date . '.json'
        );
        return $response->toArray();
    }

    /**
     * Internal method to perform GET requests to the API.
     *
     * @param string $var The endpoint path segment.
     * @return array The fetched data as an associative array.
     */
    private function getApi(string $var)
    {
        $response = $this->client->request(
            'GET',
            'https://api.covidtracking.com/v1/' . $var . '/daily.json'
        );
        return $response->toArray();
    }
}