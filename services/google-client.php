<?php

class GoogleClient
{

    function __construct(protected Google_Client $client, array $config)
    {
        $this->client->setAuthConfig(__DIR__ . '/../config/credentials.json');
        $this->client->setRedirectUri(trim($config['redirectUrl']));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

    }

    function getInstance(): Google_Client
    {
        return $this->client;
    }

    function initialize(): void
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

    function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    function fetchAccessToken($authCode): array
    {
        return $this->client->fetchAccessTokenWithAuthCode($authCode);
    }

    function setAccessToken($accessToken): void
    {
        $this->client->setAccessToken($accessToken);
    }

    function getClientId($accessToken): string
    {
        return $this->client->getClientId();
    }
}