<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['login'])!=0)
{
header('location:users/dashboard.php');
}
if(strlen($_SESSION['alogin'])!=0)
{
header('location:admin/notprocess-complaint.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BMSIT Complaint Management System</title>
    <link rel="shortcut icon" type="image/png" href="img/tiny.png"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <style>
      html, body {
      max-width: 100%;
      overflow-x: hidden;
      height: 100%;
      overflow-y:auto;
      margin: 0;
      padding: 0;
      font-family: 'Montserrat', sans-serif;
      }
      a{
        color: inherit;
      }
      a:hover, a:active, a:focus{
        text-decoration: none;
      }
      .fa{
        font-size: 8rem;
      }
      .panel{
      box-shadow: 0px 6px 13px -2px rgba(0,0,0,0.68);
      transition-duration: 700ms;
      transition: all .2s ease-in-out;
      }
      .panel:hover{
        box-shadow: 0px 6px 50px -2px rgba(0,0,0,0.68);
        transform: scale(1.05);
      }
      footer{
        padding-top:3rem;
         bottom:0;
         width:100%;
         padding-bottom: 3rem;
      }
    </style>
</head>
<body style="background: url('img/bg.jpg') no-repeat; background-size:cover;">
  <div style="min-height:95%">
    <div class="jumbotron" style="background: none;">
      <div class="row text-center">
        <div class="col-xs-12">
            <img src="img/logo.png" style="height: 15rem;"/>
        </div>
        <div class="col-xs-12">
          <br>
            <h2 style="font-weight: bold">BMSIT&M</h2>
            <h3 style="font-weight: medium">Hostel Complaint Management System</h3>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-sm-push-4">
          <a href="users/">
            <div class="panel panel-info">
              <div class="panel-heading text-center"  style="height: 21rem;">
                <i class="fa fa-users"></i>
                <br><br><br>
                <h4 style="font-size: 25px;">User Login</h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-4 col-sm-pull-4">
          <a href="users/registration.php">
            <div class="panel panel-success">
              <div class="panel-heading text-center"  style="height: 21rem;">
                <i class="fa fa-user-plus"></i>
              <br><br><br>
                <h4 style="font-size: 25px;">User Registration</h4>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-4">
            <a href="admin/">
            <div class="panel"  style="color:#7234ba">
              <div class="panel-heading text-center"  style="height: 21rem;">
                <i class="fa fa-user-circle"></i>
                <br><br><br>
                <h4 style="font-size: 25px;">Admin</h4>
              </div>
            </div>
           </a>
        </div>
      </div>
    </div>
    <br><br>
  </div>
  <?php include('users/includes/footer.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="users/assets/js/common-scripts.js"></script>
</html>
