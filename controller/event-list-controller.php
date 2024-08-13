<?php

require "vendor/autoload.php";
require "services/google-calendar.php";
require "validator/event-store-validation.php";

class EventListController
{
    protected $service;
    protected $client;
    protected $validator;

    public function __construct(GoogleClient $client)
    {
        $this->client = $client;
        $googleServiceCalendar = new Google_Service_Calendar($client->getInstance());
        $this->service = new GoogleCalendar($googleServiceCalendar);
        $this->validator = new EventStoreValidation();
    }

    public function getIndex()
    {
        $results = $this->service->getEvents();
        include "templates/list.php";
    }

    public function createEvent()
    {
        include "templates/create-event.php";
    }

    public function storeEvent($data)
    {
        $_SESSION['errors'] = [];
        $errors = $this->validator->validate($data);
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_values'] = $data;
            header('Location: create.php');
            exit();
        }
        $event = $this->service->createEvent($data);
        if ($event) {
            $_SESSION['success'] = 'Event created successfully!';
            header('Location: index.php');
        } else {
            $_SESSION['eventCreationError'] = 'Event creation failed!';
            include "templates/create-event.php";
        }
    }

    public function deleteEvent()
    {

    }
}

?>