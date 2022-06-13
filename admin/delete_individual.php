<?php

session_start();

$admin_id = $_POST['individual_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM individual WHERE id=:individual_id");
$statement->bindValue("individual_id", $individual_id);
$statement->execute();

header("Location: individuals.php");
