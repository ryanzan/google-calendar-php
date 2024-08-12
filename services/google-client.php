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

    function initialize()
    {
        if (!isset($_SESSION['access_token'])) {
            $authUrl = $this->getAuthUrl();
            include "templates/login.php";
            exit();
        }
        try {
            $token = $_SESSION['access_token'];
            $this->client->setAccessToken($token);
            $userInfo = $this->getClientId($token);
        } catch (Exception $e) {
            $authUrl = $this->getAuthUrl();
            include "templates/login.php";
            exit();
        }
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

    function checkSessionToken()
    {

    }
}