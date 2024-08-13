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

    public function createEvent($data){
        $attendeesArray = array_map('trim', explode(',', $data['attendees']));
        $event = new Google_Service_Calendar_Event([
            'summary' => $data['eventName'],
            'description' => $data['description'],
            'start' => [
                'dateTime' => "{$data['eventDate']}T{$data['startTime']}:00",
                'timeZone' => 'Asia/Kathmandu',
            ],
            'end' => [
                'dateTime' => "{$data['eventDate']}T{$data['endTime']}:00",
                'timeZone' => 'Asia/Kathmandu',
            ],
            'attendees' => array_map(function ($email) {
                return ['email' => $email];
            }, $attendeesArray),
        ]);
        $calendarId = 'primary';
        $createdEvent = null;
        try {
            $createdEvent = $this->calendar->events->insert($calendarId, $event);
        }catch (Exception $e){
           // Log it somewhere
        }
        return $createdEvent;
    }
    public function deleteEvent($id){
        $calendarId = 'primary';
        try {
            $this->calendar->events->delete($calendarId, $id);
        }catch (Exception $e){
            //Log it somewhere
            return false;
        }
        return true;
    }
}