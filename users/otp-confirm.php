<?php
session_start();
if(strlen($_SESSION['alogin'])!=0)
{
header('location:../admin/notprocess-complaint.php');
}
if(!isset($_SESSION['aim']))
{
header('location:../');
}
error_reporting(0);
include("includes/config.php");

if(isset($_POST['submit']))
{
  $otp=mysqli_real_escape_string($con,$_POST['otp']);
  if($_SESSION['aim']=="Reg")
    $contact=$_SESSION['contact'];
  else
    $contact=$_SESSION['number'];

  $query=mysqli_query($con,"select * from users where contactNo='".$contact."'");
  $row=mysqli_fetch_array($query);
  if($row['confirmcode']==$otp){
    if($_SESSION['aim']=="Reg")
    {
      $query = "update users set status=1 where contactNo=".$_SESSION['contact']." and confirmcode=$otp";
      $submit = mysqli_query($con, $query) or die($con);
      $confirm= rand(100000, 999999);
      $query1 = "update users set confirmcode=$confirm where contactNo=".$_SESSION['contact'];
      $submit1 = mysqli_query($con, $query1) or die($con);
      $_SESSION['login']=$row['userEmail'];
      $_SESSION['id']=$row['id'];
      $_SESSION['number']=$row['contactNo'];
      unset($_SESSION['contact']);
      unset($_SESSION['aim']);
      $msg="Registration Confirmed.";
      echo "<script>setTimeout(function() {
          window.location.href = 'index.php';
        }, 2000);
        </script>";
    }
    else if($_SESSION['aim']=="Reset"){
      $query=mysqli_query($con,"update users set contactNo=".$_SESSION['replace'].", updationDate=CURRENT_TIMESTAMP where userEmail='".$_SESSION['login']."'") or die(mysqli_error($con));
      $confirm= rand(100000, 999999);
      $query1 = "update users set confirmcode=$confirm where userEmail='".$_SESSION['login']."'";
      $submit1 = mysqli_query($con, $query1) or die($con);
      $_SESSION['number']=$_SESSION['replace'];
      unset($_SESSION['replace']);
      unset($_SESSION['aim']);
        $msg="Registration Confirmed. You will be redirected shortly.";
        echo "<script>setTimeout(function() {
            window.location.href = 'dashboard.php';
          }, 2000);
          </script>";
      }
}
  else{
      $errormsg="Invalid OTP";
  }
}

?>
<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BMSIT CMS | OTP Verification</title>

		<link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <!-- Bootstrap core CSS -->

		<?php include('includes/additional.php') ?>
  </head>

  <body style="background: url('../img/bg.jpg')  no-repeat; background-size:cover;">

  <div style="min-height: 90%">
		<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
					<a href="../../cms"  class="navbar-brand">BMSIT & M</a>
        </div>
    </nav>

	  <div id="login-page" style="padding-top: 12rem; height: 85%">

	  	<div class="container">

        <div class="row">

      		<div class="col-md-offset-3 col-md-6 col-xs-12">

		      	<form class="panel panel-info" name="login" method="post">

            	<div class="panel-heading text-center">

              	<h3><b>Account Verification Via OTP </b></h3>

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
		            <input type="text" class="form-control" name="otp" pattern="\d{6}" max-length="6" placeholder="6 Digit OTP"  required>
		            <br>
		            <button class="btn btn-theme btn-block" name="submit" type="submit"><i class="fa fa-lock"></i> VERIFY</button>
		            <br>
		            </div>
						</form>
					</div>
				</div>

	  	</div>

	  </div>

	</div>
	  <?php include("includes/footer.php");?>
		<?php include("includes/scripts.php") ?>
  </body>

</html>
