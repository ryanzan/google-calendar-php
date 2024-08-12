<?php
class GoogleClient{
    protected $client;

    function __construct(Google_Client $client, $config)
    {
        $this->client = $client;
        $this->client->setAuthConfig(__DIR__.'/../googleAuth/credentials.json');
        $this->client->setRedirectUri($config['redirectUrl']);
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
    }

    function getInstance()
    {
        return $this->client;
    }
    function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    function fetchAccessToken($authCode){
        return $this->client->fetchAccessTokenWithAuthCode($authCode);
    }

    function setAccessToken($accessToken){
        $this->client->setAccessToken($accessToken);
    }

    function getClientId($accessToken)
    {
        return $this->client->getClientId();
    }
}