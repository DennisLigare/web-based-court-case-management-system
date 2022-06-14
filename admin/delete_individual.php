<?php

session_start();

$id = $_POST['id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM individual WHERE id=:individual_id");
$statement->bindValue("individual_id", $individual_id);
$statement->execute();

header("Location: individuals.php");
