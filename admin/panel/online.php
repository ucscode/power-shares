<?php

require __dir__ . '/sub-config.php';


// delete investor
if(isset($_POST['delete'])){
	
	$email = $_POST['email'];
	
$sql = "DELETE FROM users WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor deleted successfully!";
} else {
    $msg = "Investor not deleted! ";
}
}
// verify investor

if(isset($_POST['verify'])){
	
	$email = $_POST['email'];
	
$sql = "UPDATE users SET verify = '1'  WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor verified successfully!";
} else {
    $msg = "Investor not was not verified! ";
}
}



if(isset($_POST['vemail'])){
	
	$email = $_POST['email'];
	
$sql = "UPDATE users SET confirm = '1'  WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor verified successfully!";
} else {
    $msg = "Investor not was not verified! ";
}
}



// unverify investors

if(isset($_POST['unverify'])){
	
	$email = $_POST['email'];
	
$sql = "UPDATE users SET verify = '0'  WHERE email='$email'";

if (mysqli_query($link, $sql)) {
    $msg = "Investor Un-verified successfully!";
} else {
    $msg = "Investor not was not Un-verified! ";
}
}


include 'header.php';

?>

    <div class="card">
        <div class="card-header">
            <h2 class="text-center">ONLINE INVESTORS</h2>
        </div>
        <div class="card-body">
            <div class="">
			
				<?php sysfunc::html_notice( $msg ); ?>
				
                <div class="col-md-12 col-sm-12 col-sx-12">
                    <div class="box-body table-responsive padding">
                        <table class="table table-striped table-hover table-responsive" >
                            <thead>
                                <tr class="info">
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Email Status</th>
                                    <th style="display:none;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql= "SELECT * FROM users WHERE session = 1";
                                    $result = mysqli_query($link,$sql);
                                    if(mysqli_num_rows($result) > 0){
                                     while($row = mysqli_fetch_assoc($result)){  
                                     
									 if(isset($row['verify'])  && $row['verify']==1){
                                      $msg = 'Verified &nbsp;&nbsp;<i style="background-color:green;color:#fff; font-size:20px;" class="fa  fa-check" ></i>';
                                      
                                     }else{
                                      $msg = 'Not verified &nbsp;&nbsp;<i class="fa  fa-times" style=" font-size:20px;color:red"></i>';
                                     }
                                     
                                      if(isset($row['confirm'])  && $row['confirm']==1){
                                      $msg1 = 'Verified <i class="fa fa-check-circle text-success ml-1"></i>';
                                      
                                     }else{
                                      $msg1 = 'Unverified <i class="fa fa-times text-danger ml-1"></i>';
                                     }
                                     ?>
                                <tr class="primary">
                                    <form action="verify.php" method="post">
                                        <td><?php echo $row['username'];?></td>
                                        <td id="email"><?php echo $row['email'];?></td>
                                        <td ><?php echo $msg1;?></td>
                                        <td style="display:none;"><input type="hidden" name="email" value="<?php echo $row['email'];?>"> </td>
                                    </form>
                                </tr>
                                <?php
                                    }
                                    		  }
                                    		  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /top tiles -->
        </div>
    </div>

<?php include 'footer.php'; ?>