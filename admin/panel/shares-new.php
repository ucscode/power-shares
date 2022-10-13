<?php

require __dir__ . '/sub-config.php';

require 'inc/for-shares-new.php';

if( !empty($_GET['id']) ) {
	$result = $link->query( sQuery::select( 'shares', "id = {$_GET['id']}" ) );
	$share = ($result && $result->num_rows) ? $result->fetch_assoc() : [];
} else $share = [];

require "header.php";

$Title = empty($share) ? "New shares" : "Edit shares";

?>

<?php section::title( $Title ); ?>

<div class="card">

	<h5 class='card-header mb-0 text-uppercase'>
		<?php echo $Title; ?>
	</h5>
 
	 <div class="card-body">
	 
		<?php sysfunc::html_notice($temp->msg, $temp->status ?? null); ?>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
			
			<div class="form-group">
				<label class='required'>Shares Name</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-chart-line'></i>
					</span>
					<input type="text" name="name" placeholder="Shares Name"   class="form-control" value='<?php echo $share['name'] ?? null; ?>' required>
				</div>
			</div>
			
			<div class="form-group">
				<label class='required'>Daily Percentage Increase</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-percent'></i>
					</span>
					<input type="number" step='0.01'  name="increase" placeholder="Daily Percentage Increase" class="form-control" value='<?php echo $share['increase'] ?? null; ?>' required>
				</div>
			</div>
			
			<div class="form-group">
				<label class='required'>Purchase Bonus</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-library-plus'></i>
					</span>
					<input type="number" step='0.01'  name="bonus" placeholder="Purchase Bonus" class="form-control" value='<?php echo $share['bonus'] ?? 0; ?>' required>
				</div>
			</div>
			
			<div class="form-group">
				<label class='required'>Min Investment</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-currency-usd'></i>
					</span>
					<input type="number" step='0.01'  name="min_investment" placeholder="Min Investment (USD)" class="form-control" value='<?php echo $share['min_investment'] ?? 1; ?>' required>
				</div>
			</div>
			
			<div class="form-group">
				<label>
					Max Investment
					<span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="If empty or set to zero, max investment will be unlimited">
						<i class='fas fa-info-circle'></i>
					</span>
				</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-image-filter-center-focus'></i>
					</span>
					<input type="number" step='0.01'  name="max_investment" placeholder="Max Investment (USD)" value='<?php echo $share['max_investment'] ?? 0; ?>' class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label>
					Duration
					<span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="If empty or set to zero, investment duration will be unlimited">
						<i class='fas fa-info-circle'></i>
					</span>
				</label>
				<div class='input-group'>
					<span class="input-group-text">
						<i class='mdi mdi-alarm-check'></i>
					</span>
					<input type="number" name="duration" placeholder="End Period (DAYS)" value='<?php echo $share['duration'] ?? 0; ?>' class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="status" id="s1" value='1' <?php if( empty($share) || !empty($share['status']) ) echo 'checked'; ?>>
					<label class="form-check-label" for="s1">
						Enabled
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="status" id="s2" value='0' <?php if( !empty($share) && empty($share['status']) ) echo 'checked'; ?>>
					<label class="form-check-label" for="s2">
						Disabled
					</label>
				</div>		
			</div>
			
			<input type='hidden' name='id' value='<?php echo $share['id'] ?? null; ?>'>
			
			<button style="" type="submit" class="btn btn-info">
				<?php echo empty($share) ? 'Create' : 'Update'; ?> Shares
			</button>
			
		</form>
	</div>
</div>

<?php require 'footer.php'; ?>