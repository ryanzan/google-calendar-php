<?php

require "vendor/autoload.php";
require "services/google-calendar.php";
require "validator/event-store-validation.php";

class EventController
{
    protected $service;
    protected $validator;

    public function __construct(protected GoogleClient $client)
    {
        $googleServiceCalendar = new Google_Service_Calendar($client->getInstance());
        $this->service = new GoogleCalendar($googleServiceCalendar);
        $this->validator = new EventStoreValidation();
    }

    public function getIndex(): void
    {
        $results = $this->service->getEvents();
        include "templates/list.php";
    }

    public function createEvent(): void
    {
        include "templates/create-event.php";
    }

    public function storeEvent($data) : void
    {
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
        } else {
            $_SESSION['generalError'] = 'Event creation failed!';
        }
        header('Location: index.php');
    }

    public function deleteEvent($id): void
    {
        if (!$id){
            $_SESSION['generalError'] = 'Event id is required to delete the event!';
            header('Location: index.php');
            exit();
        }
        $isDeleted = $this->service->deleteEvent($id);
        if ($isDeleted){
            $_SESSION['success'] = 'Event deleted successfully!';
        }
        else{
            $_SESSION['generalError'] = 'Event deletion failed!';
        }
        header('Location: index.php');
    }
}

?>