<?php

session_start();

require '../db.php';

$statement = $pdo->query("SELECT * FROM lawfirm");
$lawfirms = $statement->fetchAll(PDO::FETCH_ASSOC);



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
        <h1>Manage Lawfirms</h1>
        <div>
          <a href="add_lawfirm.php" class="primary">Add Lawfirm</a>
          <a href="dashboard.php" class="secondary">Back</a>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Law Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lawfirms as $i => $lawfirm) : ?>
            <tr>
              <td><?php echo $i + 1 ?></td>
              <td><?php echo $lawfirm['lawfirm_name'] ?></td>
              <td><?php echo $lawfirm['phone_number'] ?></td>
              <td><?php echo $lawfirm['email'] ?></td>
              <td class="actions">
                <a href="edit_lawfirm.php?id=<?php echo $lawfirm['lawfirm_id'] ?>" class="edit"><i class="fa-solid fa-user-pen"></i></a>
                <!-- <a href="delete_lawfirm.php?id=<?php echo $lawfirm['id'] ?>" class="delete"><i class="fa-solid fa-trash-can"></i></a> -->
                <form action="delete_lawfirm.php" method="POST">
                  <input type="hidden" name="lawfirm_id" value="<?php echo $lawfirm['lawfirm_id'] ?>">
                  <button type="submit" class="delete"><i class="fa-solid fa-trash-can"></i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>

  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="./js/mobilemenu.js"></script>
</body>

</html>