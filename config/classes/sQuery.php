<?php

// Created BY UCSCODE;

class sQuery {
	
	public static function select( $tablename, $condition = 1 ) {
		$SQL = "SELECT * FROM `{$tablename}` WHERE {$condition}";
		return $SQL;
	}
	
	public static function val( $value ) {
		if( is_numeric($value) ) return $value;
		else if( is_null($value) ) return 'NULL';
		else return "'{$value}'";
	}
	
	public static function insert( string $tablename, array $data ) {
		$columns = implode(",", array_keys($data));
		$values = array_map(function($value) {
			return self::val( $value );
		}, array_values($data));
		$values = implode(",", $values);
		$SQL = "INSERT INTO `{$tablename}` ($columns) VALUES ($values)";
		return $SQL;
	}
	
	public static function update( string $tablename, array $data, $condition = 1 ) {
		$fieldset = array_map(function($key, $value) {
			return "{$key} = " . self::val( $value );
		}, array_keys($data), array_values($data));
		$fieldset = implode(", ", $fieldset);
		$SQL = "UPDATE `{$tablename}` SET {$fieldset} WHERE {$condition}";
		return $SQL;
	}
	
}