<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Belgrade');

session_start();
session_unset();

?>
<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="super-style.css">
</head>
<body>
<form method="post" action="delete.php" class="form-group customFormModi">
<div class="form-group">
<?php 

if (isset($_POST)) {
  var_dump($_POST);
}else{
//var_dump($_POST['search']);
}



echo"<table class='listtable table table-dark '>
      <thead>
        <tr>
          <th scope='col'>#</th>
          <th scope='col'></th>
          <th scope='col'>Name</th>
          <th scope='col'>Email</th>
          <th scope='col'>Role</th>
          <th scope='col'>Options</th>
        </tr>
      </thead>
      <tbody>";

        include('db_config.php');



        $sql = "SELECT * from users";
        if (!$result = $connection->query($sql)) {
            echo "Sorry, the website is experiencing problems.";
            exit;
        }
       
        $counter = 1;
        while ($res = $result->fetch_assoc()) {
          echo"
          <tr>
            <td scope='row' class='checkbox0'>
              <div class='form-check'>
                <input class='form-check-input position-static' type='checkbox' name='check_list[]' id='blankCheckbox' value='$res[id]' aria-label='...'>
              </div>
            </td>
            <td class='counter'>$counter</td>
            <td>$res[name]</td>
            <td>$res[email]</td>
            <td class='roles'>$res[roles]</td>
            <td class='buttonOption'>

               <a href='delete.php ?member=$res[id]' ><img class='lilIcons' src='delete_white_96x96.png' id='$res[id]'  alt=''></a>
               <a href='modify.php ?member=$res[id]' ><img class='lilIcons' src='update_white_96x96.png' id='$res[id]'  alt=''></a>
               
            </td>
          </tr>
          ";
      $counter ++;
        }
      $result->free();
      $connection->close();
echo"</tbody>
    </table>";




?>
<div class="input-group customOption">

  <div class="input-group-append">
      <input type="text" class="form-control" name="search">
    <button class="btn btn-outline-secondary" type="submit" value="Submit" name="submit">Search</button>
  </div>
</div>
</div>
</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>