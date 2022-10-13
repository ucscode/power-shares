<?php

class sysfunc {

	public static function url( $dir ) {
		$url = str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['SERVER_NAME'], str_replace("\\", "/", $dir));
		$proto = ($_SERVER['SERVER_PORT'] == 80) ? 'http://' : "https://";
		return $proto . $url;
	}
	
	public static function sanitize_input($data, $escape_string = false) {
		if( is_array($data) ) {
			foreach( $data as $key => $value ) {
				$data[$key] = self::sanitize_input($value, $escape_string);
			};
		} else {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			if( $escape_string ) {
				global $link;
				$data = $link->real_escape_string($data);
			}
		};
		return $data;
	}
	
	public static function clear_input($data) {
		if( is_array($data) ) {
			foreach( $data as $key => $value ) 
				$data[$key] = self::clear_input($value);
		} else $data = null;
		return $data;
	}
	
	public static function initMail( ) {
		global $config;
		$PHPMailer = new PHPMailer\PHPMailer\PHPMailer(true);
		$PHPMailer->setFrom($config->get('email'), $config->get('site_name'));
		$PHPMailer->isHTML(true);
		return $PHPMailer;
	}
	
	public static function keygen(int $length, bool $specialChar = false) {
		$choices = implode('', range(0,9));
		$choices .= implode('', range('a','z'));
		$choices .= implode('', range('A', 'Z'));
		if( $specialChar ) $choices .= implode('', ['/', '<', '>', '[', ']', '(', ')', '{', '}', '|', '@', '#']);
		$choices = str_shuffle($choices);
		$keygen = substr($choices, 0, $length);
		return $keygen;
	}
	
	public static function encpass( $password ) {
		return md5($password);
	}
	
	public static function mysql_insert_str( string $table, array $data ) {
		$columns = implode(", ", array_map(function($col) {
			return "`{$col}`";
		}, array_keys($data)));
		$values = implode(", ", array_map(function($val) {
			return "'{$val}'";
		}, array_values($data)));
		$str = "INSERT INTO {$table} ($columns) VALUES ($values)";
		return $str;
	}
	
	public static function mysql_update_str( string $table, array $data, $email = null ) {
		$pairs = implode(", ", array_map(function($key, $value) {
			return "`{$key}` = '{$value}'";
		}, array_keys($data), array_values($data)));
		$str = "UPDATE {$table} SET {$pairs}";
		if( $email ) $str .= " WHERE email = '{$email}'";
		return $str;
	}
	
	public static function html_notice( ?string $str = null, $type = null ) {
		if( is_null($str) ) {
			global $temp;
			$str = $temp->msg ?? null;
		};
		if( $type === null ) $type = 'primary';
		else if( !is_string($type) ) {
			$type = $type ? 'success' : 'danger';
		};
		if( !empty($str) ) {
			echo "<div class='alert alert-{$type} alert-dismissible fs-14' role='alert'>
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				{$str}
			</div>";
		};
	}
	
	public static function validateImage( ?array $upload, float $maxsize = 1.5 ) {
		if( empty($upload) ) return false;
		$upload['error_msg'] = null;
		if( empty($upload['size']) ) $upload['error_msg'] = 'No image was uploaded';
		else {
			$imgsize = getimagesize( $upload['tmp_name'] );
			if( empty($imgsize) ) $upload['error_msg'] = "The uploaded image is not valid";
			else {
				$megabyte = $upload['size'] / pow(1024,2);
				if( $megabyte > $maxsize ) $upload['error_msg'] = "The uploaded image size is too large";
				else {
					$type = strtolower(pathinfo($upload['name'],PATHINFO_EXTENSION));
					if( !in_array($type, ['jpg', 'png', 'jpeg']) ) $upload['error_msg'] = "Only JPG, JPEG &amp; PNG files are allowed";
					else $upload['extension'] = $type;
				};
			}
		};
		return $upload;
	}
	
	public static function countries(?string $key = null) {
		$json = file_get_contents( __json_dir . '/countries.json' );
		$countries = json_decode($json, true);
		$modify = array();
		foreach( $countries as $country ) {
			$modify[ ($country['Code']) ] = $country['Name'];
		};
		return empty($key) ? $modify : ($modify[$key] ?? null);
	}
	
	public static function crypto_coins(?string $key = null) {
		$json = file_get_contents( __json_dir . '/cryptocurrencies.json' );
		$currencies = json_decode($json, true);
		$networks = array();
		foreach( $currencies as $wallet ) {
			$networks[ ($wallet['code']) ] = $wallet['name'];
		};
		return empty($key) ? $networks : ($network[$key] ?? null);
	}
	
	public static function checker($element, ?string $active = null, ?string $inactive = null) {
		if( !empty($element) ) {
			$icon = "<i class='fas fa-check text-success'></i> {$active}";
		} else $icon = "<i class='fas fa-ban text-danger'></i> {$inactive}";
		return $icon;
	}
	
	public static function QRCodeURL($string) {
		error_reporting(0);
		ob_start();
		QRCode::png($string);
		$result = base64_encode(ob_get_clean());
		error_reporting(1);
		$url = "data:image/png;base64,{$result}";
		return $url;
	}
	
	public static function color( $value ) {
		if( is_numeric($value) ) {
			$value = (float)$value;
			if( $value < 0 ) $color = 'danger';
			else if( $value == 0 ) $color = 'muted';
			else if( $value < 50 ) $color = 'warning';
			else if( $value < 100 ) $color = 'primary';
			else $color = 'success';
		} else {
			switch(strtolower($value)):
				case 'declined':
				case 'unapproved':
				case 'rejected':
				case 'danger':
				case 'close':
				case 'closed':
					$color = 'danger';
					break;
				case 'approved':
				case 'success':
				case 'solved':
				case 'resolved':
					$color = 'success';
					break;
				case 'new':
				case 'open':
					$color = 'info';
					break;
				default:
					$color = 'warning';
			endswitch;
		};
		return $color;
	}
	
	public static function tx_url( $network, $txid ) {
		$network = strtoupper($network);
		$void = "javascript:void(0)";
		if( empty($txid) ) return $void;
		switch( $network ) {
			case "BTC":
				return "https://www.blockchain.com/btc/tx/{$txid}";
			case "ETH":
			case "USDT":
				return "https://etherscan.io/tx/{$txid}";
			case "BCH":
				return "https://www.blockchain.com/bch/tx/{$txid}";
			case "XRP":
				return "https://xrpscan.com/tx/{$txid}";
			case "BNB":
				return "https://bscscan.com/tx/{$txid}";
			case "SOL":
				return "https://solscan.io/tx/{$txid}";
			case "TRX":
				return "https://tronscan.org/#/transaction/{$txid}";
			case "DOGE":
				return "https://dogechain.info/tx/{$txid}";
			default:
				return $void;
		};
	}
	
	public static function _data( $table, $value, $column = 'id' ) {
		global $link;
		$SQL = sQuery::select( $table, "{$column} = '{$value}'" );
		$result = $link->query( $SQL );
		$data = ($result && $result->num_rows) ? $result->fetch_assoc() : null;
		return $data;
	}
	
	public static function if_empty( $value, $alternative ) {
		return empty($value) ? $alternative : $value;
	}
	
	public static function sum($table, $column, $condition = 1) {
		$SQL = "
			SELECT SUM({$column}) as total
			FROM {$table}
			WHERE {$condition}
		";
		global $link;
		$result = $link->query( $SQL );
		$data = $result->fetch_assoc();
		return !$data ? 0 : round((float)$data['total'], 4);
	}
	
}