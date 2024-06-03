<?php
session_start();
$msg = "";

//check whether session variable 'user_id' is set
//in other words, check whether the user is already logged in
if (isset($_SESSION['userId'])) {
    $msg = "You are already logged in.";
} else { //user is not logged in
    //check whether form input 'username' contains value
    if (isset($_POST['username'])) {

        //retrieve form data
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];
        $entered_email = $_POST['email'];
        
        
        
        //connect to database
        include ("dbFunctions.php");

        //match the username and password entered with database record
           $query = "SELECT id, username, password, email FROM users 
                  WHERE username='$entered_username' AND 
                  password = SHA1('$entered_password') AND
                  email = '$entered_email'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        //if record is found, store id and username into session
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            
            
            $msg = "<p><i>You are logged in as " . $_SESSION['username'] . "</p>"; 
            $msg .= "<p><a href='home.php'>Home</a></p>";

            
            header("location: Register.php");
        } else { //record not found
            $msg = "Sorry, you must enter a valid username 
                    and password to log in.";
        }
    } 
}
?>