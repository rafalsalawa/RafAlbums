<?php
// Include database file
require_once "database.php";
 
// Define variables and initialize with empty values
$email = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Validate email
	$emailcheck = trim($_POST["email"]);
    if(empty($emailcheck)){
        $email_err = "Please enter a email address.";
    } elseif(!preg_match ("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $emailcheck)) {
		$email_err = "Invalid email address.";
	} else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $emailcheck;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This username is already taken.";
                } else{
                    $email = $emailcheck;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
    // Validate username
	$usernamecheck = trim($_POST["username"]);
    if(empty($usernamecheck)){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        if (!preg_match ("/^[A-Za-z-' ]+$/", $usernamecheck) ) { 						
			$username_err = "Only alphabets, whitespace, - and ' are allowed.";        
		} else {  
			$username = $usernamecheck;  
		} 
	}	
	 
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } elseif(strlen(trim($_POST["password"])) > 250){
        $password_err = "Password must have maximum 250 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            
            // Set parameters
			$param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
					<h2>Sign Up</h2>
					<p>Please fill this form to create an account.</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Email</label>
							-->
							<input type="email" name="email" class="inputfield form-control" value="<?php echo $email; ?>" placeholder="Email">
							<span class="help-block"><?php echo $email_err; ?></span>
						</div>    
						<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Username</label>
							-->
							<input type="text" name="username" class="inputfield form-control" value="<?php echo $username; ?>" placeholder="Name">
							<span class="help-block"><?php echo $username_err; ?></span>
						</div>    
						<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Password</label>
							-->
							<input type="password" name="password" class="inputfield password form-control" value="<?php echo $password; ?>" placeholder="Password">
							<span class="help-block"><?php echo $password_err; ?></span>
						</div>
						<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Confirm Password</label>
							-->
							<input type="password" id="password" name="confirm_password" class="inputfield password form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm password">
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div>
						<div class="form-group ">							
							<button type="button" class="btn btn-sm btn-outline-dark" style="border-radius: 0 !important;" onclick="showPassword()"><i class="fa fa-eye" aria-hidden="true"></i> Show Password</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn noborder widthfullbtn-primary" ><i class="fa fa-pencil" aria-hidden="true"></i> Sign in</button>
							<button type="reset" class="btn noborder widthfullbtn-warning" ><i class="fa fa-times" aria-hidden="true"></i> Reset</button>
						</div>
						<p>Already have an account? <a href="login.php">Login here</a>.</p>
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