<?php

session_start();

require '../db.php';

$success_message = '';

if ($_POST) {
  $statement = $pdo->prepare(
    "UPDATE court_house_room 
    SET room_number=:room_number, court_house_id=:court_house_id 
    WHERE id=:room_id"
  );
  $statement->bindValue(":room_number", $_POST['room_number']);
  $statement->bindValue(":court_house_id", $_POST['court_house_id']);
  $statement->bindValue(":room_id", $_GET['id']);
  $statement->execute();

  $success_message = "Court House Room updated successfully!";
}

$statement = $pdo->query("SELECT * FROM court_house");
$court_houses = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM court_house_room WHERE id=:room_id");
$statement->bindValue(":room_id", $_GET['id']);
$statement->execute();
$court_house = $statement->fetch(PDO::FETCH_ASSOC);

$court_house_id = $court_house['court_house_id'];
$room_number = $court_house['room_number'];

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
        <h1>Edit Court House Room</h1>
        <div>
          <a href="court_house_rooms.php" class="secondary">Back</a>
        </div>
      </div>

      <form method="POST" class="border w-75 mx-auto p-3 shadow-sm">

        <?php if ($success_message) : ?>
          <div class="alert alert-success">
            <?php echo $success_message ?>
          </div>
        <?php endif; ?>

        <div class="row mb-3">
          <div class="col">
            <label for="court_house_id" class="form-label fw-bold">Court House:</label>
            <select name="court_house_id" id="court_house_id" class="form-control">
              <option value="">Select court house...</option>
              <?php foreach ($court_houses as $court_house) : ?>
                <option value="<?php echo $court_house['id'] ?>" <?php echo $court_house['id'] == $court_house_id ? 'selected' : '' ?>>
                  <?php echo $court_house['name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label for="room_number" class="form-label fw-bold">Room Number:</label>
            <input type="text" name="room_number" id="room_number" class="form-control" value="<?php echo $room_number ?>" placeholder="Enter room number" required>
          </div>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </div>
    </form>

  </div>

  </div>


  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script src="../js/registration.js"></script>
  <script type="text/javascript" src="../js/mobilemenu.js"></script>
  </script>
</body>

</html>