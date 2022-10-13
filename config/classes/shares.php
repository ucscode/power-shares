<?php 

class shares {
	
	public static function increment( $userid ) {
		
		global $link;
		
		$SQL = "
			SELECT * FROM investments 
			WHERE userid = '{$userid}' 
				AND status = 1
				AND paid = 0
		";
		
		$result = $link->query($SQL);
		if( !$result->num_rows ) return;
		
		while( $share = $result->fetch_assoc() ):
		
			if( empty($share['amount']) ) continue;
			
			foreach(['amount', 'increase'] as $key) {
				$share[$key] = (float)$share[$key];
			};
			
			// !DAILY PROFIT
			$daily_profit = round($share['amount'] * $share['increase'] * 0.01, 4);
			
			// !GET INVESTMENT {START} & {EXPIRY} TIME
			$investment_time = strtotime($share['date']);
			$expiry_time = !empty($share['duration']) ? ($investment_time + ((int)$share['duration'] * 86400)) : null;
			
			// !GET {LAST PROFIT TIME} & {CURRENT TIME}
			$last_profit_time = empty($share['last_increase_date']) ? $investment_time : strtotime($share['last_increase_date']);
			$current_time = time();
			
			/*
				{EXPIRY TIME} is a futuristic time 
				&& 
				{CURRENT TIME [now]} cannot be greater than the future.
				
				SO:
				
				!Prevent investor from receiving more than they should profit;
			*/
			
			if( $expiry_time && $current_time > $expiry_time ) $current_time = $expiry_time;
				
			// !CALCULATE THE NEW PROFIT;
			$days_apart = (int)(($current_time - $last_profit_time) / 86400);
			$shares_profit = round($daily_profit * $days_apart, 4);
			
			### UPDATE INVESTOR PROFIT;
			if( $shares_profit > 0 ) {
				
				$increment_date = (new dateTime())->setTimestamp($current_time)->format("Y-m-d H:i:s");
				
				$SQL = "
					UPDATE investments 
					SET last_increase_date = '{$increment_date}',
						increased_usd = ROUND((increased_usd + $shares_profit), 4)
					WHERE id = {$share['id']}
				";
				
				$link->query( $SQL );
			
			};
			
			### CALC DAYS USED
			$days_used = (int)(($current_time - $investment_time) / 86400);
			
			### IF THE INVESTMENT IS LIMITED & TIME IS DUE (EXPIRED)
			if( !empty($share['duration']) && ($days_used >= (int)$share['duration']) ) self::finalize( $share['id'] );
		
		endwhile;
		
	}
	
	public static function total( $userid, $column, $_AND = 1 ) {
		global $link;
		$sql = "
			SELECT SUM({$column}) as total
			FROM investments
			WHERE userid = '{$userid}' AND {$_AND}
			GROUP BY userid
		";
		$query = $link->query( $sql );
		$result = $query->fetch_assoc();
		return !$result ? 0 : round((float)$result['total'], 4);
	}
	
	public static function finalize( $share_id ) {
		
		global $link;
		
		// REFRESH THE SHARE VARIABLE;
		$share = sysfunc::_data( 'investments', $share_id );
		
		// END THE INVESTMENT AND FUND THE USER BALANCE
		$END_SQL = sQuery::update( 'investments', array(
			'status' => 0,
			'paid' => 1
		), "id = {$share['id']}" );
		
		$FUND_SQL = "
			UPDATE users
			SET walletbalance = ROUND((walletbalance + {$share['increased_usd']}), 4)
			WHERE id = {$share['userid']}
		";
		
		$ended = $link->query( $END_SQL );
		
		if( empty($share['paid']) ) {
			$funded = $link->query( $FUND_SQL );
		} else $funded = true;
		
		return ($ended && $funded);
		
	}
	
}
