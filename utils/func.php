<?php 
function humanDateFriendly($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d M Y - H:i');
}