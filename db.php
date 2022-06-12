<?php

$pdo = new PDO(
  "mysql:host=localhost;port=3306;dbname=web-based-court-case-management-system",
  "root",
  ""
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
