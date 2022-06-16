<?php

session_start();

$id_number = $_POST['id_number'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM individual WHERE id_number=:id_number");
$statement->bindValue("id_number", $id_number);
$statement->execute();

header("Location: individuals.php");
