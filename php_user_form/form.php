<?php
  // echo "hello world php";
  $name = $website = $email = $comment = $gender = "";
  $name_error = $website_error = $email_error = "";

  //function to strip text
  function text_strip($x){
    $x = trim($x);
    $x = stripslashes($x);
    $x = htmlspecialchars($x);  //this sterilises any code inserted through the form input boxes
    return $x;
  }

  //if post method is used on the website, process form data
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //strip and then assign each form entry
    $stripped_name = text_strip($_POST["input_name"]);
    $stripped_email = text_strip($_POST["input_email"]);
    $stripped_website = text_strip($_POST["input_website"]);
    $stripped_gender = text_strip($_POST["input_gender"]);
    $stripped_comment = text_strip($_POST["input_comment"]);
  
    //then validate the content of each box
    if(empty($stripped_name)){ //Name
      $name_error = "please enter a name"; 
    }
    elseif(!preg_match("/^[a-zA-Z-' ]*$/", $stripped_name)){
      $name_error = "please enter only letter and spaces";
    }
    else{
      $name = $stripped_name;
    }
    
    if(empty($stripped_email)){ //Email
      $email_error = "please enter an email";
    }
    elseif(!filter_var($stripped_email, FILTER_VALIDATE_EMAIL)){
      $email_error = "please enter a valid email address";
    }
    else{
      $email = $stripped_email;
    }

    if(empty($stripped_website)){  //Website
      $website = "";
    }
    elseif(!preg_match("/\b(?:(?:https?|ftp):\/\/|\.)".  // took out "www" from validation as many sites don't use
    "[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$stripped_website)){
      $website_error = "Please enter a valid website address";
    }
    else{
      $website = $stripped_website;
    }

    if(!empty($stripped_comment)){  //Comment
      $comment = $stripped_comment;
    }

    if(empty($stripped_gender)) {  //Gender    //(maybe there doesn't need to be an error for gender)
      $gender = "";
    }else{
      $gender = $stripped_gender;
    }
    
    // write final thank you message if no errors found>
    if (empty($name_error) and empty($email_error) and empty($website_error)){
      echo "<p align='center' class='thanks'> thanks, we'll get back to you asap </p>";
      // echo "<p> name:$name email:$email url:$website _ $gender comment:$comment </p>"; //print variables for bugs
      // echo "<p>$name_error $email_error $website_error</p>";
    }

  }
?>


<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="styles.css?v=1">
  </head>
<body>
    
  <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <p class="title"> get in contact </p>

    <p><span class="label">name:</span> <!-- Name -->
    <input type="text" class="input" name="input_name" value="<?php echo $name ?>"> </p>
    <p class="error"><?php echo $name_error; ?> </p>
    <br>

    <p><span class="label">email:</span> <!-- Email -->
    <input type="text" class="input" name="input_email" value="<?php echo $email ?>"></p>
    <p class="error"> <?php echo $email_error; ?> </p>
    <br>

    <p><span class="label">website:</span> <!-- Website -->
    <input type="text" class="input" name="input_website" value="<?php echo $website ?>"></p>
    <p class="error"> <?php echo $website_error; ?> </p>
    <br>

    <p class="title">gender</p>  <!-- Gender -->
    <p><span class="label">male</span><input class="input" type="radio" name="input_gender" 
    class="male" value="male" <?php if(isset($gender) and $gender=="male") echo "checked"; ?> ></p>

    <p><span class="label">female</span><input class="input" type="radio" name="input_gender" 
    class="female" value="female" <?php if(isset($gender) and $gender=="female") echo "checked"; ?> ></p>

    <p><span class="label">other</span><input class="input" type="radio" name="input_gender" 
    class="other" value="other" <?php if(isset($gender) and $gender=="other") echo "checked"; ?> ></p>

    <!-- <p class="error"> <?php echo $gender_error; ?> </p> -->
    <br>

    <p><span class="label">comment:</span> <!-- Comment -->
    <textarea name="input_comment" value="" rows=6> <?php echo $comment; ?> </textarea>
    </p>
    <br>
    
    <input type="submit" name="Submit" value="submit"> <!-- Submit -->

  </form>


</body>
</html>

