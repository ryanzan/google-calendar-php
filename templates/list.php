<?php
if (count($results->getItems()) == 0) {
    echo "No upcoming events found.";
} else {
    echo "Upcoming events:<br>";
    foreach ($results->getItems() as $event) {
        echo $event->getSummary();
    }
}
?>