<?php
error_reporting(0);
include('include/config.php');
if($_POST['request']){
    $request=$_POST['request'];
    $status=$_POST['status'];
    if($status=="NULL")
    {
        if($request=="NULL")
        $query="select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.fstatus is NULL";
        else
             $query="select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where block='$request' and tblcomplaints.fstatus is NULL";
    }
    else{
        
        if($request=="NULL")
        $query="select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.fstatus ='$status'";
        else
             $query="select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where block='$request' and tblcomplaints.fstatus='$status'";
    }
                $result=mysqli_query($con,$query);
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>Complaint Number</th>';
                echo '<th>Student Name</th>';
                echo '<th>Reg Date</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                while($row=mysqli_fetch_array($result)){ ?>
                    	<tr>
                            <td><?php echo ($row['complaintNumber']);?></td>
				             <td><?php echo htmlentities($row['name']);?></td>
								<td><?php echo htmlentities($row['regDate']);?></td>
<?php if($status=="NULL") echo '<td><button type="button" class="btn btn-danger">Not Processed Yet</button></td>';
 else if ($status=="In Process") echo '<td><button type="button" class="btn btn-warning">In Process</button></td>';                                           
                            
 else echo '<td><button type="button" class="btn btn-success">Closes</button></td>';                           
                            ?>
<td>   <a href="complaint-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>"> View Details</a>
											</td>
											</tr>
                
                
              <?php }  mysqli_close($con);
}
?>
