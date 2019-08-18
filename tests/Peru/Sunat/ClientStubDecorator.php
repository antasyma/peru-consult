<?php

namespace Tests\Peru\Sunat;

use Peru\Http\ClientInterface;

/**
 * Class ClientStubDecorator.
 *
 * Override base url with mock url.
 */
class ClientStubDecorator implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * ClientStubDecorator constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get Request.
     *
     * @param string $url
     * @param array  $headers
     *
     * @return string|false
     */
    public function get(string $url, array $headers = [])
    {
        return $this->client->get($this->getNewUrl($url), $headers);
    }

    /**
     * Post Request.
     *
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return string|false
     */
    public function post(string $url, $data, array $headers = [])
    {
        return $this->client->post($this->getNewUrl($url), $data, $headers);
    }

    private function getNewUrl($url)
    {
        $urlBase = getenv('MOCK_URL');
        $u = parse_url($url);

        return $urlBase.$u['path'].(isset($u['query']) ? "?$u[query]" : '');
    }
}
