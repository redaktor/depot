<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\TentHttpClient;
use Depot\Core\Model;
use Depot\Core\Service\Serializer\SerializerInterface;
use Symfony\Component\DomCrawler\Crawler;

class Discovery
{
    protected $serializer;
    protected $httpClient;
    protected $tentHttpClient;

    public function __construct(SerializerInterface $serializer, HttpClientInterface $httpClient)
    {
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
        $this->tentHttpClient = new TentHttpClient($httpClient);
    }

    public function discover($uri)
    {
        $profileUris = $this->discoverProfileUrisFromHeaders($uri);

        if (!$profileUris) {
            $profileUris = $this->discoverProfileUrisFromHtml($uri);
        }

        if (!$profileUris) {
            throw new \RuntimeException("Entity could not be found", 0);
        }

        foreach ($profileUris as $profileUri) {
            try {
                try {
                    $response = $this->tentHttpClient->get($profileUri)->send();
                } catch (\Exception $e) {
                    // Ignore this (for now; might simply be down)
                    continue;
                }

                $entity = $this->serializer->deserialize(
                    $response->getBody(),
                    'Depot\Core\Model\Entity\EntityInterface'
                );

                return new Model\Server\EntityServer($entity);
            } catch (\Exception $e) {
                // Ignore this (for now; we want to try all profiles)
                continue;
            }
        }

        throw new \RuntimeException("Entity could not be found", 0);
    }

    protected function discoverProfileUrisFromHeaders($uri)
    {
        try {
            $response = $this->httpClient->head($uri)->send();
        } catch (\Exception $e) {
            throw new \RuntimeException("Entity could not be found", 0, $e);
        }

        $profileUris = array();

        if (!$links = $response->getHeader('Link')) {
            return null;
        }

        foreach ($links as $link) {
            if (preg_match('(<([^>]+)>;\s+rel="https://tent.io/rels/profile")', $link, $match)) {
                $profileUris[] = $this->normalizeUrl($match[1], $uri);
            }
        }

        return $profileUris;
    }

    protected function discoverProfileUrisFromHtml($uri)
    {
        try {
            $response = $this->httpClient->get($uri)->send();
        } catch (\Exception $e) {
            throw new \RuntimeException("Entity could not be found", 0, $e);
        }

        $crawler = new Crawler;
        $crawler->addContent($response->getBody());

        $profileUris = array();
        foreach ($crawler->filter('link[rel="https://tent.io/rels/profile"]') as $link) {
            $profileUris[] = $link->getAttribute('href');
        }

        return $profileUris;
    }

    /**
     * Given a url and the parent resource url that contains that first url,
     * make sure the url is normalized to an absolute url.
     *
     * Originally from Tent PHP Client (c) Benjamin Eberlei
     *
     * @param string $url
     * @param string $parentUrl
     *
     * @return string
     */
    private function normalizeUrl($url, $parentUrl)
    {
        if (strpos($url, "http") === false) {
            if (substr($url, 0, 1) !== "/") {
                return $parentUrl . $url;
            }

            $parts = parse_url($parentUrl);
            $port  = isset($parts['port']) ? ":" . $parts['port'] : "";
            $url   = $parts['scheme'] . "://" . $parts['host'] . $port . $url;
        }

        return $url;
    }
}
