<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include database file
require_once "database.php";
 
// Define variables and initialize with empty values
$email = $username = $password = "";
$email_err = $username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
	
	/*
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    */
		
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, email, username, password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $email, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
							$_SESSION["email"] = $email;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome - RafAlbums</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="css/gallerystyle.css" rel="stylesheet">	
	<link href="css/switchslider.css" rel="stylesheet">	
	<link href="css/inputrange.css" rel="stylesheet">	
	<link href="css/changingbg.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/simplelightbox.css" rel="stylesheet" type="text/css">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" type="text/javascript"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-3.0.0.js"><\/script>')</script>	
		
	<script src="js/bootstrap.bundle.js"></script>			
	
	<script src="js/simple-lightbox.js" type="text/javascript" ></script>		
	<script src="js/thumbnail.js" type='text/javascript'></script>

	<!--
	<script src='js/parallaxbackground.js' type='text/javascript'></script> 	
	<script src='js/parallax.min.js' type='text/javascript'></script> 
	-->

  	<style>	
	</style>
</head>

<body>

<?php include 'header.php' ?>

<main role="main">

<section class="transparentbg ">
	<div class="container">
		<div class="formdiv text-center">
			<div class="row btn-group btn-group-lg" style="width: 100%">
				<div class="col-xs-0 col-sm-1 col-md-2 col-lg-3">
				</div>
				<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">				
					<h2>Login</h2>
					<p>Please fill in your credentials to login.</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Email</label>
							-->
							<input type="email" name="email" class="inputfield form-control" value="<?php echo $email; ?>" placeholder="Email">
							<span class="help-block"><?php echo $email_err; ?></span>
						</div>
						<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Password</label>
							-->
							<input type="password" name="password" class="inputfield password form-control" placeholder="Password">
							<span class="help-block"><?php echo $password_err; ?></span>
						</div>
						<div class="form-group ">							
							<button type="button" class="btn btn-sm btn-outline-dark" style="border-radius: 0 !important;" onclick="showPassword()"><i class="fa fa-eye" aria-hidden="true"></i> Show Password</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn noborder widthfull btn-primary" ><i class="fa fa-pencil" aria-hidden="true"></i> Log in</button>
							<button type="reset" class="btn noborder widthfull btn-warning" ><i class="fa fa-times" aria-hidden="true"></i> Reset</button>
						</div>
						<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
	
<div class="bottomdiv">
</div>

</main>

<script>
function showPassword() {
	var x = document.getElementsByClassName("password");
	for(var i = 0, length = x.length; i < length; i++) {
		if (x[i].type === "password") {
			x[i].type = "text";
		} else {
			x[i].type = "password";
		}
    }  
}
</script>

<?php include 'footer.php' ?>

</body>
</html>