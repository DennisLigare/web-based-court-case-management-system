<?php

session_start();

require '../db.php';

$success_message = "";

if ($_POST) {
  $statement = $pdo->prepare(
    "INSERT INTO court_date_request (reference_no, court_house_id, case_type, defendant_name, defendant_national_id, accused_name, accused_national_id, lawfirm_id) VALUES (:reference_no, :court_house_id, :case_type, :defendant_name, :defendant_id, :accused_name, :accused_id, :lawfirm_id)"
  );
  $statement->bindValue(":reference_no", $_POST['ref_no']);
  $statement->bindValue(":court_house_id", $_POST['court_house']);
  $statement->bindValue(":case_type", $_POST['case_type']);
  $statement->bindValue(":defendant_name", $_POST['defendant_name']);
  $statement->bindValue(":defendant_id", $_POST['defendant_id']);
  $statement->bindValue(":accused_name", $_POST['accused_name']);
  $statement->bindValue(":accused_id", $_POST['accused_id']);
  $statement->bindValue(":lawfirm_id", $_SESSION['user_id']);
  $statement->execute();

  $request_id = $pdo->lastInsertId();

  $statement = $pdo->prepare(
    "SELECT * FROM court_house_room 
    JOIN court_house 
    ON court_house_id=court_house.id 
    JOIN judge 
    ON court_house_room.id=room_id 
    WHERE case_type=:case_type 
    AND court_house_id=:court_house_id"
  );
  $statement->bindValue(":case_type", $_POST['case_type']);
  $statement->bindValue(":court_house_id", $_POST['court_house']);
  $statement->execute();
  $data = $statement->fetch(PDO::FETCH_ASSOC);

  $date = date_create(date('Y-m-d'));
  date_add($date, date_interval_create_from_date_string("1 day"));

  $statement = $pdo->prepare("SELECT * FROM court_appointment WHERE court_house_room_id=:room_id AND appointment_date=:date");
  $statement->bindValue(":room_id", $data['room_id']);
  $statement->bindValue(":date", date_format($date, 'Y-m-d'));
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  if ($result) {

    while ($result) {
      date_add($date, date_interval_create_from_date_string("1 day"));

      $statement = $pdo->prepare("SELECT * FROM court_appointment WHERE court_house_room_id=:room_id AND appointment_date=:date");
      $statement->bindValue(":room_id", $data['room_id']);
      $statement->bindValue(":date", date_format($date, 'Y-m-d'));
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      if (!$result) {
        break;
      }
    }
  }

  if (!$result) {
    $statement = $pdo->prepare(
      "INSERT INTO court_appointment (court_date_request_id, court_house_room_id, appointment_date) 
      VALUES (:request_id, :room_id, :appointment_date)"
    );
    $statement->bindValue(":request_id", $request_id);
    $statement->bindValue(":room_id", $data['room_id']);
    $statement->bindValue(":appointment_date", date_format($date, 'Y-m-d'));
    $statement->execute();

    header('Location: court_dates.php');
  }
}


$statement = $pdo->query("SELECT * FROM court_house");
$court_houses = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/index.css">
  <title>Get Date</title>
</head>

<body>
  <header id="header">
    <div class="display">
      <div class="logo-1">
        <img src="../img/CourtOfArms.png" alt="">
        <p>The Judiciary</p>
      </div>
      <div class="logo-2">
        <img src="../img/logo1.png" alt="">
        <span>Utumishi kwa wote.</span>
      </div>
    </div>

    <nav class="menu">
      <ul>
        <li><a href="dashboard.php" class="current">Dashboard</a></li>
        <li><a href="../logout.php">Logout</a></li>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>
  </header>

  <div id="main-dashboard">
    <div class="container">
      <div class="header">
        <h1>Get Court Date</h1>
        <div>
          <a href="dashboard.php" class="secondary">Back</a>
        </div>
      </div>

      <form method="POST" class="border w-75 p-3 shadow-sm">
        <div class="mb-3">
          <div class="form-group">
            <label for="ref_no" class="form-label">Reference No:</label>
            <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter reference number" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="court_house" class="form-label">Choose Court House:</label>
          <select name="court_house" id="court_house" required class="form-control">
            <option value="">Select court house...</option>
            <?php foreach ($court_houses as $court_house) : ?>
              <option value="<?php echo $court_house['id'] ?>">
                <?php echo $court_house['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="case_type" class="form-label">Choose Case:</label>
          <select name="case_type" id="case_type" required class="form-control">
            <option value="">Select case type...</option>
            <option value="theft">Theft</option>
            <option value="Criminal_damage">Criminal Damage</option>
            <option value="public_disorder">Public Disorder</option>
            <option value="monitoring_offecences">Monitoring Offences</option>
          </select>
        </div>
        <div class="row">
          <div class="mb-3 col">
            <label for="defendant_name" class="form-label">Name of Defendant:</label>
            <input type="text" name="defendant_name" id="defendant_name" class="form-control" placeholder="Enter name of the defendant" required>
          </div>
          <div class="mb-3 col">
            <label for="defendant_id" class="form-label">National ID of Defendant:</label>
            <input type="text" name="defendant_id" id="defendant_id" class="form-control" placeholder="Enter national ID of the defendant" required>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col">
            <label for="accused_name" class="form-label">Name of Accused:</label>
            <input type="text" name="accused_name" id="accused_name" class="form-control" placeholder="Enter name of the accused" required>
          </div>
          <div class="mb-3 col">
            <label for="accused_id" class="form-label">National ID of Accused:</label>
            <input type="text" name="accused_id" id="accused_id" class="form-control" placeholder="Enter national ID of the accused" required>
          </div>
        </div>
        <div>
          <button type="reset" class="btn btn-secondary">Reset</button>
          <button type="submit" class="btn btn-warning">Get Court Date</button>
        </div>
      </form>

    </div>

  </div>







  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>


</body>

</html>