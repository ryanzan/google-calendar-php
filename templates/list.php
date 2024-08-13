<?php
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$error = isset($_SESSION['generalError']) ? $_SESSION['generalError'] : null;
unset($_SESSION['success']);
unset($_SESSION['generalError']);
?>
<html lang="en">
<head>
    <title>Events</title>
    <?php include "layout/header.php" ?>
</head>
<body>
<div class="container-fluid">
    <div class="container mt-2">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-end" style="padding-right: 0">
                <div class="float-right">
                    <?php include "layout/signout.php" ?>
                </div>
            </div>
        </div>
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>OOPs! </strong> <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0" style="color: #28a745; font-weight: 600;">Upcoming Events</h3>
            <a href="create.php" class="btn btn-success btn-md">+ Add Event</a>
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
                    <td>
                     <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' data-id='{$event->id}'>Delete</button>
                    </td>
                </tr>";
                        $count++;
                    }
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    Are you sure you want to delete this event?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        <input type="hidden" name="id" id="deleteId" value="">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "layout/footer.php" ?>
</body>
</html>

