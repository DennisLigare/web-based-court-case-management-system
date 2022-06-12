<?php

session_start();

$admin_id = $_POST['admin_id'];

require '../db.php';

$statement = $pdo->prepare("DELETE FROM admin WHERE id=:admin_id");
$statement->bindValue("admin_id", $admin_id);
$statement->execute();

header("Location: admins.php");
