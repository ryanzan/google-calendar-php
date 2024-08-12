<?php
class GoogleCalendar
{
    protected $calendar;
    public function __construct(Google_Service_Calendar $calendar){
        $this->calendar = $calendar;
    }

    public function getInstance(){
        return $this->calendar;
    }

    public function getEvents(){
        $calendarId = 'primary';
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );
        return $this->calendar->events->listEvents($calendarId, $optParams);
    }

    public function createEvent(){

    }
    public function updateEvent(){

    }

    public function deleteEvent(){

    }
}