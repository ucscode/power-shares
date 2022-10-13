<?php

require __dir__ . '/sub-config.php';

include "inc/investors_query.php";

include "header.php";

?>
	
	<?php section::title( 'overview', false ); ?>
	
	<div class="row overview">
	
		<?php
		
			require __dir__ . '/extension/info-card.php';
			
			info_card('users', array(
				"label" => 'Users',
				"value" => $total_users,
				"icon" => "mdi mdi-account-circle",
				"gradient" => ["#7922e5", "#1579ff"]
			));
			
			info_card('online', array(
				"label" => 'Online',
				"value" => $online_users,
				"icon" => "mdi mdi-account-star",
				"gradient" => ["#429321", "#b4ec51"],
				"circle" => circle_degree($online_users, $total_users)
			));
			
			info_card('deposit', array(
				"label" => 'Deposits',
				"value" => '$' . $total_deposits,
				"icon" => "mdi mdi-arrow-down-bold-hexagon-outline",
				"gradient" => ["#f76b1c", "#fad961"],
				"circle" => circle_degree($total_deposits, $total_withdrawals)
			));
			
			info_card('withdrawal', array(
				"label" => 'Withdrawals',
				"value" => '$' . $total_withdrawals,
				"icon" => "mdi mdi-format-horizontal-align-right",
				"gradient" =>  ["#9f041b", "#f5515f"],
				"circle" => circle_degree($total_withdrawals, $total_deposits)
			));
			
			### BATCH 2;
			
			info_card('shares', array(
				"label" => 'Shares',
				"value" => $total_shares,
				"icon" => "mdi mdi-chart-bubble",
				"gradient" => ["#429321", "#b4ec51"]
			));
			
			info_card('investment', array(
				"label" => 'Investments',
				"value" => '$' . $total_investments,
				"icon" => "mdi mdi-currency-usd",
				"gradient" => ["#7922e5", "#1579ff"],
				"circle" => circle_degree($total_investments, $total_roi)
			));
			
			info_card('roi', array(
				"label" => 'ROI',
				"value" => '$' . $total_roi,
				"icon" => "mdi mdi-chart-line",
				"gradient" => ["#f76b1c", "#fad961"],
				"circle" => circle_degree($total_roi, $total_investments)
			)); 
			
			info_card('tickets', array(
				"label" => 'Tickets',
				"value" => $total_tickets,
				"icon" => "mdi mdi-ticket",
				"gradient" =>  ["#9f041b", "#f5515f"]
			));
		
		?>

	</div>
	
<?php require "footer.php"; 