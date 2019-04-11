<?php
session_start();
error_reporting(0);
include('includes/config.php');
$email = $_GET['email'];
$confirmcode = $_GET['confirmcode'];
$id=$_GET['id'];
$query ="select * from users where id='$id'";
$data =mysqli_query($con, $query) or die(mysqli_error($con));
$row=mysqli_fetch_array($data);
if($row['confirmcode']==$confirmcode)
{
mysqli_query($con,"update users set userEmail='$email', updationDate=CURRENT_TIMESTAMP  WHERE id='$id'");
$confirm= rand();
$query1 = "update users set confirmcode=$confirm where userEmail='$email'";
$submit1 = mysqli_query($con, $query1) or die($con);
header('location: index.php');
}
else{
  header('location: ..');
}
