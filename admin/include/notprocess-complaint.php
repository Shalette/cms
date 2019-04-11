<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin | Closed Complaints</title>
	<?php include('include/headers.php');?>
	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+500+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
</script>
    <style>
        table{
            cellpadding="0"; cellspacing="0"; border="0";
        }
    </style>
     <script>
            
        $(document).ready(function()
                        {
            $("#fetchval").on('change',function()                           
{
   var value = $(this).val();
   $.ajax(
   {
       url:'fetch.php',
       type:'POST',
       data:{request: value, status: "NULL"},
       beforeSend:function()
       {
         $("#table-container").html('working on....'); 
       },
       success:function(data)
       {
           $("#table-container").html(data);
       },
   });
            });
        });
                
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
								<h3>Not Yet Processed Complaints</h3><br>
							
        <select id="fetchval" name="fetchby" class="padding-right:50px;">
        <option selected hidden>Select Block</option>
        <option value="NULL">All Blocks</option>
        <option value="A">A Block</option>
        <option value="B">B Block</option>
        <option value="C">C Block</option>
        <option value="G">Girls Hostel</option>
        </select>
				</div>

      <div class="module-body table">
      <table  class="datatable-1 table table-bordered table-striped display"  id="table-container">
       <?php
    $query=mysqli_query($con,"select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.fstatus is null");
    echo '<thead>';
			 echo '<tr>';
             echo '<th>Complaint No</th>';
              echo	'<th>Student Name</th>';
              echo	'<th>Reg Date</th>';
				echo '<th>Status</th>';
				echo '<th>Action</th>';
				echo '</tr>';
				echo '</thead>';
          echo '<tbody>';
while($output=mysqli_fetch_array($query))
{
echo '</tr>' ?>
          <?php 
          echo '<tr>';
                    echo '<td>'.$output['complaintNumber'].'</td>';
                    echo '<td>'.$output['name'].'</td>';
                    echo '<td>'.$output['regDate'].'</td>';?>
                    <td><button type="button" class="btn btn-danger">Not processed yet</button></td>
<td>   <a href="complaint-details.php?cid=<?php echo ($output['complaintNumber']);?>"> View Details</a>
</td>
          <?php echo '</tr>'; ?>
          <?php  } 
echo '</tbody>';
echo '</table>';
mysqli_close($con);  ?>


          </table>
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

