<?php

require '../db.php';

$statement = $pdo->prepare(
  "SELECT * FROM court_house_room WHERE court_house_id=:court_house_id"
);
$statement->bindValue(":court_house_id", $_REQUEST['id']);
$statement->execute();
$rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rooms);
