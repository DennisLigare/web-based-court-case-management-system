<?php

$pdo = new PDO(
  "mysql:host=localhost;port=3306;dbname=court_management_system",
  "root",
  ""
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
