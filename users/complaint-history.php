<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{
  if(isset($_GET['del']))
  		  {
              $query1=mysqli_query($con,"select * from tblcomplaints where complaintNumber = '".$_GET['id']."'");
              $num=mysqli_fetch_array($query1);
              if($num['complaintFile']!="")
              {
                  unlink('complaintdocs/'.$num['complaintFile']);
              }
  		         $query= mysqli_query($con,"delete from tblcomplaints where complaintNumber = '".$_GET['id']."'");
               if($query)
               {
                   $_SESSION['delmsg']="Complaint deleted successfully.";
               }
               else {
                $_SESSION['delmsg']="Complaint not deleted.";
               }
  		  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | Complaint History</title>
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container" >
    <?php include("includes/header.php");?>
    <?php include("includes/sidebar.php");?>
      <section id="main-content">
        <section class="wrapper">
          <h3><i class="fa fa-angle-right"></i>&nbsp;Your Complaint History</h3>
            <?php if(isset($_GET['del'])) {?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo htmlentities($_SESSION['delmsg']);?>
              </div>
            <?php  } ?>
            <div class="table-responsive content-panel" >
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>Complaint Number</th>
                    <th>Reg. Date</th>
                    <th>Last Updation Date</th>
                    <th >Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php $query=mysqli_query($con,"select * from tblcomplaints where userId='".$_SESSION['id']."' order by regDate desc");
                while($row=mysqli_fetch_array($query))
                { ?>
                  <tr>
                    <td align="center"><?php echo htmlentities($row['complaintNumber']);?></td>
                    <td align="center"><?php echo htmlentities($row['regDate']);?></td>
                    <td align="center"><?php echo  htmlentities($row['lastUpdationDate']);?></td>
                    <td><?php
                    $status=$row['fstatus'];
                    if($status=="" or $status=="NULL")
                    { ?>
                      <button class="btn btn-default" disabled style="width:100%; margin-bottom: 10px;">Not Processed Yet</button><br>
                      <a href="complaint-history.php?id=<?php echo $row['complaintNumber']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger" style="width:100%">Delete Complaint</a>
                    <?php }
                    if($status=="In Process"){ ?>
                      <button type="button" class="btn btn-warning" style="width:100%;" disabled>In Process</button>
                    <?php }
                    if($status=="Closed") {
                    ?>
                      <button type="button" class="btn btn-success" style="width:100%;" disabled>Closed</button>
                    <?php } ?>
                    <td align="center">
                      <a href="complaint-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>">
                        <button type="button" class="btn btn-primary" style="width:100%">View Details</button></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
        </div>
      </section><!-- wrapper -->
      <?php include("includes/footer.php");?>
    </section><!-- MAIN CONTENT -->
   </section>
   <!-- js placed at the end of the document so the pages load faster -->
   <?php include('includes/scripts.php') ?>
  </body>
</html>
<?php } ?>
