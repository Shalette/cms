<?php session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{ ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container" >
    <?php include("includes/header.php");?>
    <?php include("includes/sidebar.php");?>
      <section id="main-content">
        <section class="wrapper">
          <div class="row text-center" style="padding-top:50px;">
            <div class="col-md-10 main-chart">
              <a href="complaint-history.php">
                <div class="col-md-offset-4 col-md-2 box0">
                  <div class="box1">
                    <span class="fa fa-newspaper-o"></span>
                    <?php
                    $rt = mysqli_query($con,"SELECT * FROM tblcomplaints where userId='".$_SESSION['id']."' and fstatus is null");
                    $num1 = mysqli_num_rows($rt);?>
					  			  <h3><?php echo htmlentities($num1);?></h3>
                  </div>
					  			<p><?php echo htmlentities($num1);?> Complaints Not Processed Yet</p>
                </div>
                <div class="col-md-2 box0">
                  <div class="box1">
                    <span class="fa fa-newspaper-o"></span>
                    <?php
                    $status="In Process";
                    $rt = mysqli_query($con,"SELECT * FROM tblcomplaints where userId='".$_SESSION['id']."' and  fstatus='$status'");
                    $num1 = mysqli_num_rows($rt);?>
                    <h3><?php echo htmlentities($num1);?></h3>
                  </div>
                  <p><?php echo htmlentities($num1);?> Complaints Currently In Process</p>
                </div>
                <div class="col-md-2 box0">
                  <div class="box1">
                    <span class="fa fa-newspaper-o"></span>
                    <?php
                    $status="Closed";
                    $rt = mysqli_query($con,"SELECT * FROM tblcomplaints where userId='".$_SESSION['id']."' and  fstatus='$status'");
                    $num1 = mysqli_num_rows($rt);?>
                    <h3><?php echo htmlentities($num1);?></h3>
                  </div>
                  <p><?php echo htmlentities($num1);?> Complaints Have Been Closed</p>
                </div>
              </a>
            </div><!-- /row mt -->
          </section>
          <?php include("includes/footer.php");?>
        </section>
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <?php include('includes/scripts.php') ?>
  </body>
</html>
<?php } ?>
