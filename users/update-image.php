<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{
error_reporting(0);
if(isset($_POST['submit']))
{
if($_FILES['image']['error'] == 'UPLOAD_ERR_OK'){
$imgfile=$_FILES["image"]["name"];

// get the image extension
$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");

// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
 if($extension=="jpeg")
 $extension=".jpeg";
$imgnewfile=md5($imgfile).$extension;
// Code for move image into directory
move_uploaded_file($_FILES["image"]["tmp_name"],"userimages/".$imgnewfile) or die("Not Working");
$query=mysqli_query($con,"select * from users where userEmail='".$_SESSION['login']."'");
$num=mysqli_fetch_array($query);
if($num['userImage']!='noimage.png')
unlink('userimages/'.$num['userImage']);
$query=mysqli_query($con,"update users set userImage='$imgnewfile', updationDate=CURRENT_TIMESTAMP where userEmail='".$_SESSION['login']."'");
if($query)
{
$successmsg="Profile photo updated successfully.";
}
else
{
$errormsg="Profile photo not updated.";
}
}
}
else{
 echo "<script>alert('File size should be a maximum of 1MB.');</script>";
}

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | Update Profile Image</title>
    <link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <!-- Bootstrap core CSS -->
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container">
    <?php include("includes/header.php");?>
    <?php include("includes/sidebar.php");?>
      <section id="main-content">
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i>&nbsp;Update  Profile Photo</h3>
          <!-- BASIC FORM ELEMENTS -->
          <div class="form-panel">
            <?php if($successmsg)
            {?>
            <div class="alert alert-success alert-dismissable">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($successmsg);?></div>
            <?php }
            if($errormsg)
            {?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($errormsg);?></div>
            <?php }?>
            <?php $query=mysqli_query($con,"select * from users where userEmail='".$_SESSION['login']."'");
            while($row=mysqli_fetch_array($query))
            {
            ?>
            <h4 class="mb"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo htmlentities($row['fullName']);?>'s Profile</h4>
            <form class="form-horizontal style-form" enctype="multipart/form-data"  method="post" name="profile" >
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">User Photo</label>
                <div class="col-sm-4">
                  <?php $userphoto=$row['userImage'];
                  if($userphoto==""):
                  ?>
                  <img class="img-rounded" src="userimages/noimage.png" width="242" height="256" >
                  <?php else:?>
                  <img class="img-rounded" src="userimages/<?php echo htmlentities($userphoto);?>" width="242" height="256">
                  <?php endif;?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Upload New Photo</label>
                <div class="col-sm-4">
                  <input type="file" name="image" class="form-control"required />
                </div>
              </div>
              <?php } ?>
              <div class="form-group">
                <div class="col-sm-10" style="padding-left:18% ">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </section>
        <?php include("includes/footer.php");?>
      </section>
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <?php include('includes/scripts.php') ?>
  </body>
</html>
<?php } ?>
