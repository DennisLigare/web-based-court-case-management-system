<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style/index.css">
  <title>Court management system</title>
</head>

<body>

  <header id="header">
    <div class="display">
      <div class="logo-1">
        <img src="./img/CourtOfArms.png" alt="">
        <p>The Judiciary</p>
      </div>
      <div class="logo-2">
        <img src="./img/logo1.png" alt="">
        <span>Utumishi kwa wote.</span>
      </div>
    </div>

    <nav class="menu">
      <ul>
        <?php if (($_SESSION)) : ?>
          <li>Hello <?= $_SESSION['username'] ?></li>
        <?php endif; ?>
        <li><a href="./index.php" class="current">Home</a></li>
        <?php if (!$_SESSION) : ?>
          <li><a href="./login.php">Login</a></li>
          <li><a href="./registration.php">registration</a></li>
        <?php endif; ?>
        <li><a href="#About">About</a></li>
        <li><a href="#contact">Contact</a></li>
        <?php if ($_SESSION) : ?>
          <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <div id="main-body">

    <section id="contact">
      <div class="contact-container">
        <a href="https://www.facebook.com/dennispark.delligares" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://www.instagram.com/deknow_ligare/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://twitter.com/Dennis_Ligare" target="_blank"><i class="fab fa-twitter "></i></a>
        <a href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank"><i class="far fa-envelope "></i></a>

      </div>
    </section>

    <section id="about">


      <div class="content">
        <h1>Web - Based court case Management system</h1>
        <p>Web – based court case management system is a governmental
          platform for law firms, lawyers and ordinary citizens which
          allows these individuals to create a usable account once they
          have registered their case with the court administrative office.
          After creating an account, the user will log in to the web – based
          management system and fill in a form that will pop up and proceed
          to book for a hearing date. <br><br>
          This web-based application will automatically allocate the case a
          hearing date in the magistrate court.<br><br>
          Our website can be accessed by a arrange of devices such as mobile phones,
          computers and tablets as long as the device is connected to the internet.
        </p>
      </div>

      <div class="gravel">
        <img class="gravel-image-desktop" src="./img/gravel1.jpg" alt="">
        <img class="gravel-image-mobile" src="./img/judge.jpg" alt="">
      </div>
    </section>

  </div>

  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="./js/mobilemenu.js"></script>
</body>

</html>