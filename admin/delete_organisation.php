<?php

session_start();

$organisation_id = $_POST['organisation_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM organisation WHERE organisation_id=:organisation_id");
$statement->bindValue("organisation_id", $organisation_id);
$statement->execute();

header("Location: organisations.php");
