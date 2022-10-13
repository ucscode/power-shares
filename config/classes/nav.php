<?php

class nav {
	
	private $result;
	private $query;
	private $SQL;
	private $limit;
	
	public function __construct( string $SQL, int $LIMIT = 15 ) {
		global $link;
		$this->query = $link->query( $SQL );
		$this->limit = $LIMIT;
		$this->SQL = $SQL . " LIMIT {$this->start()}, {$LIMIT}";
		$this->result = $link->query( $this->SQL );
	}
	
	public function result() {
		return $this->result;
	}

	private function start() {
		$paged = (int)($_GET['paged'] ?? 1);
		if( $paged < 1 ) $paged = 1;
		return ( $paged - 1 ) * $this->limit;
	}
	
	public function pages(int $col = 3) {
		$pages = ceil( $this->query->num_rows / $this->limit );
		if( $pages < 2 ) return;
	?>
		<div class='my-2 row'>
			<div class='ms-auto col-sm-<?php echo $col; ?>'>
				<form method='GET'>
					<?php 
						foreach( $_GET as $key => $value ): 
							if( $key == 'paged' ) continue;
					?>
					<input type='hidden' name='<?php echo $key; ?>' value='<?php echo $value; ?>'>
					<?php endforeach; ?>
					<div class='input-group'>
						<select class='form-select form-select-sm default' name='paged'>
							<?php 
								for( $x = 1; $x <= $pages; $x++ ): 
									$selected = ((int)$_GET['paged'] == $x) ? 'selected' : null;
							?>
							<option value='<?php echo $x; ?>' <?php echo $selected; ?>>
								<?php echo $x; ?>
							</option>
							<?php endfor; ?>
						</select>
						<button class='btn btn-secondary btn-sm'>
							<i class='mdi mdi-arrow-right'></i>
						</button>
					</div>
				</form>
			</div>
		</div>
	<?php }
	
}