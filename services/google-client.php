<?php

class GoogleClient
{
    protected $client;

    function __construct(Google_Client $client, $config)
    {
        $this->client = $client;
        $this->client->setAuthConfig(__DIR__ . '/../config/credentials.json');
        $this->client->setRedirectUri(trim($config['redirectUrl']));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

    }

    function getInstance()
    {
        return $this->client;
    }

    function initialize()
    {
        if (!isset($_SESSION['access_token'])) {
            $authUrl = $this->getAuthUrl();
            include "templates/login.php";
            exit();
        }
        $token = $_SESSION['access_token'];
        $this->client->setAccessToken($token);
        if ($this->client->isAccessTokenExpired()) {
            $authUrl = $this->getAuthUrl();
            include "templates/login.php";
            exit();
        }
    }

    function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    function fetchAccessToken($authCode)
    {
        return $this->client->fetchAccessTokenWithAuthCode($authCode);
    }

    function setAccessToken($accessToken)
    {
        $this->client->setAccessToken($accessToken);
    }

    function getClientId($accessToken)
    {
        return $this->client->getClientId();
    }
}