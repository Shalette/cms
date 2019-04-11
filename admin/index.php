<?php
session_start();
if(strlen($_SESSION['alogin'])!=0)
	{
header('location:notprocess-complaint.php');
}
if(strlen($_SESSION['login'])!=0)
{
header('location:../users/dashboard.php');
}
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);
$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($ret);
$extra="index.php";
if($num>0)
{
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/");
exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CMS | Admin Login</title>
	<link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
	<link href="bootstrap/css/style.css" rel="stylesheet">
	<link href="bootstrap/css/style-responsive.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<script>if ( window.history.replaceState ) {
	        window.history.replaceState( null, null, window.location.href );
	    }</script>
</head>
<body style="background: rgba(212,228,239,1) linear-gradient(to bottom, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%) fixed;">
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<a href="#"  class="navbar-brand"><i class="fa fa-user-circle"></i>&nbsp;&nbsp;Admin</a>
			<ul class="nav navbar-nav navbar-right pull-right" style="padding-right: 1rem; float: right">
				<li><a href="../../cms/">
				Back to Portal
				</a></li>
			</ul>
		</div>
	</nav>
		<div class="container" style="padding-top: 12rem;">
			<div class="row">
				<div class="col-md-offset-3 col-md-6 col-xs-12">
			      <form class="panel panel-info" name="login" method="post">
							<div class="panel-heading text-center">
	              <h3><b>Sign In</b></h3>
	            </div>
						<span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
						<div class="panel-body">
							<div class="form-group">
									<input class="form-control"type="text" id="inputEmail" name="username" placeholder="Username">
							</div>
							<div class="form-group">
						<input class="form-control" type="password" id="inputPassword" name="password" placeholder="Password">
							</div>
						<div class="form-group">
									<button type="submit" class="btn btn-info btn-block" name="submit">Login</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php include("include/footer.php");?>
</section>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
