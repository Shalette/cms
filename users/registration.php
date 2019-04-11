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

include('includes/config.php');
if(isset($_POST['submit']))
{
	$fullname=mysqli_real_escape_string($con,$_POST['fullname']);
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$password=mysqli_real_escape_string($con, md5($_POST['password']));
	$contactno=mysqli_real_escape_string($con,$_POST['contactno']);
	if($_POST['hostel']==1)
	$gender="Female";
	else
	$gender="Male";
	if(isset($_POST['block']))
	$block=mysqli_real_escape_string($con, $_POST['block']);
	else
	$block="G";
	$roomno=mysqli_real_escape_string($con,$_POST['roomno']);
	$status=0;
  $confirmcode=rand(100000, 999999);
  $query=mysqli_query($con,"insert into users(fullName,userEmail,password,contactNo, block, hostel, roomNo, status, confirmcode) values('$fullname','$email','$password','$contactno', '$block','$gender', '$roomno', '$status', '$confirmcode')") or die(mysqli_error($con));
	$extra="validate.php?email=".$email."&confirmcode=".$confirmcode;
	$host=$_SERVER['HTTP_HOST'];
	$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
	$link="http://$host$uri/$extra";
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'DoNotReplyBmsit@gmail.com';                 // SMTP username
	    $mail->Password = 'Test@123';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to
	    //Recipients
	    $mail->setFrom('DoNotReplyBmsit@gmail.com', 'BMSIT CMS');
	    $mail->addAddress($email, $fullname);     // Add a recipient             // Name is optional
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Confirmation of Registration';
	    $mail->Body    = 'Congratulations on creating an account! To confirm, click the following link:<br>'.$link;
	    $mail->send();
		}
	catch (Exception $e) {
	    $errormsg= 'Email could not be sent. Error: '.$mail->ErrorInfo;
	}
	$_SESSION['contact']=$contactno;
	$_SESSION['aim']="Reg";
	$number="91".$contactno;
	$message=$confirmcode;
		$ch = curl_init("http://login.smsgatewayhub.com/api/mt/SendSMS?APIKey=62sxGWT6MkCjDul6eNKejw&senderid=BMSITM&channel=2&DCS=0&flashsms=0&number=$number&text=$message&route=1;");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
	if($data){
	$msg="Registration Successful. A Confirmation Email and OTP will be sent to you shortly.";
	echo "<script>setTimeout(function() {
			window.location.href = 'otp-confirm.php';
		}, 1000);
		</script>";

	}

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | User Registration</title>
		<link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
		<?php include('includes/additional.php') ?>
  </head>
	<body style="background: url('../img/bg.jpg') no-repeat; background-size:cover;">
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
            <li><a href="../users" title="Sign In"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Sign In </a></li>
            <li><a href="../admin" title="Admin Only"><i class="fa fa-user-circle"></i>&nbsp;&nbsp;Admin Login</a></li>
          </ul>
        </div>
			</div>
		</nav>
		<div id="login-page" style="padding-top: 12rem;  height: 90%">
	  	<div class="container">
				<div class="row">
					<div class="col-md-offset-3 col-md-6 col-xs-12">
		      	<form class="panel panel-info" name="register" method="post">
            	<div class="panel-heading text-center">
              	<h3><b>User Registration</b></h3>
            	</div>
		        	<p style="padding-left: 1%; color: green">
		        	<?php if($msg){
							echo htmlentities($msg); }?> </p>
		        	<div class="login-wrap">
			         	<input type="text" class="form-control" placeholder="Full Name (No Special Characters)" name="fullname" pattern="[A-Z][A-Za-z\s]{1,}"required="required" autofocus oninvalid="this.setCustomValidity('Enter Valid Name')" oninput="this.setCustomValidity('')">
			          <br>
			          <input type="email" class="form-control" placeholder="Email ID" id="email" onBlur="userAvailability()" name="email" required="required" oninvalid="this.setCustomValidity('Enter Valid Email')" oninput="this.setCustomValidity('')">
								<br>
			          <input type="text" class="form-control" maxlength="10" name="contactno" id="contact" onBlur="userAvailability()" placeholder="Contact Number" required="required" pattern="[6-9]([0-9]{9})" oninvalid="this.setCustomValidity('Enter Valid Mobile Number')" oninput="this.setCustomValidity('')"autofocus>
			          <br>
								<select name="hostel" id='gender' class="form-control" onChange="getBlock(this.value)" required>
									<option value="" hidden selected disabled>Gender</option>
									<?php $query=mysqli_query($con,"select * from hostel");
									while($row=mysqli_fetch_array($query))
									{?>
									<option value="<?php echo $row['id'];?>"><?php if ($row['hname'] == "Girl's Hostel") echo 'Female'; else echo 'Male';?></option>
									<?php } ?>
								</select>
								<br>
								<span id='block'></span>
								<input type='text' class='form-control' placeholder="Room Number" maxlength="3" required name="roomno" oninvalid="this.setCustomValidity('Enter Valid Room Number')" oninput="this.setCustomValidity('')">
								<br>
								<input type="password" class="form-control" placeholder="Password (Minimum 6 characters)" pattern=".{6,}" required="required" name="password"><br>
								<span id="user-availability-status1" style="font-size:12px;"></span>
		            <button class="btn btn-theme btn-block"  type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
		            <br>
		            <div class="registration">Already Registered<br>
		              <a class="" href="index.php">Sign in</a>
		            </div>
		        	</div>
		      	</form>
	  			</div>
	  		</div>
			</div>
		</div>
	</div>
		<?php include("includes/footer.php");?>
    <!-- js placed at the end of the document so the pages load faster -->
		<?php include('includes/scripts.php') ?>
		<script>
			function userAvailability()
			{
			jQuery.ajax({
			url: "check_availability.php",
			data:{email: $("#email").val(), contact:
			$("#contact").val()},
			type: "POST",
			success:function(data){
			$("#user-availability-status1").html(data);
			},
			error:function(){}
			});
			}

			function getBlock(val){
			jQuery.ajax({
			url: "getsubcat.php",
			data:"gender="+val,
			type: "POST",
			success:function(data){
			$("#block").html(data);
			},
			error:function (){}

			});
			}
		</script>
  </body>
</html>
