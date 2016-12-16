<?php

namespace App\Services;

class JWT
{
    /**
     * Token.
     *
     * @var string
     */
    private $token;

    /**
     * JWT constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Returns time to live of the JWT token.
     *
     * @return int
     */
    public function getTokenTTL()
    {
        $payload = $this->decodeToken();

        return isset($payload['exp']) ? $payload['exp'] : 0;
    }

    /**
     * Returns an array with payload of the JWT token.
     *
     * @return array
     */
    private function decodeToken()
    {
        $payloadArray = [];
        $parts = $this->sliceToken();

        if (isset($parts[1])) {
            $json = base64_decode($parts[1]);
            $payloadArray = json_decode($json, true);
        }

        return $payloadArray;
    }

    /**
     * Divides the JWT token into parts.
     *
     * @return array
     */
    private function sliceToken()
    {
        $parts = explode('.', $this->token);

        return count($parts) ? $parts : [];
    }
}
