<?php 

class forex {
	
	private $ticker = 'https://bitpay.com/api/rates';
	private $rates = array();
	
	public function __construct() {
		$ticker = @file_get_contents( $this->ticker );
		if( !$ticker ) return;
		$data = json_decode($ticker, true);
		if( json_last_error() ) return;
		foreach( $data as $rate ) {
			$key = $rate['code'];
			$value = $rate['rate'];
			$this->rates[ $key ] = $value;
		}
	}
	
	public function convert( $from, $to ) {
		$from = strtoupper($from);
		$to = strtoupper($to);
		if( empty($this->rates[$from]) || empty($this->rates[$to]) ) return 0;
        $conversion = ( $this->rates[$to] / $this->rates[$from] ); 
		return $conversion;
	}
	
	public function export_rates() {
		return $this->rates;
	}
	
}