<?php session_start();
error_reporting(0);
include('includes/config.php');
$email = $_GET['email'];
$confirmcode = $_GET['confirmcode'];
$password = $_GET['code'];
$query ="select * from users where userEmail='$email'";
$data =mysqli_query($con, $query) or die(mysqli_error($con));
$row=mysqli_fetch_array($data);
if($row['confirmcode']==$confirmcode)
{
mysqli_query($con,"update users set password='$password', updationDate=CURRENT_TIMESTAMP  WHERE userEmail='$email'");
$confirm= rand();
$query1 = "update users set confirmcode=$confirm where userEmail='$email'";
$submit1 = mysqli_query($con, $query1) or die($con);
header('location: index.php');
}
else{
  header('location: ..');
}
