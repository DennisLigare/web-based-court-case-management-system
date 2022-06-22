<?php

session_start();

require '../db.php';

$id = $_GET['id'];

$error_message = '';
$success_message = '';

if ($_POST) {

  $statement = $pdo->prepare(
    "SELECT * FROM judge WHERE email=:email"
  );
  $statement->bindValue(":email", $_POST['email']);
  $statement->execute();
  $judge = $statement->fetch(PDO::FETCH_ASSOC);

  if ($judge && $judge['id'] == $id) {
    $statement = $pdo->prepare(
      "UPDATE judge SET first_name= :first_name,  last_name=:last_name, phone_number=:phone_number, email=:email WHERE id=:id"
    );
    $statement->bindValue(":first_name", $_POST['first_name']);
    $statement->bindValue(":last_name", $_POST['last_name']);
    $statement->bindValue(":phone_number", $_POST['phone_number']);
    $statement->bindValue(":email", $_POST['email']);
    $statement->bindValue(":id", $id);
    $statement->execute();


    $statement = $pdo->prepare(
      "UPDATE judge SET email=:email WHERE id=:id"
    );
    $statement->bindValue(":email", $_POST['email']);
    $statement->bindValue(":id", $id);
    $statement->execute();

    $success_message = "User updated successfully!";
  } else {
    $error_message = "A user with the same email already exists.";
  }
}

$statement = $pdo->prepare("SELECT * FROM judge WHERE id=:id");
$statement->bindValue("id", $id);
$statement->execute();
$judge = $statement->fetch(PDO::FETCH_ASSOC);

$first_name = $judge['first_name'];
$last_name = $judge['last_name'];
$phone_number = $judge['phone_number'];
$email = $judge['email'];

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        <h1>Edit Judge</h1>
        <div>
          <a href="judges.php" class="secondary">Back</a>
        </div>
      </div>

      <form method="POST" class="border w-75 mx-auto p-3 shadow-sm">

        <?php if ($error_message) : ?>
          <div class="alert alert-danger">
            <?php echo $error_message ?>
          </div>
        <?php endif; ?>

        <?php if ($success_message) : ?>
          <div class="alert alert-success">
            <?php echo $success_message ?>
          </div>
        <?php endif; ?>

        <div class="row mb-3">
          <div class="col">
            <label for="first_name" class="form-label fw-bold">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name ?>" placeholder="Enter first name" required>
          </div>
          <div class="col">
            <label for="last_name" class="form-label fw-bold">Second Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name ?>" placeholder="Enter last name" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label for="phone_number" class="form-label fw-bold">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $phone_number ?>" maxlength="10" placeholder="Enter phone number" required>
          </div>
          <div class="col">
            <label for="email" class="form-label fw-bold">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter email" required>
          </div>
        </div>
        <div>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>

    </div>

  </div>


  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="../js/mobilemenu.js"></script>
</body>

</html>