<?php

/**
 * TentPHP
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace Depot\Core\Domain\Model\Auth;

class HmacHelper
{
    static public function generateAuthorizationHeader($method, $url, $macKeyId, $macKey)
    {
        $ts       = time();
        $nonce    = uniqid('', true);

        return self::getAuthorizationHeader($method, $url, $macKeyId, $macKey, $ts, $nonce);
    }

    static public function getAuthorizationHeader($method, $url, $macKeyId, $macKey, $ts, $nonce)
    {
        $normalizedRequestString = self::getNormalizedRequestString($ts, $nonce, $method, $url);
        $mac = base64_encode(hash_hmac('sha256', $normalizedRequestString, $macKey, true));

        return sprintf(
            'MAC id="%s", ts="%s", nonce="%s", mac="%s"',
            $macKeyId,
            $ts,
            $nonce,
            $mac
        );
    }

    static private function getNormalizedRequestString($ts, $nonce, $method, $url)
    {
        $parts = parse_url($url);

        $requestParts = array(
            $ts,
            $nonce,
            $method,
            $parts['path'] . ((isset($parts['query']) && $parts['query']) ? "?" . $parts['query'] : ""),
            $parts['host'],
            (isset($parts['port']) ?: (($parts['scheme']=="https") ? 443 : 80)),
            "",
            ""
        );

        return implode("\n", $requestParts);
    }
}
