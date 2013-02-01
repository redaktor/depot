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
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setConfig'), $args);
    }

    public function getConfig($key = false)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getConfig'), $args);
    }

    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setSslVerification'), $args);
    }

    public function getDefaultHeaders()
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getDefaultHeaders'), $args);
    }

    public function setDefaultHeaders($headers)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setDefaultHeaders'), $args);
    }

    public function setUriTemplate(UriTemplateInterface $uriTemplate)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setUriTemplate'), $args);
    }

    public function getUriTemplate()
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getUriTemplate'), $args);
    }

    public function expandTemplate($template, array $variables = null)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'expandTemplate'), $args);
    }

    public function createRequest($method = RequestInterface::GET, $uri = null, $headers = null, $body = null)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'createRequest'), $args);
    }

    public function getBaseUrl($expand = true)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getBaseUrl'), $args);
    }

    public function setBaseUrl($url)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setBaseUrl'), $args);
    }

    public function setUserAgent($userAgent, $includeDefault = false)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setUserAgent'), $args);
    }

    public function get($uri = null, $headers = null, $body = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('GET', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'get'), $args);
    }

    public function head($uri = null, $headers = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('HEAD', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'head'), $args);
    }

    public function delete($uri = null, $headers = null, $body = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('DELETE', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'delete'), $args);
    }

    public function put($uri = null, $headers = null, $body = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('PUT', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'put'), $args);
    }

    public function patch($uri = null, $headers = null, $body = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('PUT', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'patch'), $args);
    }

    public function post($uri = null, $headers = null, $postBody = null)
    {
        $args = func_get_args();

        $args[1] = $this->massageHeaders('POST', $uri, isset($args[1]) ? $args[1] : array());

        return call_user_func_array(array($this->httpClient, 'post'), $args);
    }

    public function options($uri = null)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'options'), $args);
    }

    public function send($requests)
    {
        $args = func_get_args();

        return $this->massageResponse(
            call_user_func_array(array($this->httpClient, 'send'), $args)
        );
    }

    public function setCurlMulti(CurlMultiInterface $curlMulti)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setCurlMulti'), $args);
    }

    public function getCurlMulti()
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getCurlMulti'), $args);
    }

    public function setRequestFactory(RequestFactoryInterface $factory)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setRequestFactory'), $args);
    }

    public static function getAllEvents()
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getAllEvents'), $args);
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'setEventDispatcher'), $args);
    }

    public function getEventDispatcher()
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'getEventDispatcher'), $args);
    }

    public function dispatch($eventName, array $context = array())
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'dispatch'), $args);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $args = func_get_args();

        return call_user_func_array(array($this->httpClient, 'addSubscriber'), $args);
    }
}
