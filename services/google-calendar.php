<?php
class GoogleCalendar
{
    public function __construct(protected Google_Service_Calendar $calendar){}

    public function getInstance(): Google_Service_Calendar{
        return $this->calendar;
    }

    public function getEvents(): Google\Service\Calendar\Events{
        $calendarId = 'primary';
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );

        return $this->calendar->events->listEvents($calendarId, $optParams);
    }

    public function createEvent(array $data): ?\Google\Service\Calendar\Event
    {
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
    public function deleteEvent(string $id): bool{
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