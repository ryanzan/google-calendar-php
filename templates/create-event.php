<?php
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formValues = isset($_SESSION['form_values']) ? $_SESSION['form_values'] : [];
$eventCreationError = isset($_SESSION['eventCreationError']) ? $_SESSION['eventCreationError'] : null;
unset($_SESSION['errors']);
unset($_SESSION['form_values']);
unset($_SESSION['eventCreationError']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <?php include "layout/header.php"; ?>
</head>
<body>
<div class="container mt-5">
    <?php if ($eventCreationError): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?= $eventCreationError ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h2 class="mb-4" style="color: #28a745;">Add New Event</h2>

    <form action="create.php" method="post">
        <div class="form-group mb-2">
            <label for="eventName">Event Name</label>
            <input type="text" class="form-control" id="eventName" name="eventName"
                   value="<?= $formValues['eventName'] ?? ''; ?>">
            <?php if (!empty($errors['eventName'])): ?>
                <div class="text-danger"><?= $errors['eventName']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-2">
            <label for="eventDate">Event Date</label>
            <input type="date" class="form-control" id="eventDate" name="eventDate"
                   value="<?= $formValues['eventDate'] ?? ''; ?>">
            <?php if (!empty($errors['eventDate'])): ?>
                <div class="text-danger"><?= $errors['eventDate']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-2">
            <label for="startTime">Start Time</label>
            <input type="time" class="form-control" id="startTime" name="startTime"
                   value="<?= $formValues['startTime'] ?? ''; ?>">
            <?php if (!empty($errors['startTime'])): ?>
                <div class="text-danger"><?= $errors['startTime']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-2">
            <label for="endTime">End Time</label>
            <input type="time" class="form-control" id="endTime" name="endTime"
                   value="<?= $formValues['endTime'] ?? ''; ?>">
            <?php if (!empty($errors['endTime'])): ?>
                <div class="text-danger"><?= $errors['endTime']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-2">
            <label for="attendees">Attendees (comma-separated emails)</label>
            <input type="text" class="form-control" id="attendees" name="attendees"
                   value="<?= $formValues['attendees'] ?? ''; ?>">
            <?php if (!empty($errors['attendees'])): ?>
                <div class="text-danger"><?= $errors['attendees']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-2">
            <label for="description">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">
                <?= htmlspecialchars($formValues['description'] ?? ''); ?>
            </textarea>
        </div>
        <button type="submit" class="btn btn-success btn-md">Create Event</button>
    </form>
</div>
<?php include "layout/footer.php"; ?>
</body>
</html>
