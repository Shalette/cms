<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
if(strlen($_SESSION['alogin'])!=0)
{
header('location:../admin/notprocess-complaint.php');
}

  if(isset($_POST['submit']))
  {
    $y=$x=0;
    if(isset($_POST['useremail']) && ($_POST['useremail']!=$_SESSION['login']))
    {
      $query=mysqli_query($con,"select * from users where userEmail='".$_POST['useremail']."'") or die(mysqli_error($con));
      if(mysqli_num_rows($query)>0){
        echo "<script>alert('Email is already in use.');</script>";
        $y=2;
      }
      else {
        $y=1;
      }
    }
    if(isset($_POST['contactno']) && ($_POST['contactno']!=$_SESSION['number']))
    {
      $query=mysqli_query($con,"select * from users where contactNo='".$_POST['contactno']."'") or die(mysqli_error($con));
      if(mysqli_num_rows($query)>1){
        echo "<script>alert('Contact number is already in use.');</script>";
        $x=2;
      }
      else{
        $x=1;
      }
    }
    if(isset($_POST['block']))
      $block=mysqli_real_escape_string($con, $_POST['block']);
    else
      $block="G";
    $roomno=mysqli_real_escape_string($con,$_POST['roomno']);
    if(($x==1||$x==0) && ($y==1||$y==0))
    {
      $query=mysqli_query($con,"update users set block='$block', roomNo='$roomno', updationDate=CURRENT_TIMESTAMP where userEmail='".$_SESSION['login']."'") or die(mysqli_error($con));
      if($query)
      {
      if($x==1){
        if($y!=1){
          $confirmcode=rand(100000, 999999);
          $email=$_POST['useremail'];
          $query=mysqli_query($con,"update users set confirmcode='$confirmcode' WHERE userEmail='".$_SESSION['login']."'");
          $contact=$_POST['contactno'];
          $_SESSION['aim']="Reset";
          $number="91".$contact;
          $_SESSION['replace']=$contact;
          $message=$confirmcode;

          $ch = curl_init("http://login.smsgatewayhub.com/api/mt/SendSMS?APIKey=62sxGWT6MkCjDul6eNKejw&senderid=BMSITM&channel=2&DCS=0&flashsms=0&number=$number&text=$message&route=1;");
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $data = curl_exec($ch);
          echo "<script>setTimeout(function() {
            window.location.href = 'otp-confirm.php';
          }, 1000);
          </script>";

          $msg="An OTP has been sent. You will be redirected to confirm the change of mobile number.";
          echo "<script>alert('".$msg."' );</script>";
        }
      else{
        $msg="Email id and mobile number cannot be updated simultaneously.";
        echo "<script>alert('".$msg."' );</script>";
      }
    }
    if($y==1){
      if($x!=1){
        $confirmcode=rand(100000, 999999);
        $email=$_POST['useremail'];
        $query=mysqli_query($con,"update users set confirmcode='$confirmcode' WHERE userEmail='".$_SESSION['login']."'");
        $extra="mail.php?email=".$email."&id=".$_SESSION['id']."&confirmcode=".$confirmcode;
        $host=$_SERVER['HTTP_HOST'];
        $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        $link="http://$host$uri/$extra";
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = 'DoNotReplyBmsit@gmail.com';                 // SMTP username
          $mail->Password = 'Test@123';                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = 587;                                    // TCP port to connect to
          $mail->SMTPOptions = array(
                   'ssl' => array(
                       'verify_peer' => false,
                       'verify_peer_name' => false,
                       'allow_self_signed' => true
                   )
               );
            //Recipients
          $mail->setFrom('DoNotReplyBmsit@gmail.com', 'BMSIT CMS');
          $mail->addAddress($email, $_POST['fullname']);     // Add a recipient             // Name is optional
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Email Change';
          $mail->Body    = $_POST['fullname'].', to confirm change of email for your account, click the following link:<br>'.$link.'<br><br>Remember to sign in with your new email to verify.<br>Kindly delete this message if it was not intended for you.';
          $mail->send();
          $msg=" Reset Email Sent. Email Id will be updated on confirmation. You will be logged out shortly.";
        } catch (Exception $e) {
            $msg= ' Reset Email could not be sent. Error: '.$mail->ErrorInfo;
        }

      echo "<script>setTimeout(function() {
        window.location.href = 'logout.php';
      }, 3000);
      </script>";
      echo "<script>alert('".$msg."' );</script>";
      $successmsg="Profile updated successfully.";
    }
    else{
      $errormsg="Profile not updated.";
    }
    }
    }
    else
    {
    $errormsg="Profile not updated.";
    }
  }
      else
      {
      $errormsg="Profile not updated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMSIT CMS | Profile</title>
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
          <h3><i class="fa fa-angle-right"></i> Profile Information</h3>
          <!-- BASIC FORM ELEMENTS -->
          <div class="form-panel">
          <?php if($successmsg)
          { ?>
            <div class="alert alert-success alert-dismissable">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($successmsg);?></div>
            <?php }
            if($errormsg)
            {?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo htmlentities($errormsg);?></div>
            <?php }
            $query=mysqli_query($con,"select * from users where userEmail='".$_SESSION['login']."'");
            while($row=mysqli_fetch_array($query))
            { ?>
            <h4 class="mb"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo htmlentities($row['fullName']);?>'s Profile</h4>
            <h5><b>Last Updated at :</b>&nbsp;&nbsp;<?php echo htmlentities($row['updationDate']);?></h5>
            <form class="form-horizontal style-form" method="post" name="profile" >
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10">
                  <input type="text" name="fullname" required="required" readonly value="<?php echo htmlentities($row['fullName']);?>" class="form-control" pattern="[A-Z][A-Za-z\s]{1,}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Email ID </label>
                <div class="col-sm-4">
                  <input type="email" style="margin-bottom: 7px" name="useremail" required="required" value="<?php echo htmlentities($row['userEmail']);?>" class="form-control">
                </div>
                <label class="col-sm-2 col-sm-2 control-label">Contact</label>
                <div class="col-sm-4">
                  <input type="text" name="contactno" required="required" value="<?php echo htmlentities($row['contactNo']);?>" pattern="[6-9]([0-9]{9})" class="form-control" oninvalid="this.setCustomValidity('Enter Valid Mobile Number')" oninput="this.setCustomValidity('')">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Gender </label>
                <div class="col-sm-4">
                  <input type="text" style="margin-bottom: 7px" name="hostel" required="required" value="<?php echo htmlentities($row['hostel']);?>" class="form-control" readonly>
                </div>
                <label class="col-sm-2 col-sm-2 control-label">Block</label>
                <div class="col-sm-4">
                <?php
                if ($row['hostel']=='Male')
                $x=2;
                else
                $x=1;
                $sql=mysqli_query($con,"select * from block where hostel_id='$x' and bname!='".$row['block']."'");
                if(mysqli_num_rows($sql)>0){ ?>
                  <select name="block" required class="form-control">
                    <option selected value="<?php echo htmlentities($row['block']);?>"><?php echo htmlentities($row['block']);?></option>
                    <?php
                    while ($rw=mysqli_fetch_array($sql)) {
                    if ($rw['bname']!= $row['block']) ?>
                    <option value="<?php echo htmlentities($rw['bname']);?>"><?php echo htmlentities($rw['bname']);?></option>
                    <?php
                    }?>
                  </select>
                <?php
                }
                else{?>
                <input type="text" value="None" class="form-control" readonly>
                <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Room Number</label>
                <div class="col-sm-4">
                  <input type="text" style="margin-bottom: 7px" name="roomno" maxlength="3" required="required" value="<?php echo htmlentities($row['roomNo']);?>" class="form-control" oninvalid="this.setCustomValidity('Enter Valid Room Number')" oninput="this.setCustomValidity('')">
                </div>
                <label class="col-sm-2 col-sm-2 control-label">Reg Date </label>
                <div class="col-sm-4">
                  <input type="text" required="required" value="<?php echo htmlentities($row['regDate']);?>" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">User Photo</label>
                <div class="col-sm-4">
                <?php $userphoto=$row['userImage'];
                if($userphoto==""){
                ?>
                  <img src="userimages/noimage.png" width="242" height="256" >
                  <a href="update-image.php">Change&nbsp;Photo</a>
                  <?php }else{?>
                	<img class="img-rounded" src="userimages/<?php echo htmlentities($userphoto);?>" width="242" height="256">
                	<a href="update-image.php">Change&nbsp;Photo</a>
                  <?php } ?>
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
        <br><br><br><br><br><br>
      <?php include("includes/footer.php");?>
      </section>
    </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <?php include('includes/scripts.php') ?>
  </body>
</html>
