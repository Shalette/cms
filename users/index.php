<?php

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
if(strlen($_SESSION['login'])!=0)

{

header('location:dashboard.php');

}

if(strlen($_SESSION['alogin'])!=0)
	{
header('location:../admin/notprocess-complaint.php');
}
error_reporting(0);
include("includes/config.php");

if(isset($_POST['submit']))

{

$ret=mysqli_query($con,"SELECT * FROM users WHERE userEmail='".$_POST['username']."' and password='".md5($_POST['password'])."' and status=1");

$num=mysqli_fetch_array($ret);

if($num>0)

{

$extra="dashboard.php";//

$_SESSION['login']=$_POST['username'];

$_SESSION['id']=$num['id'];

$_SESSION['number']=$num['contactNo'];
$host=$_SERVER['HTTP_HOST'];

$uip=$_SERVER['REMOTE_ADDR'];

$status=1;

$log=mysqli_query($con,"insert into userlog(uid,username,userip,status) values('".$_SESSION['id']."','".$_SESSION['login']."','$uip','$status')");

$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');

header("location:http://$host$uri/$extra");

exit();

}

else

{

  $_SESSION['login']=$_POST['username'];
  $uip=$_SERVER['REMOTE_ADDR'];
  $status=0;
$ret=mysqli_query($con,"SELECT * FROM users WHERE userEmail='".$_POST['username']."' and password='".md5($_POST['password'])."' and status=0");
$num=mysqli_fetch_array($ret);
if($num>0)
{
  mysqli_query($con,"insert into userlog(username,userip,status) values('".$_SESSION['login']."','$uip','$status')");
  $msg="Check confirmation email";
}
else
{
mysqli_query($con,"insert into userlog(username,userip,status) values('".$_SESSION['login']."','$uip','$status')");

$errormsg="Invalid username or password";

}

unset($_SESSION['login']);
}

}


if(isset($_POST['change']))

{

   $email=$_POST['email'];

    $contact=$_POST['contact'];

    $password=md5($_POST['password']);

$query=mysqli_query($con,"SELECT * FROM users WHERE userEmail='$email' and contactNo='$contact'");

$num=mysqli_fetch_array($query);

if($num>0)

{

$confirmcode=rand();
$query=mysqli_query($con,"update users set confirmcode='$confirmcode' WHERE userEmail='$email'");
$extra="change.php?email=".$email."&code=".$password."&confirmcode=".$confirmcode;
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
$link="http://$host$uri/$extra";

	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = '';                 // SMTP username
	    $mail->Password = '';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to
			$mail->SMTPOptions = array(
	             'ssl' => array(
	                 'verify_peer' => false,
	                 'verify_peer_name' => false,
	                 'allow_self_signed' => true
	             )
	         );
	    //Recipients
	    $mail->setFrom('', 'BMSIT CMS');
	    $mail->addAddress($email, $fullname);     // Add a recipient             // Name is optional
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Password Change';
	    $mail->Body    = $fullname.', to confirm change of password, click the following link:<br>'.$link.'<br><br>Remember to sign in with your new password.<br>Kindly delete this message if it was not intended for you.';
	    $mail->send();
			$msg="Reset Email Sent. Password will be updated on confirmation.";
	} catch (Exception $e) {
	    $errormsg= 'Message could not be sent. Error: '.$mail->ErrorInfo;
	}
}
else

{

$errormsg="Invalid Email ID or Contact Number";

}

}

?>



<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BMSIT CMS | User Login</title>

		<link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <!-- Bootstrap core CSS -->

		<?php include('includes/additional.php') ?>
  </head>

  <body style="background: url('../img/bg.jpg')  no-repeat; background-size:cover;">

  <div style="height: 90%">
		<nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

          </button>

					<a href="../../cms"  class="navbar-brand">BMSIT & M</a>

        </div>

        <div class="collapse navbar-collapse" id="myNavbar">

          <ul class="nav navbar-nav navbar-right">

            <li><a href="registration.php" title="Register"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Register </a></li>

            <li><a href="../admin/" title="Admin Only"><i class="fa fa-user-circle"></i>&nbsp;&nbsp;Admin Login</a></li>

          </ul>

        </div>

      </div>

    </nav>

	  <div id="login-page" style="padding-top: 12rem; height: 85%">

	  	<div class="container">

        <div class="row">

      		<div class="col-md-offset-3 col-md-6 col-xs-12">

		      	<form class="panel panel-info" name="login" method="post">

            	<div class="panel-heading text-center">

              	<h3><b>Sign In Now</b></h3>

            	</div>

		        	<p style="padding-left:4%; padding-top:2%;  color:red">

		        	<?php if($errormsg){

							echo htmlentities($errormsg);

									        		}?></p>

							<p style="padding-left:4%; padding-top:2%;  color:green">

		        	<?php if($msg){

							echo htmlentities($msg);

		        	}?></p>

		        	<div class="login-wrap">

		            <input type="text" class="form-control" name="username" placeholder="Email ID"  required autofocus>

		            <br>

		            <input type="password" class="form-control" name="password" required placeholder="Password">

		            <label class="checkbox">

									<span class="pull-right">

										<a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>

									</span>

		            </label>

		            <button class="btn btn-theme btn-block" name="submit" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>

		            <br>

		            <div class="registration">
Don't have an account yet?<br>

		            	<a class="" href="registration.php">
Create an account
</a>

		            </div>

		        	</div>

						</form>


		          <!-- Modal -->

		        <form class="form-login" name="forgot" method="post">

		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">

		          	<div class="modal-dialog">

		            	<div class="modal-content">

		              	<div class="modal-header">

         							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		                  <h4 class="modal-title">Forgot Password ?</h4>

		                </div>

		                <div class="modal-body">

											<p>Enter your details below to reset your password.</p>

											<input type="email" name="email" placeholder="Email" autocomplete="off" class="form-control" required oninvalid="this.setCustomValidity('Enter Valid Email')" oninput="this.setCustomValidity('')">
											<br>

											<input type="text" name="contact" placeholder="Contact Number" autocomplete="off" class="form-control" maxlength="10" pattern="[6-9]([0-9]{9})"required oninvalid="this.setCustomValidity('Enter Valid Mobile Number')" oninput="this.setCustomValidity('')">
											<br>

											<input type="password" class="form-control" placeholder="New Password (Minimum 6 Characters)" id="password" name="password" pattern=".{6,}" required>
											<br>

											<input type="password" class="form-control unicase-form-control text-input" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required >

										</div>

		                <div class="modal-footer">

		                	<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>

		                	<button class="btn btn-theme" type="submit" name="change" onclick="return valid();">Submit</button>

		              	</div>

		            	</div>

								</div>

							</div>

						</form>

					</div>
				</div>

	  	</div>

	  </div>

	</div>
	  <?php include("includes/footer.php");?>
		<?php include("includes/scripts.php") ?>
		<script>
		function valid()
		{
		 if(document.forgot.password.value!= document.forgot.confirmpassword.value)
		{
		alert("Password and Confirm Password fields do not match.");
		document.forgot.confirmpassword.focus();
		return false;
		}
		return true;
		}
		if (window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href.split("?")[0] );
		    }
		</script>
  </body>

</html>

