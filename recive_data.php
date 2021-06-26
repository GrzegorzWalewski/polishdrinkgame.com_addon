<?php
header("Access-Control-Allow-Origin: *");
include_once('db.php');
/**
 * Save game data to db
 */
if(isset($_POST['gameId']))
{
    $gameId = $_POST['gameId'];
    $number = $_POST['number'];
    $gameTask = htmlspecialchars($_POST['gameTask'], ENT_QUOTES);
    $additionalTask = htmlspecialchars($_POST['additionalTask'], ENT_QUOTES);
    $player = htmlspecialchars($_POST['player'], ENT_QUOTES);
    $sql = 'select id from gameData where id='. $gameId;
    $gameData = $conn->query($sql)->fetch_assoc();
    if($gameData != null)
    {
        $sql = "update gameData set id = " . $gameId . ", number = " . $number . ", gameTask = '" . $gameTask . "', player = '" . $player . "', additionalTask = '".$additionalTask."' where id = " . $gameId;
        $conn->query($sql);
    }
    else
    {
        $sql = "insert into gameData (id, number, gameTask, additionalTask, player) values(" . $gameId.", " . $number.",'" . $gameTask."', '" . $additionalTask."', '" . $player . "')";
        $conn->query($sql);
    }
    if($_POST['gamersPos'] != null)
    {
        foreach($_POST['gamersPos'] as $key => $gamerPos)
        {
            $sql = 'select id from gamers where gameId='. $gameId .' and userId = ' . $key;
            $gamer = $conn->query($sql)->fetch_assoc();
            if($gamer != null)
            {
                $sql = "update gamers set pos = " . $gamerPos['pos'] . " where userId = " . $key . " and gameId = " . $gameId;
            }
            else
            {
                $sql = "insert into gamers (username, gameId, pos, userId) values('" . $gamerPos['username'] . "', " . $gameId . ", " . $gamerPos['pos'] . ", " .$key .")";
            }
            $conn->query($sql);
        }
    }
}