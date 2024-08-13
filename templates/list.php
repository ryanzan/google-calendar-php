<html lang="en">
<head>
    <title>Events</title>
    <?php include "layout/header.php" ?>;
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0" style="color: #28a745; font-weight: 600;">Upcoming Events</h3>
        <a href="#" class="btn btn-success btn-md">+ Add Event</a>
    </div>
    <div class="row table-responsive">
        <table class="table  table-striped table-bordered">
            <thead class="thead-dark">
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Event Name</th>
                <th scope="col">Start Date/Time</th>
                <th scope="col">Attendees</th>
                <th scope="col">Organizer</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (count($results->getItems()) == 0) {
                echo "<tr><td colspan='7' class='text-center'>No upcoming events found.</td></tr>";
            } else {
                $count = 1;
                foreach ($results->getItems() as $event) {
                    $start = $event->getStart()->getDateTime();
                    $start = $start ? date('Y-m-d H:i', strtotime($start)) : $event->getStart()->getDate();
                    $attendees = $event->getAttendees() ? implode(', ', array_map(function ($attendee) {
                        return $attendee->getEmail();
                    }, $event->getAttendees())) : 'None';
                    $organizer = $event->getOrganizer()->getEmail();
                    $description = $event->getDescription() ?: 'No description available';

                    echo "<tr>
                    <td>{$count}</td>
                    <td>{$event->getSummary()}</td>
                    <td>{$start}</td>
                    <td>{$attendees}</td>
                    <td>{$organizer}</td>
                    <td>{$description}</td>
                    <td><a href='#' class='btn btn-danger btn-sm'>Delete</a></td>
                </tr>";
                    $count++;
                }
            }
            ?>
            </tbody>
        </table>

    </div>
</div>

<?php include "layout/footer.php" ?>
</body>
</html>

