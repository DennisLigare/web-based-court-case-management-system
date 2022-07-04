<?php

session_start();

require '../db.php';

$id = $_GET['id'];

$error_message = '';
$success_message = '';

if ($_POST) {

  $statement = $pdo->prepare(
    "UPDATE judge 
    SET first_name= :first_name, last_name=:last_name, phone_number=:phone_number, email=:email, case_type=:case_type, room_id=:room_id 
    WHERE id=:id"
  );
  $statement->bindValue(":first_name", $_POST['first_name']);
  $statement->bindValue(":last_name", $_POST['last_name']);
  $statement->bindValue(":phone_number", $_POST['phone_number']);
  $statement->bindValue(":email", $_POST['email']);
  $statement->bindValue(":case_type", $_POST['case_type']);
  $statement->bindValue(":room_id", $_POST['room']);
  $statement->bindValue(":id", $id);
  $statement->execute();

  $success_message = "Judge updated successfully!";
}

$statement = $pdo->prepare("SELECT * FROM judge WHERE id=:id");
$statement->bindValue("id", $id);
$statement->execute();
$judge = $statement->fetch(PDO::FETCH_ASSOC);

$first_name = $judge['first_name'];
$last_name = $judge['last_name'];
$phone_number = $judge['phone_number'];
$email = $judge['email'];
$case_type = $judge['case_type'];
$room_id = $judge['room_id'];

$statement = $pdo->prepare(
  "SELECT * FROM court_house_room
  JOIN court_house 
  ON court_house_id=court_house.id 
  WHERE court_house_room.id=:room_id"
);
$statement->bindValue(":room_id", $room_id);
$statement->execute();
$judge_court_house = $statement->fetch(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/bootstrap.min.css">
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
        <div class="row mb-3">
          <div class="col">
            <label for="case_type" class="form-label fw-bold">Case Type:</label>
            <select name="case_type" id="case_type" class="form-control" required>
              <option value="">Select case type...</option>
              <option value="theft" <?php echo $case_type == 'theft' ? 'selected' : '' ?>>Theft</option>
              <!-- <option value="theft" <?php echo $case_type == 'theft' ? 'selected' : '' ?>>Theft</option>
              <option value="theft" <?php echo $case_type == 'theft' ? 'selected' : '' ?>>Theft</option>
              <option value="theft" <?php echo $case_type == 'theft' ? 'selected' : '' ?>>Theft</option> -->
            </select>
          </div>
          <div class="col"></div>
        </div>
        <div class="row mb-3">
          <div class="col form-group">
            <label for="court_house">Court House</label>
            <select name="court_house" id="court_house" class="form-control">
              <option value="">Select court house...</option>
              <?php foreach ($court_houses as $court_house) : ?>
                <option value="<?php echo $court_house['id'] ?>" <?php echo $judge_court_house['name'] == $court_house['name'] ? 'selected' : '' ?>><?php echo $court_house['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col form-group">
            <label for="room">Room</label>
            <input type="hidden" name="room_id" id="room_id" value="<?php echo $room_id ?>">
            <select name="room" id="room" class="form-control">
              <option value="">Select room...</option>
            </select>
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
  <script>
    const courtHouse = document.getElementById('court_house');
    const selectRoom = document.getElementById('room');
    const roomId = document.getElementById('room_id')

    getRooms()

    courtHouse.addEventListener('change', getRooms)

    function getRooms() {
      selectRoom.innerHTML = '<option value="">Select room...</option>'
      fetch(`get_rooms.php?id=${courtHouse.value}`).then(response => response.json()).then(rooms => {
        rooms.forEach(room => {
          const option = document.createElement('option')
          option.value = room.id
          option.innerText = room.room_number
          if (room.id == roomId.value) {
            option.selected = true
          }
          selectRoom.appendChild(option)
        })
      })
    }
  </script>
</body>

</html>