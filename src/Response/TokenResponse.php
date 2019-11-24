<?php


namespace Hubspot\Psr7\Response;


use Hubspot\Psr7\Exception\BadTokenRequestException;
use Psr\Http\Message\ResponseInterface;

class TokenResponse
{
    private $data;

    public function __construct(ResponseInterface $response)
    {
        $data = (string) $response->getBody();
        $data = json_decode($data);

        if($response->getStatusCode() === 400){
            throw new BadTokenRequestException($data->message);
        }

        $this->data = $data;
    }

    public function getAccessToken()
    {
        return $this->data->access_token;
    }

    public function getRefreshToken()
    {
        return $this->data->refresh_token;
    }
}