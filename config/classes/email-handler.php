<?php

class email_handler {
	
	public $title;
	
	public function setTitle( ?string $title = null ) {
		$this->title = $title;
		return $this;
	}
	
	/* 
		It is best to avoid repeating code by coping and pasting especially when it will be used so much in a script
		Therefore, an interface is designed
	*/
	
	protected function designInterface( $message, $username ) { 
		
		global $settings, $config;
		
		if( empty($this->title) ) $this->title = "Thank you for investing on " . $config->get('site_name');
		
		ob_start();
?>
	
			<div style="background: #f5f7f8;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container"> 

				<div style="background:#fff;max-width: 600px; margin: 0px auto; padding: 30px;"class="be_inner_containr"> 
					
					<div class="be_header">

						<div class="be_logo" style="float: left;"> 
							<img src="<?php echo $settings['logourl']; ?>"> 
						</div>
						
						<?php if( $username ): ?>
						<div class="be_user" style="float: right; display: none;"> 
							<p>Dear: <?php echo $username; ?></p> 
						</div> 
						<?php endif; ?>
						
						<div style="clear: both;"></div> 

						<div class="be_bluebar" style="background: #1976d2; padding: 10px 20px; color: #fff;margin-top: 10px;">
							<h2><?php echo $this->title; ?></h2>
						</div> 
					
					</div> 

					<div class="be_body" style="padding: 20px 0;"> 
						
						<div style="line-height: 25px; margin-bottom: 14px;"><?php echo trim($message); ?></div>

						<div class="be_footer">
						
							<div style="border-bottom: 1px solid #ccc;"></div>

							<div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px; text-align: center;">

								<p> Please do not reply to this email. <br> Emails sent to this address will not be answered. </p>
								<p> Copyright © <?php echo (new datetime())->format('Y') . ' ' . $config->get('site_name'); ?> </p> 
								
								<div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> 
								
							</div> 
						
						</div> 
					
					</div>
				
				</div>
				
			</div>
							
<?php 

		$output = ob_get_clean();
		return $output;

	}

	public function table_context( array $data, array $dark = [] ) {
		
		$relative_style = "border: 1px solid #f7f7f7; padding: 8px;";
		
		$table = "
			<div style='overflow: auto;'>
				<table style='width: 100%;'>
					<tbody>";
		
		$i = 0;
		foreach( $data as $left => $right ) {
			$left = ucwords($left);
			$right = ucfirst($right);
			$bgcr = in_array($i,$dark) ? '#ebebeb' : '#f7f7f7';
			$table .= "<tr>
				<td style='{$relative_style} background-color: #ebebeb; font-weight: bold;'>{$left}</td>
				<td style='{$relative_style} background-color: {$bgcr}'>{$right}</td>
			</tr>";
			$i++;
		};
		
		$table .= "
					</tbody>
				</table>
			</div>";
			
		return $table;
		
	}
	
	public function message( $message, ?string $username = null ) {
		return $this->designInterface( $message, $username );
	}
	
};

