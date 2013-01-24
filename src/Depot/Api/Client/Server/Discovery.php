<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Core\Domain\Model\Entity\Entity;
use Depot\Core\Domain\Model\Entity\Profile;
use Depot\Core\Domain\Model\Entity\ProfileType;
use Depot\Core\Domain\Model\Server\Server;
use Symfony\Component\DomCrawler\Crawler;

class Discovery
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
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
                    $response = $this->httpClient->get($profileUri);
                } catch (\Exception $e) {
                    // Ignore this (for now; might simply be down)
                    continue;
                }

                $json = json_decode($response->body(), true);

                if ( ! isset($json['https://tent.io/types/info/core/v0.1.0']['entity'])) {
                    // Ignore this (for now; try the next profile)
                    continue;
                }

                if ( ! isset($json['https://tent.io/types/info/core/v0.1.0']['servers'])) {
                    // Ignore this (for now; try the next profile)
                    continue;
                }

                $profile = new Profile;
                foreach ($json as $type => $content) {
                    $profile->set(new ProfileType($type, $content));
                }

                $entity = new Entity(
                    $json['https://tent.io/types/info/core/v0.1.0']['entity'],
                    $profile
                );

                return new Server($entity);
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
            $response = $this->httpClient->head($uri);
        } catch (\Exception $e) {
            throw new \RuntimeException("Entity could not be found", 0, $e);
        }

        $profileUris = array();

        if (!$links = $response->header('Link')) {
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
            $response = $this->httpClient->get($uri);
        } catch (\Exception $e) {
            throw new \RuntimeException("Entity could not be found", 0, $e);
        }

        $crawler = new Crawler;
        $crawler->addContent($response->body());

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
