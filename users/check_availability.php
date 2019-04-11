<?php
require_once("includes/config.php");
if(!empty($_POST["email"]) || !empty($_POST["contact"])){
	$email= $_POST["email"];
	$contact=$_POST["contact"];
		$result =mysqli_query($con,"SELECT * FROM users WHERE userEmail='$email' or contactNo='$contact'");
		$count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red'>User already exists.</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	echo "<span style='color:green'>User available for registration.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}

?>
