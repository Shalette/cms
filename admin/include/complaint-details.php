<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin | Complaint Details</title>
    <?php include('include/headers.php'); ?>
	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>

</head>
<body>
<?php include('include/header.php');?>

		<div class="container cont">
			<div class="row">
<?php include('include/sidebar.php');?>
			<div class="span9">
					<div class="content">




	<div class="module">
							<div class="module-head">
								<h3>Complaint Details</h3>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">

									<tbody>

<?php $st='Closed';
$query=mysqli_query($con,"select tblcomplaints.*,users.*,category.categoryName as catname from tblcomplaints join users on users.id=tblcomplaints.userId join category on category.id=tblcomplaints.category where tblcomplaints.complaintNumber='".$_GET['cid']."'");
while($row=mysqli_fetch_array($query))
{

?>
										<tr>
											<td><b>Complaint Number</b></td>
											<td><?php echo htmlentities($row['complaintNumber']);?></td>
											<td><b>Student Name</b></td>
											<td> <?php echo htmlentities($row['fullName']);?></td>
											<td><b>Reg Date</b></td>
											<td><?php echo htmlentities($row['regDate']);?>
											</td>
										</tr>
<tr>
	<td><b>Hostel: </b></td>
	<td><?php if($row['hostel']=='Female') echo 'Girls Hostel';
						else echo 'Boys Hostel';?></td>
	<td><b>Block: </b></td>
	<td><?php echo htmlentities($row['block']);?></td>
	<td><b>Room No: </b></td>
	<td><?php echo htmlentities($row['roomno']);?></td>
</tr>
<tr>
											<td><b>Category </b></td>
											<td colspan="2"><?php echo htmlentities($row['catname']);?></td>
											<td><b>Nature of Complaint</b></td>
											<td colspan="2"> <?php echo htmlentities($row['noc']);?></td>
										</tr>
<tr>

											<td><b>Complaint Details </b></td>

											<td colspan="5"> <?php echo htmlentities($row['complaintDetails']);?></td>

											</tr>
										<tr>
											<td><b>File(if any) </b></td>

											<td colspan="5"> <?php $cfile=$row['complaintFile'];
if($cfile=="" || $cfile=="NULL")
{
  echo "File NA";
}
else{?>
<a href="../users/complaintdocs/<?php echo htmlentities($row['complaintFile']);?>" target="_blank"> View File</a>
<?php } ?></td>
</tr>

<?php $ret=mysqli_query($con,"select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
while($rw=mysqli_fetch_array($ret))
{
?>
<tr>
<td><b>Remark</b></td>
<td><?php echo  htmlentities($rw['remark']); ?></td>
	<td><b>Remark Date</b></td>
	<td colspan="3"><?php echo  htmlentities($rw['rdate']); ?></td>
</tr>

<tr>
<td><b>Status</b></td>
<td colspan="5"><?php echo  htmlentities($rw['sstatus']); ?></td>
</tr>
<?php }?>

<tr>
<td><b>Action</b></td>

<td>
<?php if($row['status']=="Closed"){
echo 'N/A';
} else {?>
<a href="javascript:void(0);" onClick="popUpWindow('updatecomplaint.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
 <button type="button" class="btn btn-primary">Take Action</button>
</a><?php } ?></td>
<td colspan="4">
<a href="javascript:void(0);" onClick="popUpWindow('userprofile.php?uid=<?php echo htmlentities($row['userId']);?>');" title="Update order">
<button type="button" class="btn btn-primary">View User Details</button></a></td>
</tr>
<?php  } ?>
</table>
</div>
</div>



					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->

<?php include('include/footer.php');?>
<?php include('include/js.php');?>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>
