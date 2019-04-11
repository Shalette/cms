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
if($_FILES['compfile']['error'] == 'UPLOAD_ERR_OK' || $_FILES['compfile']['error'] == 4 ){
$uid=$_SESSION['id'];
$category=$_POST['category'];
$noc=$_POST['noc'];
$complaintdetails=$_POST['complaindetails'];
$compfile=$_FILES["compfile"]["name"];

move_uploaded_file($_FILES["compfile"]["tmp_name"],"complaintdocs/".$_FILES["compfile"]["name"]);
$query=mysqli_query($con,"insert into tblcomplaints(userId,category,noc,complaintDetails,complaintFile) values('$uid','$category','$noc','$complaintdetails','$compfile')");
// code for show complaint number
$sql=mysqli_query($con,"select complaintNumber from tblcomplaints order by complaintNumber desc limit 1");
while($row=mysqli_fetch_array($sql))
{
 $cmpn=$row['complaintNumber'];
}
$complainno=$cmpn;
echo '<script> alert("Your complaint has been successfully filed and your complaint no is  "+"'.$complainno.'")</script>';
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
    <title>BMSIT CMS | Register Complaint</title>
    <link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <!-- Bootstrap core CSS -->
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container" >
    <?php include("includes/header.php");?>
    <?php include("includes/sidebar.php");?>
      <section id="main-content">
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i> Register Complaint</h3>
          <!-- BASIC FORM ELEMENTS -->
            <div class="form-panel">
            <?php if($successmsg)
            {?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($successmsg);?></div>
            <?php }
            if($errormsg)
            { ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($errormsg);?></div>
            <?php }?>
              <form class="form-horizontal style-form" method="post" name="complaint" enctype="multipart/form-data" >
                <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Category</label>
                <div class="col-sm-4">
                  <select name="category" id="category" class="form-control" onChange="getCat(this.value);" required>
                    <option value="" selected hidden disabled>Select Category</option>
                    <?php $sql=mysqli_query($con,"select id,categoryName from category ");
                    while ($rw=mysqli_fetch_array($sql)) {
                      ?>
                      <option value="<?php echo htmlentities($rw['id']);?>"><?php echo htmlentities($rw['categoryName']);?></option>
                    <?php
                    } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Subject of Complaint</label>
                <div class="col-sm-4">
                  <input type="text" name="noc" required="required" value="" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Complaint Details (max. 2000 words) </label>
                <div class="col-sm-6">
                  <textarea  name="complaindetails" required="required" cols="10" rows="10" class="form-control" maxlength="2000"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Complaint Related Document (if any) </label>
                <div class="col-sm-6">
                  <input type="file" name="compfile" class="form-control" value="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10" style="padding-left:18% ">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <br><br>
        </section>
      <?php include("includes/footer.php");?>
      </section>
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <?php include('includes/scripts.php') ?>
    <script>
      function getCat(val) {
      $.ajax({
      type: "POST",
      url: "getsubcat.php",
      data:'catid='+val,
      success: function(data){
      $("#subcategory").html(data);

      }
      });
      }
    </script>
  </body>
</html>
<?php } ?>
