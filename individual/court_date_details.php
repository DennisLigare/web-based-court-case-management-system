<?php

session_start();

$appointment_id = $_GET['id'];

require '../db.php';

$statement = $pdo->prepare(
  "SELECT * FROM court_appointment 
  JOIN court_date_request 
  ON court_date_request_id=court_date_request.id 
  JOIN court_house 
  ON court_house_id=court_house.id 
  JOIN court_house_room 
  ON court_house_room_id=court_house_room.id 
  JOIN judge 
  ON court_house_room_id=room_id
  WHERE court_appointment.id=:id"
);
$statement->bindValue(":id", $appointment_id);
$statement->execute();
$court_date = $statement->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style/index.css">
  <link rel="stylesheet" href="../style/print.css">
  <title>Court management system</title>
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

  <div id="main-dashboard" class="main-form">
    <div class="container">
      <div class="border shadow-lg p-3 w-75 mx-auto">
        <div class="header">
          <h1>Court Date Details</h1>
          <div>
            <a href="court_dates.php" class="secondary">Back</a>
          </div>
        </div>

        <h2>Case Details</h2>
        <div class="details">
          <div>
            <div>
              <p>Case Reference No: <span><?php echo $court_date['reference_no'] ?></span></p>
            </div>
            <div>
              <p>Case Type: <span><?php echo ucfirst($court_date['case_type']) ?></span></p>
            </div>
            <div>
              <p>Court Date: <span><?php echo date_format(date_create($court_date['appointment_date']), 'd-m-Y') ?></span></p>
            </div>
          </div>
          <div>
            <div>
              <p>Defendant Name: <span><?php echo $court_date['defendant_name'] ?></span></p>
            </div>
            <div>
              <p>Defendant ID No.: <span><?php echo $court_date['defendant_national_id'] ?></span></p>
            </div>
          </div>
          <div>
            <div>
              <p>Accused Name: <span><?php echo $court_date['accused_name'] ?></span></p>
            </div>
            <div>
              <p>Accused ID No.: <span><?php echo $court_date['accused_national_id'] ?></span></p>
            </div>
          </div>
        </div>
        <h2>Court Details</h2>
        <div class="details">
          <div>
            <p>Court House: <span><?php echo $court_date['name'] ?></span></p>
          </div>
          <div>
            <p>Room Number: <span><?php echo $court_date['room_number'] ?></span></p>
          </div>
          <div>
            <p>Judge: <span><?php echo $court_date['first_name'] . ' ' . $court_date['last_name']  ?></span></p>
          </div>
        </div>
        <button class="print-btn" onclick="window.print()">
          <i class="fa-solid fa-print"></i>
          Print
        </button>
      </div>

    </div>

  </div>

  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="./js/mobilemenu.js"></script>
</body>

</html>