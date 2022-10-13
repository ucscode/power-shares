<?php

require __dir__ . '/sub-config.php';

if(isset($_POST['switch'])){
    
    $profit = $_POST['profit'];
      $ac = $_POST['ac'];

     $email = $_POST['email'];
    $id = $_POST['id'];
       $pp =   $percentage;     
    $dc = date('Y-m-d H:i:s');
	
	 $sql = "UPDATE ashares SET status = '0',date = '0',dc = '$dc', ac = '$ac' WHERE id='$id'";
	 
	 
  if(mysqli_query($link, $sql)){
      
      	 $sql9 = "UPDATE users SET walletbalance= walletbalance + ($profit)  WHERE email='$email'";
	 
	mysqli_query($link, $sql9);
$msg = "Shares Ended with profit of $profit!";

  }else{
      
      $msg = "Shares cannot be ended!";
  }
}














if(isset($_POST['activate'])){
	
	
  $email = $_POST['email'];
  $usd = $_POST['usd'];
  $cdate = date('Y-m-d H:i:s');


  $sql2= "SELECT * FROM users WHERE email= '$email'";
  $result2 = mysqli_query($link,$sql2);
  if(mysqli_num_rows($result2) > 0){
   $row = mysqli_fetch_assoc($result2);
   $row['walletbalance'];
   $row['activate'];
   $from = $row['froms'];
   $bonus = $row['bonus'];
 

    $sql1 = "UPDATE users SET activate = '1',pdate='$cdate',usd='$usd',walletbalance= walletbalance + $bonus  WHERE email='$email'";
    
    
		
	
  
 

  if(isset($row['activate']) &&  $row['activate'] == '1'){

    $msg = "package is already active!";

  }else{
	
if(isset($row['walletbalance']) && isset($row['froms']) && $row['walletbalance'] >= $from && $row['walletbalance'] >= $usd && $usd >= $from){


  mysqli_query($link, $sql1);
	
  $msg = "Your package is successfully activated!";


}else{
		

    $msg = "Package cannot be activated, insufficient balance or amount less than package minimum value ! ";
}
    }
  }

}
	
   
 


include 'header.php';

?>

<?php section::title( "My Shares" ); ?>

<div class=''>
    <div class="row">
        <?php
		
            $sql = "
				SELECT * FROM ashares 
				WHERE email='{$__user['email']}' AND status = 1
			";
			
            $result = $link->query($sql);
            
            if($result->num_rows):
				while($row = $result->fetch_assoc()):
					   
					if(!empty($row['status'])) 
						$sec = "Active <i class='fa fa-check-circle text-success'></i>";
					else $sec = "Inactive <i class='fa fa-times text-danger'></i>";
						
            ?>
			<div class="col-md-6 col-lg-4 col-12">
				<form action="mypackage.php" method="post">
					<div class="box box-inverse bg-dark">
						<div class="box-body text-center text-capitalize">
						
							<h2 class="mb-0 text-bold"><?php echo $row["sharescat"];?></h2>
							<p><?php echo $row["sharesubcat"];?></p>
							<h4 class='text-bold text-warning'> <?php echo $row["pname"];?></h4>
							<p><?php echo $sec;?></p>
							<h6 class='text-bold'> Worth: $<?php echo $row["amount"];?></h6>
							<h6 class='text-bold'>Profit: $<?php echo $row['increased_usd']; ?></h6>
							<h6><?php echo $row["increase"];?>% Daily</h6>
							<h6> @[<?php echo $row["date"];?>]</h6>
							
							<input name="profit"  type="hidden" value="<?php echo $percentage;;?>">
							<input name="id"  type="hidden" value="<?php  echo $row['id']?>">
							<input name="ac"  type="hidden" value="<?php  echo $row['date']?>">
							<input name="email"  type="hidden" value="<?php  echo $__user['email']?>">
							
							<button class="btn btn-success" type="submit" name="switch"> 
								Close Shares 
							</button>
							
						</div>
					</div>
					</br></br>
				</form>	
			</div>
        <?php  
					endwhile;
            else:
		?>
		
			<div class='col-12'>
				<div class='alert alert-info text-center'> You currently have no share </div>
			</div>
			
		<?php endif; ?>	
    </div>
</div>

<!-------------------------------- SECTION 2 --------------------------->

<section class="content-header">
    <h1>My Shares History</h1>
</section>

<div class="row">
    <?php
	
        $sql = "
			SELECT * FROM ashares 
			WHERE email='{$__user['email']}'
		";
		
        $result = $link->query($sql);
        
        if ($result->num_rows):
			while($row = $result->fetch_assoc()):
				
				$sid = $row["sid"];
				
				if(isset($row['status']) &&  $row['status']== '1'){
				
				
				$sec1 = '<span style="color:skyblue; font-size:20px;">Shares Still Active &nbsp;&nbsp;</span>';
				
				}else{
				$sec1 ='<span style="color:red; font-size:20px;">Shares Closed &nbsp;&nbsp;</span> &nbsp;&nbsp;</span>';
				$usd = 'No Shares';
				}
        
    ?>
    <div class="col-md-6 col-lg-4 col-12">
        <div class="box box-inverse bg-dark">
            <div class="box-body text-center">
			
                <h2 class="mb-0 text-bold"><?php echo $row["sharescat"];?></h2>
				<p><?php echo $row["sharesubcat"];?></p>
				<h4 class='text-bold text-warning'> <?php echo $row["pname"];?></h4>
				<p><?php echo $sec;?></p>
				<h6 class='text-bold'> Worth: $<?php echo $row["amount"];?></h6>
				<h6 class='text-bold'>Profit: $<?php echo $row['increased_usd']; ?></h6>
				<h6><?php echo $row["increase"];?>% Daily</h6>
				<h6> @[<?php echo $row["ac"];?>]</h6>
				
                <?php if(empty($row['status'])): ?>
					<h6> Date Closed: <?php echo $row["dc"]; ?></h6>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php  
				endwhile;
		else:
	?>
		
		<div class='col-12'>
			<div class='alert alert-primary text-center'>No Share History</div>
		</div>
		
	<?php endif; ?>
	
</div>

<?php include 'footer.php'; ?>