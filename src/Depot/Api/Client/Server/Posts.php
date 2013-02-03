<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\TentHttpClient;
use Depot\Core\Model;
use Depot\Core\Service\Random\RandomInterface;

class Posts
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->tentHttpClient = new TentHttpClient($httpClient);
    }

    public function getPosts(Model\Server\ServerInterface $server, Model\Post\PostCriteria $postCriteria = null)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getPostsInternal'), array($postCriteria));
    }

    public function getPost(Model\Server\ServerInterface $server, $id, $version = null)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getPostInternal'), array($id, $version));
    }

    public function getEntityPost(Model\Server\ServerInterface $server, $entityUri, $id, $version = null)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getEntityPostInternal'), array($entityUri, $id, $version));
    }

    public function getPostsInternal(Model\Server\ServerInterface $server, $apiRoot, Model\Post\PostCriteria $postCriteria = null)
    {
        $requestParams = array();

        if (null !== $postCriteria) {
            if ($postCriteria->beforeId && $postCriteria->beforeIdEntity) {
                $requestParams['before_id'] = $postCriteria->beforeId;
                $requestParams['before_id_entity'] = $postCriteria->beforeIdEntity;
            }

            if ($postCriteria->sinceId && $postCriteria->sinceIdEntity) {
                $requestParams['since_id'] = $postCriteria->sinceId;
                $requestParams['since_id_entity'] = $postCriteria->sinceIdEntity;
            }

            if ($postCriteria->untilId && $postCriteria->untilIdEntity) {
                $requestParams['until_id'] = $postCriteria->untilId;
                $requestParams['until_id_entity'] = $postCriteria->untilIdEntity;
            }

            if ($postCriteria->sinceTime) {
                $requestParams['since_time'] = $postCriteria->sinceTime;
            }

            if ($postCriteria->beforeTime) {
                $requestParams['before_time'] = $postCriteria->beforeTime;
            }

            if ($postCriteria->sortBy) {
                $requestParams['sort_by'] = $postCriteria->sortBy;
            }

            if ($postCriteria->entity) {
                $requestParams['entity'] = $postCriteria->entity;
            }

            if ($postCriteria->mentionedEntity) {
                $requestParams['mentioned_entity'] = $postCriteria->mentionedEntity;
            }

            if ($postCriteria->postTypes) {
                $requestParams['post_types'] = is_array($postCriteria->postTypes)
                    ? implode(',', $postCriteria->postTypes)
                    : $postCriteria->postTypes;
            }

            if ($postCriteria->limit) {
                $requestParams['limit'] = $postCriteria->limit;
            }
        }

        $requestQuery = count($requestParams)
            ? '?'.http_build_query($requestParams)
            : '';

        $response = $this->tentHttpClient->get($apiRoot.'/posts'.$requestQuery)->send();
        $nextCriteria = null;
        $previousCriteria = null;

        $links = $response->hasHeader('link')
            ? $response->getHeader('link')
            : array();

        foreach ($links as $link) {

            if (preg_match('/<.+\?(.+?)>; rel="(prev|next)"/', $link, $matches)) {
                list ($fullMatch, $urlParams, $relationship) = $matches;

                parse_str($urlParams, $parsed);

                $postCriteria = new Model\Post\PostCriteria;

                if (isset($parsed['before_id']) && isset($parsed['before_id_entity'])) {
                    $postCriteria->beforeId = $parsed['before_id'];
                    $postCriteria->beforeIdEntity = $parsed['before_id_entity'];
                }

                if (isset($parsed['since_id']) && isset($parsed['since_id_entity'])) {
                    $postCriteria->sinceId = $parsed['since_id'];
                    $postCriteria->sinceIdEntity = $parsed['since_id_entity'];
                }

                if (isset($parsed['until_id']) && isset($parsed['until_id_entity'])) {
                    $postCriteria->untilId = $parsed['until_id'];
                    $postCriteria->untilIdEntity = $parsed['until_id_entity'];
                }

                if (isset($parsed['since_time'])) {
                    $postCriteria->sinceTime = $parsed['since_time'];
                }

                if (isset($parsed['before_time'])) {
                    $postCriteria->beforeTime = $parsed['before_time'];
                }

                if (isset($parsed['sort_by'])) {
                    $postCriteria->sortBy = $parsed['sort_by'];
                }

                if (isset($parsed['entity'])) {
                    $postCriteria->sortBy = $parsed['entity'];
                }

                if (isset($parsed['mentioned_entity'])) {
                    $postCriteria->mentionedEntity = $parsed['mentioned_entity'];
                }

                if (isset($parsed['post_types'])) {
                    if (0 === strpos($parsed['post_types'], '[')) {
                        $postCriteria->postTypes = json_decode($parsed['post_types'], true);
                    } else {
                        $postCriteria->postTypes = explode(',', $parsed['post_types']);
                    }
                }

                if (isset($parsed['limit'])) {
                    $postCriteria->limit = $parsed['limit'];
                }

                switch($relationship) {
                    case 'prev':
                        $previousCriteria = $postCriteria;
                        break;
                    case 'next':
                        $nextCriteria = $postCriteria;
                        break;
                }
            }
        }

        $json = json_decode($response->getBody(), true);

        $posts = array();

        foreach ($json as $postJson) {
            $posts[] = new Model\Post\Post(
                $postJson['entity'],
                $postJson['id'],
                $postJson['type'],
                $postJson['licenses'],
                $postJson['permissions'],
                $postJson['content'],
                $postJson['published_at'],
                $postJson['version'],
                $postJson['app'],
                $postJson['mentions'],
                isset($postJson['updated_at']) ? $postJson['updated_at'] : null,
                isset($postJson['received_at']) ? $postJson['received_at'] : null
            );
        }

        $postListResponse = new Model\Post\PostListResponse($posts);

        if ($previousCriteria) {
            $postListResponse->setPreviousCriteria($previousCriteria);
        }

        if ($nextCriteria) {
            $postListResponse->setNextCriteria($nextCriteria);
        }

        return $postListResponse;
    }

    public function getPostInternal(Model\Server\ServerInterface $server, $apiRoot, $id, $version = null)
    {
        $requestParams = array();

        if (null !== $version) {
            $requestParams['version'] = $version;
        }

        $requestQuery = count($requestParams)
            ? '?'.http_build_query($requestParams)
            : '';

        $requestUri = $apiRoot.'/posts/'.$id.$requestQuery;
        $response = $this->tentHttpClient->get($requestUri)->send();

        $postJson = json_decode($response->getBody(), true);

        return new Model\Post\Post(
            $postJson['entity'],
            $postJson['id'],
            $postJson['type'],
            $postJson['licenses'],
            $postJson['permissions'],
            $postJson['content'],
            $postJson['published_at'],
            $postJson['version'],
            $postJson['app'],
            $postJson['mentions'],
            isset($postJson['updated_at']) ? $postJson['updated_at'] : null,
            isset($postJson['received_at']) ? $postJson['received_at'] : null
        );
    }

    public function getEntityPostInternal(Model\Server\ServerInterface $server, $apiRoot, $entityUri, $id, $version = null)
    {
        $requestParams = array();

        if (null !== $version) {
            $requestParams['version'] = $version;
        }

        $requestQuery = count($requestParams)
            ? '?'.http_build_query($requestParams)
            : '';

        $requestUri = $apiRoot.'/posts/'.rawurlencode($entityUri).'/'.$id.$requestQuery;
        $response = $this->tentHttpClient->get($requestUri)->send();

        $postJson = json_decode($response->getBody(), true);

        return new Model\Post\Post(
            $postJson['entity'],
            $postJson['id'],
            $postJson['type'],
            $postJson['licenses'],
            $postJson['permissions'],
            $postJson['content'],
            $postJson['published_at'],
            $postJson['version'],
            $postJson['app'],
            $postJson['mentions'],
            isset($postJson['updated_at']) ? $postJson['updated_at'] : null,
            isset($postJson['received_at']) ? $postJson['received_at'] : null
        );
    }
}
