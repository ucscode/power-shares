<?php

require __dir__ . '/sub-config.php';

include 'inc/for-shares-inv.php';

include 'header.php';

?>

<?php section::title( "Investments" ); ?>

   <div class="card">
   
         <div class="card-body">
            <div class="">
			
				<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
               <div class="table-responsive">
                  <table class="table table-hover table-striped table-bordered font-1">
                     <thead>
                        <tr class="info">
                           <th class='d-none'>FORM</th>
                           <th>Share</th>
                           <th>Investor</th>
                           <th>Invested</th>
                           <th>Increase</th>
                           <th>Duration</th>
                           <th>ROI</th>
                           <th>Status</th>
                           <th>Paid</th>
                           <th>Pay</th>
                           <th>Activation</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
						
							$SQL = "
								SELECT 
									investments.*,
									users.username
								FROM investments 
								LEFT JOIN users
									ON investments.userid = users.id
								ORDER BY investments.id DESC
							";
							
							$nav = new nav($SQL);
							
							$result = $nav->result();
							
							if(mysqli_num_rows($result)):
								while($inv = mysqli_fetch_assoc($result)):  
									
									$duration = empty($inv['duration']) ? "Unlimited" : "{$inv['duration']} days";
									
									$form_id = "inv-form-{$inv['id']}";
									
									$disable_pay = empty($inv['paid']) ? null : "disabled";
                        ?>
                        <tr class="primary">
							<td class='d-none'>
								<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' id='<?php echo $form_id; ?>'>
									<input type='hidden' name='id' value='<?php echo $inv['id']; ?>'>
								</form>
							</td>
							<td><?php echo $inv['share_name']; ?></td>
							<td>
								<?php if( !empty($inv['username']) ): ?>
								<a href='user-edit.php?id=<?php echo $inv['userid']; ?>'>
									<?php echo $inv['username']; ?>
								</a>
								<?php else: ?>
									<span class='text-muted'><?php echo $USER_OFF; ?></span>
								<?php endif; ?>
							</td>
							<td>$<?php echo $inv['amount']; ?></td>
							<td><?php echo $inv['increase']; ?>%</td>
							<td><?php echo $duration; ?></td>
							<td>$<?php echo $inv['increased_usd']; ?></td>
							<td><?php echo sysfunc::checker($inv['status']); ?></td>
							<td><?php echo sysfunc::checker($inv['paid']); ?></td>
							<td>
								<button class="btn btn-outline-info" type="submit" name="action" value='pay' form='<?php echo $form_id; ?>' data-confirm='<?php echo "Investor will be funded \${$inv['increased_usd']} and plan will be ended"; ?>' <?php echo $disable_pay; ?>>
									<span class="fas fa-plus-circle"></span>
								</button>
							</td>
							<td>
								<div class='btn-group'>
									<button class="btn btn-success" type="submit" name="action" value='activate' form='<?php echo $form_id; ?>' data-confirm="<?php echo 'Activate shared plan?'; ?>" <?php echo $disable_pay; ?>>
										<span class="fas fa-check-circle"></span>
									</button>
									<button class="btn btn-warning" type="submit" name="action" value='deactivate' form='<?php echo $form_id; ?>' data-confirm="<?php echo 'Deactivate shared plan?'; ?>" <?php echo $disable_pay; ?>>
										<span class="fas fa-ban"></span>
									</button>
								</div>
							</td>
							<td>
								<div class='btn-group'>
									<a class="btn btn-info" href='shares-inv-edit.php?id=<?php echo $inv['id']; ?>'>
										<span class="fas fa-pencil-alt"></span>
									</a>
									<button class="btn btn-danger" type="submit" name="action" value='delete' form='<?php echo $form_id; ?>' data-confirm="<?php echo "Are you sure you want to delete the shared plan?"; ?>">
										<span class="fas fa-trash"></span>
									</button>
								</div>
							</td>
                        </tr>
                        <?php
								endwhile;
							endif;
                        ?>
                     </tbody>
                  </table>
               </div>
			   
			   <?php $nav->pages(); ?>
			   
            </div>
         </div>
         <!-- /top tiles -->
      </div>


<?php include 'footer.php'; ?>