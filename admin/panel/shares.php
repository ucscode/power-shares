<?php

require __dir__ . '/sub-config.php';

require 'inc/for-shares.php';

require 'header.php';

?>

<?php section::title("All shares"); ?>

   <div class="card">
      <div class="card-header">
            <h5 class="text-uppercase text-md-left mb-0">
				Shares Management
			</h5>
		</div>
         <div class="card-body">
            <div class="col-md-12 col-sm-12 col-sx-12">
				
				<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
				
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <thead>
                        <tr class="info">
                           <th class='d-none'>FORM</th>
                           <th>Shares Name</th>
                           <th>Percentage</th>
                           <th>Duration</th>
                           <th>Bonus</th>
                           <th>Status</th>
                           <th>Range</th>
                           <th>Activation</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class='font-1'>
                        <?php 
							
							$SQL = "SELECT * FROM shares ORDER BY id DESC";
							$nav = new nav($SQL);
							$result = $nav->result();
							
							if(mysqli_num_rows($result)):
								while($share = mysqli_fetch_assoc($result)):
									
									if( !empty($share['max_investment']) ) {
										$max_invest =  "\${$share['max_investment']}";
									} else $max_invest = "<i class='mdi mdi-call-made fs-20 text-success' title='Unlimited'></i>";
									
									$seperator = "<i class='mdi mdi-arrow-right-bold text-info'></i>";
									$form_id = "share-form-{$share['id']}";
                        ?>
							<tr>
								<td class='d-none'>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="<?php echo $form_id; ?>">
										<input type='hidden' name='id' value="<?php echo $share['id']; ?>">
									</form>
								</td>
								<td><?php echo $share['name']; ?></td>
								<td><?php echo $share['increase']; ?> <span class='text-muted'>%</span></td>
								<td><?php echo empty($share['duration']) ? "Unlimited" : "{$share['duration']} days"; ?></td>
								<td><?php echo '$' . $share['bonus']; ?></td>
								<td><?php echo sysfunc::checker($share['status']); ?></td>
								<td><?php echo "\${$share['min_investment']} &nbsp; {$seperator} &nbsp; {$max_invest}"; ?></td>
								<td>
									<div class='btn-group'>
										<button class="btn btn-success" type="submit" name="action" value='enable' title='enable' form='<?php echo $form_id; ?>'>
											<span class="fas fa-check"></span>
										</button>
										<button class="btn btn-warning" type="submit" name="action" value='disable' title="disable" form='<?php echo $form_id; ?>'>
											<span class="fas fa-ban"></span>
										</button>
									</div>
								</td>
								<td>
									<div class='btn-group'>
										<a class="btn btn-info" title="edit" href='shares-new.php?id=<?php echo $share['id']; ?>'>
											<span class="fas fa-pencil-alt"></span>
										</a>
										<button class="btn btn-danger" type="submit" name="action" value="delete" title="delete" data-confirm='Sure you want to delete the shares?' form='<?php echo $form_id; ?>'>
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

<?php require 'footer.php'; ?>