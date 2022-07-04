<?php

session_start();

$court_house_room_id = $_POST['court_house_room_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM court_house_room WHERE id=:court_house_room_id");
$statement->bindValue("court_house_room_id", $court_house_room_id);
$statement->execute();

header("Location: court_house_rooms.php");
