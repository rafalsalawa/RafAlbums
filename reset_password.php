<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
 
// Include database file
require_once "database.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } elseif(strlen(trim($_POST["new_password"])) > 250){
        $new_password_err = "Password must have maximum 250 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["user_id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome - RafAlbums</title>
	
	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
	<link rel="manifest" href="site.webmanifest">
	<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	
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
					<h2>Reset Password</h2>
					<p>Please fill out this form to reset your password.</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
						<div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>New password</label>
							-->
							<input type="password" name="new_password" class="inputfield password form-control" value="<?php echo $new_password; ?>" placeholder="New password">
							<span class="help-block"><?php echo $new_password_err; ?></span>
						</div>
						<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
							<!--
							<label>Confirm new password</label>
							-->
							<input type="password" name="confirm_password" class="inputfield password form-control" placeholder="Confirm new password">
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div>
						<div class="form-group ">							
							<button type="button" class="btn btn-sm btn-outline-dark" style="border-radius: 0 !important;" onclick="showPassword()"><i class="fa fa-eye" aria-hidden="true"></i> Show Password</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn noborder widthfull btn-primary" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change password</button>
							<a href="index.php" class="btn noborder widthfull btn-warning" ><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
						</div>
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