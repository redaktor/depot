<?php

namespace Depot\Api\Client\HttpClient;

use Guzzle\Common\Collection;
use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Http\Curl\CurlMultiInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Message\RequestFactoryInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Guzzle\Parser\UriTemplate\UriTemplateInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractHttpClientDecorator implements HttpClientInterface
{
    protected $httpClient;

    protected function massageHeaders($method, $uri, $headers = null)
    {
        return $headers;
    }

    protected function massageResponse(Response $response)
    {
        return $response;
    }

    public function setConfig($config)
    {
        return $this->httpClient->setConfig($config);
    }

    public function getConfig($key = false)
    {
        return $this->httpClient->getConfig($key);
    }

    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2)
    {
        return $this->httpClient->setSslVerification($certificateAuthority, $verifyPeer, $verifyHost);
    }

    public function getDefaultHeaders()
    {
        return $this->httpClient->getDefaultHeaders();
    }

    public function setDefaultHeaders($headers)
    {
        return $this->httpClient->setDefaultHeaders($headers);
    }

    public function setUriTemplate(UriTemplateInterface $uriTemplate)
    {
        return $this->httpClient->setUriTemplate($uriTemplate);
    }

    public function getUriTemplate()
    {
        return $this->httpClient->getUriTemplate();
    }

    public function expandTemplate($template, array $variables = null)
    {
        return $this->httpClient->expandTemplate($template, $variables);
    }

    public function createRequest($method = RequestInterface::GET, $uri = null, $headers = null, $body = null)
    {
        return $this->httpClient->createRequest($method, $uri, $headers, $body);
    }

    public function getBaseUrl($expand = true)
    {
        return $this->httpClient->getBaseUrl($expand);
    }

    public function setBaseUrl($url)
    {
        return $this->httpClient->setBaseUrl($url);
    }

    public function setUserAgent($userAgent, $includeDefault = false)
    {
        return $this->httpClient->setUserAgent($userAgent, $includeDefault);
    }

    public function get($uri = null, $headers = null, $body = null)
    {
        return $this->httpClient->get(
            $uri,
            $this->massageHeaders('GET', $uri, $headers),
            $body
        );
    }

    public function head($uri = null, $headers = null)
    {
        return $this->httpClient->head(
            $uri,
            $this->massageHeaders('HEAD', $uri, $headers)
        );
    }

    public function delete($uri = null, $headers = null, $body = null)
    {
        return $this->httpClient->delete(
            $uri,
            $this->massageHeaders('DELETE', $uri, $headers),
            $body
        );
    }

    public function put($uri = null, $headers = null, $body = null)
    {
        return $this->httpClient->put(
            $uri,
            $this->massageHeaders('PUT', $uri, $headers),
            $body
        );
    }

    public function patch($uri = null, $headers = null, $body = null)
    {
        return $this->httpClient->patch(
            $uri,
            $this->massageHeaders('PATCH', $uri, $headers),
            $body
        );
    }

    public function post($uri = null, $headers = null, $postBody = null)
    {
        return $this->httpClient->post(
            $uri,
            $this->massageHeaders('POST', $uri, $headers),
            $postBody
        );
    }

    public function options($uri = null)
    {
        return $this->httpClient->options($uri);
    }

    public function send($requests)
    {
        return $this->massageResponse(
            $this->httpClient->send($requests)
        );
    }

    public function setCurlMulti(CurlMultiInterface $curlMulti)
    {
        return $this->httpClient->setCurlMulti($curlMulti);
    }

    public function getCurlMulti()
    {
        return $this->httpClient->getCurlMulti();
    }

    public function setRequestFactory(RequestFactoryInterface $factory)
    {
        return $this->httpClient->setRequestFactory($factory);
    }

    public static function getAllEvents()
    {
        return $this->httpClient->getAllEvents();
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        return $this->httpClient->setEventDispatcher($eventDispatcher);
    }

    public function getEventDispatcher()
    {
        return $this->httpClient->getEventDispatcher();
    }

    public function dispatch($eventName, array $context = array())
    {
        return $this->httpClient->dispatch($eventName, $context);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->httpClient->addSubscriber($subscriber);
    }
}
