<?php

session_start();

$court_house_id = $_POST['court_house_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM court_house WHERE id=:court_house_id");
$statement->bindValue("court_house_id", $court_house_id);
$statement->execute();

header("Location: court_houses.php");
