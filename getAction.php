<?php
header("Access-Control-Allow-Origin: *");
require_once('db.php');
if($_POST['done'] == true && $_POST['id'] !== 0)
{
    $sql = "update actions set done=true where id=" . $_POST['id'];
    $conn->query($sql);
}
$sql = "select * from actions where done = false and id >= " . $_POST['id'] . " and gameId = " . $_POST['gameId'];
$action = $conn->query($sql)->fetch_assoc();
if($action != null)
{
    header('Content-type: application/json');
    echo json_encode(['new' => true, 'actionId' => $action['id'], 'created_at' => $action['created_at'], 'done' => $action['done'], 'name' => $action['name']]);
}
else
{
    header('Content-type: application/json');
    echo json_encode(['new' => false]);
}
?>