<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
	$category=$_POST['category'];
	$description=$_POST['description'];
$sql=mysqli_query($con,"insert into category(categoryName,categoryDescription) values('$category','$description')");
$_SESSION['msg']="New category successfully created.";

}

if(isset($_GET['del']))
		  {
 mysqli_query($con,"delete from category where id = '".$_GET['id']."'");
 $_SESSION['delmsg']="Category successfully deleted.";
		  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin | Category</title>
<link rel="shortcut icon" type="image/png" href="../img/tiny.png"/>
    
    <?php include('include/headers.php');?>
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
<h3>Category</h3>
</div>
<div class="module-body">
<?php if(isset($_POST['submit'])){?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>
<?php if(isset($_GET['del'])){?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>
<br>
<form class="form-horizontal row-fluid" name="Category" method="post" >
<div class="control-group">
<label class="control-label" for="basicinput">Category Name</label>
<div class="controls">
<input type="text" placeholder="Enter Category Name"  name="category" class="span8 tip" required>
</div>
</div>
<div class="control-group">
<label class="control-label" for="basicinput">Description</label>
<div class="controls">
<textarea class="span8" name="description" rows="5"></textarea>
</div>
</div>
<div class="control-group">
<div class="controls">
<button type="submit" name="submit" class="btn">Create</button>
</div>
</div>
</form>
</div>
</div>

<div class="module">
<div class="module-head">
<h3>Manage Categories</h3>
</div>
<div class="module-body table">
<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
<thead>
<tr>
<th>#</th>
<th>Category</th>
<th>Description</th>
<th>Creation date</th>
<th>Last Updated</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php $query=mysqli_query($con,"select * from category");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($row['categoryName']);?></td>
											<td><?php echo htmlentities($row['categoryDescription']);?></td>
											<td> <?php echo htmlentities($row['creationDate']);?></td>
											<td><?php echo htmlentities($row['updationDate']);?></td>
											<td>
											<a href="edit-category.php?id=<?php echo $row['id']?>" ><i class="icon-edit"></i></a>
											<a href="category.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-sign"></i></a></td>
										</tr>
										<?php $cnt=$cnt+1; } ?>

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