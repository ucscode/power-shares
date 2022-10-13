<?php

class user {
	
	protected $user;
	
	public function __construct( string $table = 'users' ) {
		global $link;
		$email_key = "{$table}:email";
		$email_pass = "{$table}:password";
		if( empty($_SESSION[ $email_key ]) || empty($_SESSION[ $email_pass ]) ) return;
		
		### secure input;
		$_SESSION[ $email_key ] = sysfunc::sanitize_input($_SESSION[ $email_key ]);
		$_SESSION[ $email_pass ] = sysfunc::sanitize_input($_SESSION[ $email_pass ]);
		
		### prepare query;
		$sql = "
			SELECT * FROM {$table}
			WHERE email = '" . $_SESSION[ $email_key ] . "' 
				AND password = '" . $_SESSION[ $email_pass ] . "';
		";
		
		### get user;
		$user = $link->query( $sql )->fetch_assoc();
		$this->user = $user;
	}
	
	public function info() {
		return $this->user;
	}
	
	public function __get($key) {
		return $this->user[$key] ?? null;
	}
	
	public static function get(array $__user, string $name) {
		
		switch($name) {
		
			case 'avatar':
				return sysfunc::url( __users_contents . '/images/profile/' . (empty($__user['image']) ? 'icon.png' : $__user['image']) );
			
			case 'reflink':
				return sysfunc::url( __users_register_page . '?ref=' . $__user['refcode'] );
			
			case 'online':
				$seconds = time() - strtotime( $__user['last_seen'] );
				$minute = (int)( $seconds / 60 );
				## if not seen for over 5 minute, user is offline;
				return ($minute < 5);
			
			case 'sponsor':
			case 'upline':
				global $link;
				$result = $link->query( sQuery::select( 'users', "id = '{$__user['referrer']}'" ) );
				return $result->num_rows ? $result->fetch_assoc() : null;
			
			case 'downlines':
			case 'referrals':
				global $link;
				$result = $link->query( sQuery::select( 'users', "referrer = '{$__user['id']}'" ) );
				return $result;
		
		};
	
	}
	
}