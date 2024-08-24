<?php

class EventStoreValidation
{
    public function __construct(){}

    public function validate($event): array
    {
        $eventName = trim($event['eventName']);
        $eventDate = $event['eventDate'];
        $startTime = $event['startTime'];
        $endTime = $event['endTime'];
        $attendees = trim($event['attendees']);
        $errors = [];

        // Validate event name
        if (empty($eventName)) {
            $errors['eventName'] = "Event Name is required.";
        }

        // Validate event date
        if (empty($eventDate) || !DateTime::createFromFormat('Y-m-d', $eventDate)) {
            $errors['eventDate'] = "Invalid Event Date.";
        }

        // Validate start and end times
        if (empty($startTime) || empty($endTime)) {
            $errors['startTime'] = "Start Time and End Time are required.";
            $errors['endTime'] = "Start Time and End Time are required.";
        } else {
            $startDateTime = DateTime::createFromFormat('Y-m-d H:i', "$eventDate $startTime");
            $endDateTime = DateTime::createFromFormat('Y-m-d H:i', "$eventDate $endTime");
            if ($endDateTime <= $startDateTime) {
                $errors['endTime'] = "End Time must be after Start Time.";
            }
        }
        // Validate attendees
        if (!empty($attendees)) {
            $attendeesArray = array_map('trim', explode(',', $attendees));
            foreach ($attendeesArray as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['attendees'] = "Invalid email address: $email";
                }
            }
        }
        return $errors;
    }
}
?>