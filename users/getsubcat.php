<?php
include('includes/config.php');
if(!empty($_POST['gender']))
{
  $var= $_POST['gender'];
$query=mysqli_query($con,"select * from block WHERE hostel_id='$var'");
if(mysqli_num_rows($query)>0){
  ?>
<select name="block" required class="form-control">
<option value="" hidden selected disabled>Block</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo htmlentities($row['bname']); ?>"><?php echo htmlentities($row['bname']); ?></option>
  <?php
}?>

 </select>
 <br>
<?php }
 }
?>
