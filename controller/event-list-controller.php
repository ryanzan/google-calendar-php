<?php

require "vendor/autoload.php";
require "services/google-calendar.php";

class EventListController
{
    protected $service;

    public function __construct(GoogleClient $client)
    {
        $googleServiceCalendar = new Google_Service_Calendar($client->getInstance());
        $this->service = new GoogleCalendar($googleServiceCalendar);
    }

    public function getIndex()
    {
        $results = $this->service->getEvents();
        include "templates/list.php";
    }

    public function createEvent()
    {

    }

    public function updateEvent()
    {

    }

    public function deleteEvent(){

    }
}

?>