<?php

require __dir__ . '/sub-config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	switch( $_POST['submit'] ):
	
		case 'password':
		
				$msg = call_user_func(function() use(&$temp, $link) {
					
					foreach( $_POST as $key => $value ) $_POST[$key] = sysfunc::sanitize_input($value, true);
					
					if( $temp->admin['password'] != sysfunc::encpass($_POST['opassword']) ) 
						return  "Old password is wrong";
					
					if( strlen($_POST['password']) < 5 ) return "New password should be at least 6 characters";
					
					$sql = sysfunc::mysql_update_str('admin', array(
						'password' => sysfunc::encpass($_POST['password'])
					), $temp->admin['email']);
					
					if( !$link->query( $sql ) ) return "Password not changed";
					
					$_SESSION['admin:password'] = sysfunc::encpass($_POST['password']);
					
					$temp->status = true;
					
					return "Password successfully changed";
					
				});
	
			break;
			
		case 'email':
				
				$SQL = sQuery::update( 'admin', array(
					"email" => $_POST['email']
				), "id = {$temp->admin['id']}");
				
				$temp->status = $link->query( $SQL );
				
				if($temp->status) {
					
					$msg = "Login email has been updated";
					
					$_SESSION['admin:email'] = $_POST['email'];
					$temp->admin = (new user('admin'))->info();
					
				} else $msg = "Login email not updated";
		
			break;
			
	endswitch;
	
}

include "header.php";


?>

	<?php section::title( "Password Update", false ); ?>

   <div class="card">
		 
        <div class="card-body">
            
			<?php sysfunc::html_notice($msg, !empty($temp->status)); ?>
			
            <div class="box box-widget widget-user-2">
               <div class="widget-user-header bg-white">
			   
                  <form class="form-horizontal" action="password.php" method="POST" >
					  <div class="form-group">
						 <input type="password"  name="opassword"   placeholder="Old Password" class="form-control" required>
					  </div>
					  <div class="form-group">
						 <input type="password"  name="password"   placeholder="New Password" class="form-control" required>
					  </div>
					  <div class="form-group">
						 <input type="submit"  name="submit" value="password" class="btn btn-warning">
					  </div>
				  </form>
				  
               </div>
            </div>
			
			<hr>
			
			<div class='p-3'>
			
				<div class='alert alert-warning fs-13'>
					You may also wish to change your login email
				</div>	
			   
				<form method='POST'>
				
					<div class='form-group'>
						<div class='input-group'>
							<span class='input-group-text'>
								<i class='mdi mdi-account-key'></i>
							</span>
							<input type='email' name='email' value='<?php echo $temp->admin['email']; ?>' class='form-control'>
						</div>
					</div>
					
					<div class='form-group'>
						<button class='btn btn-info btn-fw' type='submit' name='submit' value='email'>
							Change Email
						</button>
					</div>
				
				</form>
			
			</div>
			
         </div>
		 
   </div>

<?php include 'footer.php'; ?>