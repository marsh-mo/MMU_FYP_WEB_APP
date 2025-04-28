<?php
function getAnnouncements($conn,){
    $announcements_query = $conn->prepare("SELECT Title, Description, Date_Posted FROM Announcements ORDER BY Date_Posted DESC");
    $announcements_query->execute();
    return $announcements_query->get_result();

}
?>