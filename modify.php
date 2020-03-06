<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Belgrade');


session_start();

if (empty($_GET['member'])) {
}else{
  $_SESSION['member'] = $_GET['member'];
}
$member = $_SESSION["member"];

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


<?php 
include('db_config.php');

$member = $_SESSION["member"];


$usernameErr = $nameErr = $emailErr = $passwordErr = $cpasswordErr = $activeErr =  "";
$username0 = $name = $email = $password = $cpassword = $active = $permission = $country = $pcode = $city = $address = $avatar = "";
$usernamedb = $namedb = $emaildb = $pwdb = $activedb = $roledb = $countrydb = $pcodedb = $citydb = $addressdb = $avatardb = "";


echo"<table class='table table-dark'>
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

        $sql = "SELECT * FROM users WHERE id = '$member'";
        if (!$result = $connection->query($sql)) {
            echo "Sorry, the website is experiencing problems.";
            exit;
        }
        
        $counter = 1;

        while ($res = $result->fetch_assoc()) {

          $usernamedb = $res['username'];
          $namedb     = $res['name'];
          $emaildb    = $res['email'];
          $roledb     = $res['roles'];
          $pwdb       = $res['password'];
          $avatardb   = $res['avatar'];
          $activedb   = $res['active'];
          $countrydb  = $res['country'];
          $pcodedb    = $res['pcode'];
          $citydb     = $res['city'];
          $addressdb  = $res['address'];


          $_SESSION['pwtmp'] = $res['password'];

          echo"
          <tr>
            <td scope='row' class='checkbox0'>
              <div class='form-check'>
                <input class='form-check-input position-static' type='checkbox' id='blankCheckbox' value='$res[id]' aria-label='...'>
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

    if (empty($avatar)) {
      $avatar = $avatardb;
    }

    if (empty($password)) {
      $password = $pwdb;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      //var_dump($_POST);
      if (isset($_FILES['image'])) {
        require('imgupload.php');

          $file_name  =  str_replace(' ', '_',$_FILES['image']['name']);
          $file_name_char_clean = preg_replace( '/[^a-z0-9 !_]/i', '', $file_name);
          $file_desti =  "uploads/" ;
          $tmp = explode('.', $file_name);
          $file_extension = end($tmp);
          $full_file_name = str_replace($file_extension, "", $file_name_char_clean);
          $file_NameClean = $full_file_name . '.' .$file_extension;
          $file_size = $_FILES['image']['size'];
          $extensions= array("jpeg","jpg","png");

            $file = array(array(
                  'name'      =>    $file_NameClean,
                  'extension' =>    $file_extension,
                  'size'      =>    $file_size   ));

            $settings   =  array(array(
                  'allowed_extension'  =>    $extensions,
                  'max_file_size'      =>    153600  ));

          $imgStatus = array();
          $imgStatus = uploadFile($file, $file_desti, $settings);

          if(empty($imgStatus[1]['name'])){
              $imgStatus[0]['status'] = "";
              $imgStatus[0]['msg']    = "no file choosed";
              $avatar = $avatardb;
            }else{
              $avatar = $imgStatus[1]['name'];
            }
      }




      if (empty($_POST["username"])) {
          $username0 = $usernamedb;
  
      } else {

        $username0 = test_input($_POST["username"]);
        $username0 = ltrim($username0);
      }
      
      if (empty($_POST["name"])) {
        $name = $namedb;
      } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $nameErr = "Only letters and white space allowed";
        }
      }
      
      if (empty($_POST["email"])) {
        $email = $emaildb;
      } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
      }
   
      if (empty($_POST["password"])) {
        $password = $pwdb;
      } else {
        $password = $_POST["password"];
      }

      if ($password ='') {
        $passwordErr = "empty";
      }

      if (empty($_POST["active"])) {
        $activeErr = "Active status is required";
      } else {

        $active = test_input($_POST["active"]);
      }
      
      if (empty($_POST["permission"])) {
        $permission = "no";
      } else {
        $permission = test_input($_POST["permission"]);
      }
      
      if (empty($_POST["country"])) {
      
      } else {
        $country = test_input($_POST["country"]);
      }
      
      if (empty($_POST["pcode"])) {
      
      } else {
        $pcode = test_input($_POST["pcode"]);
      }
      
      if (empty($_POST["city"])) {
      
      } else {
        $city = test_input($_POST["city"]);
      }
      
      if (empty($_POST["address"])) {
       
      } else {
        $address = test_input($_POST["address"]);
      }

      $usernameclean = ltrim($username0);
      $usernameclean = rtrim($usernameclean);

      include('db_config.php');
      
      $result = $connection->query("SELECT * FROM users WHERE username = '$usernameclean' OR email = '$email' EXCEPT SELECT * FROM users WHERE username = '$usernamedb' OR email = '$emaildb'");
      if($result->num_rows == 0) {
      } else {
            $emailErr     .= "Already taken bro.";
            $usernameErr  .= "This username is already taken bro.";
      }
      $connection->close();

      if(empty($usernameErr) && empty($nameErr) && empty($emailErr) && empty($activeErr) && empty($passwordErr)) {
      
        include('db_config.php');

        $sql = "UPDATE `users` SET `name` = '$name' , `email` = '$email', `username` ='$usernameclean', `password` = '$password',
          `avatar` = '$avatar', `active` = '$active', 
          `permission` = '$permission', `country`  = '$country', `pcode` = '$pcode',  `city`  = '$city', `address`  = '$address'   
          WHERE `id` = '$member'";
          var_dump($result = $connection->query($sql));
        if (!$result = $connection->query($sql)) {
            echo "Sorry, the website is experiencing problems.";
           var_dump( $connection->error);
            exit;
        }
        $connection->close();
      }else{
        var_dump($usernameErr,$nameErr,$emailErr,$passwordErr,$activeErr);
        var_dump($password);
      }
      }
      
      function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
      }

?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<form class='form-group' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col">
      <label >Username</label><span class="error">  * <?php echo $usernameErr;?></span>
      <input type="text" class="form-control" name="username" value="" placeholder=<?php echo $usernamedb;?>>
      
      <br><br>

      <label >Name</label><span class="error">  * <?php echo $nameErr;?></span>
      <input type="text" class="form-control" name="name" value="" placeholder=<?php echo $namedb;?>>
      <br><br>

      <label >Email</label><span class="error">  * <?php echo $emailErr;?></span>
      <input type="text" class="form-control" name="email" value=""  placeholder=<?php echo $emaildb;?>>
      <br><br>

      <label >Password</label><span class="error">  * <?php echo $passwordErr;?></span>
      <input type="text" class="form-control" name="password" value="" placeholder=<?php echo $pwdb;?>>
      <br><br>

      <label >Conf password</label><span class="error"> * <?php echo $cpasswordErr;?></span>
      <input type="text" class="form-control" name="cpassword" value="" placeholder=<?php echo $pwdb;?>>
      <br><br>

      <label >Active:</label><span class="error"> * <?php echo $activeErr;?></span><br>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="active" id="option1"  <?php if (isset($active) && $active=="yes") echo "checked";?> value = "yes"> Yes
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="active" id="option2"  <?php if (isset($active) && $active=="no") echo "checked";?> value = "no"> No
        </label>
      </div>
      <br><br>

        <label >Permission:</label><span class="error"></span><br>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="permission" <?php if (isset($add) && $add=="add") echo "checked";?> value="add">Add
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="permission" <?php if (isset($edit) && $edit=="edit") echo "checked";?> value="edit">Edit
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="permission" <?php if (isset($delete) && $delete=="delete") echo "checked";?> value="delete">Delete
        </label>
      </div>
      <br><br>
    </div>
    <div class="col">
      <label for="country">Country</label>      
                <select id="country" name="country" class="form-control">
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Åland Islands">Åland Islands</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Territories">French Southern Territories</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernsey">Guernsey</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-bissau">Guinea-bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary" selected>Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Isle of Man">Isle of Man</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jersey">Jersey</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                    <option value="Korea, Republic of">Korea, Republic of</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macao">Macao</option>
                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montenegro">Montenegro</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn">Pitcairn</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Helena">Saint Helena</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-leste">Timor-leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Viet Nam">Viet Nam</option>
                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                    <option value="Western Sahara">Western Sahara</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
      <br><br>

      <label >Post code:</label>  
      <input type="text" class="form-control" name="pcode" value="" placeholder=<?php echo $pcode;?>>
      <br><br>

      <label >City</label>  
      <input type="text" class="form-control" name="city" value="" placeholder=<?php echo $city;?>>
      <br><br>

      <label >Address</label>  
      <input type="text" class="form-control" name="address" value="" placeholder=<?php echo $address;?>>
      <br><br>

      <label >Upload avatar: \\ <?php echo $avatar;?></label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" name = "image" id="inputGroupFile04" >
          <label class="custom-file-label" for="inputGroupFile04"></label>
        </div>
      </div>
      <br><br>

      <div class="text-center">
        <img src="profile.png" class="rounded" alt="...">
      </div>
    </div>  
  </div>
  <input type="submit" name="submit" class="btn btn-dark modibutton" value="Submit"> 
  <a href="index.php" class="badge badge-dark linkBack">Back</a>
</form>
</body>
</html>