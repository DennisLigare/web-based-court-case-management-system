<?php

session_start();

$lawfirm_id = $_POST['lawfirm_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM lawfirm WHERE lawfirm_id=:lawfirm_id");
$statement->bindValue("lawfirm_id", $lawfirm_id);
$statement->execute();

header("Location: lawfirms.php");
