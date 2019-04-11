<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
$sql=mysqli_query($con,"SELECT password FROM  users where password='".md5($_POST['password'])."' && userEmail='".$_SESSION['login']."'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
$con=mysqli_query($con,"update users set password='".md5($_POST['newpassword'])."', updationDate=CURRENT_TIMESTAMP where userEmail='".$_SESSION['login']."'");
$successmsg="Password changed successfully.";
}
else
{
$errormsg="Old password is incorrect.";
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | Change Password</title>
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container">
      <?php include("includes/header.php");?>
      <?php include("includes/sidebar.php");?>
      <section id="main-content">
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i>&nbsp;Change Password</h3>
          <!-- BASIC FORM ELEMENTS -->
          <div class="row mt">
          	<div class="col-lg-12">
              <div class="form-panel">
                <h4 class="mb"><i class="fa fa-angle-right"></i> User Change Password</h4>
                <?php if($successmsg)
                {?>
                <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <?php echo htmlentities($successmsg);?>
                </div>
                <?php }
                if($errormsg)
                { ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo htmlentities($errormsg);?>
                </div>
                <?php }?>
                <form class="form-horizontal style-form" method="post" name="chngpwd" onSubmit="return valid();">
                  <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Current Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" required="required" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">New Password (Minimum 6 Characters)</label>
                    <div class="col-sm-10">
                      <input type="password" name="newpassword" pattern=".{6,}" required="required" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="confirmpassword" required="required" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-10" style="padding-left:5rem">
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
        <?php include("includes/footer.php");?>
      </section><!-- /MAIN CONTENT -->
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <?php include('includes/scripts.php') ?>
    <!--script for this page-->
    <script>
    function valid()
    {
    if(document.chngpwd.password.value=="")
    {
    alert("Current Password field is empty.");
    document.chngpwd.password.focus();
    return false;
    }
    else if(document.chngpwd.newpassword.value=="")
    {
    alert("New Password field is empty.");
    document.chngpwd.newpassword.focus();
    return false;
    }
    else if(document.chngpwd.confirmpassword.value=="")
    {
    alert("Confirm Password field is empty.");
    document.chngpwd.confirmpassword.focus();
    return false;
    }
    else if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
    {
    alert("Password and Confirm Password fields do not match.");
    document.chngpwd.confirmpassword.focus();
    return false;
    }
    else if(document.chngpwd.password.value== document.chngpwd.newpassword.value)
    {
    alert("Current Password and New Password fields should not match.");
    document.chngpwd.confirmpassword.focus();
    return false;
    }
    return true;
    }
    </script>
  </body>
</html>
<?php } ?>
