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
    <title>BMSIT CMS | Complaint Details</title>
    <link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    <!-- Bootstrap core CSS -->
    <?php include('includes/additional.php') ?>
  </head>
  <body>
    <section id="container">
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>
      <section id="main-content">
        <section class="wrapper site-min-height">
          <h3><i class="fa fa-angle-right"></i>&nbsp;Complaint Details</h3>
          <br>
          <?php $query=mysqli_query($con,"select tblcomplaints.*,category.categoryName as catname from tblcomplaints join category on category.id=tblcomplaints.category where userId='".$_SESSION['id']."' and complaintNumber='".$_GET['cid']."'");
          while($row=mysqli_fetch_array($query))
          { ?>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>Complaint Number&nbsp;: </b></label>
            <div class="col-xs-6 col-sm-4">
            	<p><?php echo htmlentities($row['complaintNumber']);?></p>
            </div>
            <label class="col-xs-6 col-sm-2 control-label"><b>Reg. Date&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-4">
              <p><?php echo htmlentities($row['regDate']);?></p>
            </div>
        	</div>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>Category&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-4">
              <p><?php echo htmlentities($row['catname']);?></p>
            </div>
            <label class="col-xs-6 col-sm-2 control-label"><b>Subject of Complaint&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-4">
              <p><?php echo htmlentities($row['noc']);?></p>
            </div>
          </div>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>File&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-4">
              <p><?php $cfile=$row['complaintFile'];
              if($cfile=="" || $cfile=="NULL")
              {
                echo htmlentities("N/A");
              }
              else{ ?>
              <a href="complaintdocs/<?php echo htmlentities($row['complaintFile']);?>" target='_blank'>View File</a>
              <?php } ?>
              </p>
            </div>
          </div>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>Complaint Details&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-10">
              <p><?php echo htmlentities($row['complaintDetails']);?></p>
            </div>
          </div>
          <?php
          $ret=mysqli_query($con,"select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
          while($rw=mysqli_fetch_array($ret))
          {
          ?>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>Remark&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-2">
              <p><?php echo  htmlentities($rw['remark']); ?></p>
            </div>
            <label class="col-xs-6 col-sm-2 control-label"><b>Remark Date&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-2">
             <p> <?php echo  htmlentities($rw['rdate']); ?></p>
            </div>
            <label class="col-xs-6 col-sm-2 control-label"><b>Status&nbsp;:</b></label>
            <div class="col-xs-6 col-sm-2">
              <p><?php echo  htmlentities($rw['sstatus']); ?></p>
            </div>
          </div>
          <?php } ?>
          <div class="row mt">
            <label class="col-xs-6 col-sm-2 control-label"><b>Final Status :</b></label>
            <div class="col-xs-6 col-sm-4">
              <p style="color:red"><?php
              if($row['fstatus']=="NULL" || $row['fstatus']=="" )
              {
              echo "Not Processed Yet";
              } else{
                            echo htmlentities($row['fstatus']);
              }?>
              </p>
            </div>
          </div>
          <?php } ?>
        </section><!-- wrapper -->
        <?php include('includes/footer.php');?>
      </section><!-- /MAIN CONTENT -->
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/js/common-scripts.js"></script>
    <?php include('includes/scripts.php') ?>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
  </body>
</html>
<?php } ?>
