<?php

session_start();

$judge_id = $_POST['judge_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM judge WHERE id=:judge_id");
$statement->bindValue("judge_id", $judge_id);
$statement->execute();

header("Location: judges.php");
