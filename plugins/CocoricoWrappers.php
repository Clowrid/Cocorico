<?php
function cocoricoFormWrapper($content){
	$output = '<form method="post">';
	$output .= $content;
	$output .= '</form>';
	return $output;
}
CocoDictionary::register('wrapper', 'form', 'cocoricoFormWrapper');

function cocoricoFormTableWrapper($content){
	$output = '<table class="form-table">';
	$output .= $content;
	$output .= '</table>';
	return $output;
}
CocoDictionary::register('wrapper', 'form-table', 'cocoricoFormTableWrapper');

function cocoricoTableRowWrapper($content){
	$output = '<tr valign="top">';
	$output .= $content;
	$output .= '</tr>';
	return $output;
}
CocoDictionary::register('wrapper', 'tr', 'cocoricoTableRowWrapper');

function cocoricoTableCellWrapper($content){
	$output = '<td>';
	$output .= $content;
	$output .= '</td>';
	return $output;
}
CocoDictionary::register('wrapper', 'td', 'cocoricoTableCellWrapper');

function cocoricoTableHeaderWrapper($content){
	$output = '<th scope="row">';
	$output .= $content;
	$output .= '</th>';
	return $output;
}
CocoDictionary::register('wrapper', 'th', 'cocoricoTableHeaderWrapper');

function cocoricoGroupHeaderWrapper($content){
	$output = '<h2 class="nav-tab-wrapper">';
	$output .= $content;
	$output .= '</h2>';
	return $output;
}
CocoDictionary::register('wrapper', 'group-header', 'cocoricoGroupHeaderWrapper');