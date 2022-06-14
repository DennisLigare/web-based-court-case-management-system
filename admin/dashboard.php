<?php

session_start();

require '../db.php';

$statement = $pdo->query("SELECT * FROM admin");
$admin_count = $statement->rowCount();

$statement = $pdo->query("SELECT * FROM individual");
$individual_count = $statement->rowCount();

$statement = $pdo->query("SELECT * FROM lawfirm");
$lawfirm_count = $statement->rowCount();

$statement = $pdo->query("SELECT * FROM organisation");
$organisation_count = $statement->rowCount();

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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style/index.css">
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
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <div id="main-dashboard">
    <div class="container">
      <div class="welcome">
        <p>Welcome, <?php echo $_SESSION['username'] ?></p>
      </div>

      <div class="admin-dashboard">
        <div class="dashboard-item">
          <i class="fa-solid fa-user-gear"></i>
          <div>
            <p>Admins</p>
            <p><?php echo $admin_count ?></p>
            <a href="admins.php">Manage</a>
          </div>
        </div>
        <div class="dashboard-item">
          <i class="fa-solid fa-users"></i>
          <div>
            <p>Individuals</p>
            <p><?php echo $individual_count ?></p>
            <a href="individuals.php">Manage</a>
          </div>
        </div>
        <div class="dashboard-item">
          <i class="fa-solid fa-scale-balanced"></i>
          <div>
            <p>Lawfirms</p>
            <p><?php echo $lawfirm_count ?></p>
            <a href="#">Manage</a>
          </div>
        </div>
        <div class="dashboard-item">
          <i class="fa-solid fa-building-columns"></i>
          <div>
            <p>Organisations</p>
            <p><?php echo $organisation_count ?></p>
            <a href="organisations.php">Manage</a>
          </div>
        </div>

      </div>
    </div>

  </div>

  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="./js/mobilemenu.js"></script>
</body>

</html>