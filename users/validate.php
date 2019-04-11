<?php include('includes/config.php');
session_start();
$email = $_GET['email'];
$confirmcode = $_GET['confirmcode'];
$query ="select * from users where userEmail='$email'";
$data =mysqli_query($con, $query ) or die(mysqli_error($con));
$row=mysqli_fetch_array($data);
if($row['confirmcode']==$confirmcode){

$query = "update users set status=1 where userEmail='$email' and confirmcode=$confirmcode";
$submit = mysqli_query($con, $query) or die($con);
$confirm= rand(100000, 999999);
$query1 = "update users set confirmcode=$confirm where userEmail='$email'";
$submit1 = mysqli_query($con, $query1) or die($con);
$_SESSION['login']=$email;
$_SESSION['id']=$row['id'];

$ret=mysqli_query($con,"SELECT * FROM users WHERE userEmail=".$email);
$num=mysqli_fetch_array($ret);
$_SESSION['number']=$num['contactNo'];
  header('location: index.php');
}
else{
    header('location: index.php');
}
?>
