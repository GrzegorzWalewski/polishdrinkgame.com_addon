<?php
/**
 * Return game data
 */
include_once('db.php');
if($_POST['gameId'])
{
    $sql = 'select * from gameData where id='. $_POST['gameId'];
    $gameData = $conn->query($sql)->fetch_assoc();
    $sql = 'select * from gamers where gameId='. $_POST['gameId'];
    $gamers = $conn->query($sql)->fetch_all();
    if($gameData != null)
    {
        header('Content-type: application/json');
        echo json_encode(['status' => 'success', 'number' => $gameData['number'], 'gameTask' => htmlspecialchars_decode($gameData['gameTask'],ENT_QUOTES), 'additionalTask' => htmlspecialchars_decode($gameData['additionalTask'],ENT_QUOTES), 'player' => $gameData['player'], 'gamers' => $gamers]);
    }
    else
    {
        header('Content-type: application/json');
        echo json_encode(['status' => 'error']);
    }
}