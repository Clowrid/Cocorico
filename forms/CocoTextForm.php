<?php
class CocoTextForm implements CocoForm{
	
	public static function render($params){
		$output = '<input type="text" name="'.$params['name'].'" value="'.CocoStore::request($params['name']).'" />';
		return $output;
	}
	
}