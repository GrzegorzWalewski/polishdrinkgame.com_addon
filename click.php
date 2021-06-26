<?php
/**
 * save dice click action to db
 */
require_once('db.php');
$sql = "insert into actions (name, done, gameId) values('". $_POST['actionName']."', ". $_POST['done'] .", ". $_POST['gameId'] .")";
$conn->query($sql);
echo $conn->insert_id;
?>