<?php
//starts a table form wrapper
function cocoricoFormTableStartShorthand($cocorico){
	$cocorico->startWrapper('form-table');
}
CocoDictionary::register('shorthand', 'startForm', 'cocoricoFormTableStartShorthand');

//ends a table form wrapper
function cocoricoFormTableEndShorthand($cocorico){
	$cocorico->endWrapper('form-table');
}
CocoDictionary::register('shorthand', 'endForm', 'cocoricoFormTableEndShorthand');

//input field in a table
function cocoricoSettingShorthand($cocorico, $params){
	$cocorico->startWrapper('tr');
	
	$cocorico->startWrapper('th');
	if (!in_array($params['type'], array('radio'))){
		$cocorico->component('label', $params['label'], $params['name']);
	}
	else{
		$cocorico->component('raw', $params['label']);
	}
	$cocorico->endWrapper('th');
	
	$cocorico->startWrapper('td');
	
	$ui = null;
	switch ($params['type']){
		case 'radio':
			if (!isset($params['options'])) $params['options'] = array();
			$ui = $cocorico->component('radio', $params['name'], $params['radios'], $params['options']);
			break;
		default:
			if (!isset($params['options'])) $params['options'] = array();
			$ui = $cocorico->component('input', $params['name'], $params['type'], $params['options']);
			break;
	}
	$ui->filter('stripslashes')->filter('save', $params['name']);
	
	if (isset($params['description'])){
		$cocorico->component('description', $params['description']);
	}
	
	$cocorico->endWrapper('td');
	
	$cocorico->endWrapper('tr');
}
CocoDictionary::register('shorthand', 'setting', 'cocoricoSettingShorthand');

function cocoricoGroupHeader($cocorico, $tabNames){
	$cocorico->startWrapper('group-header');
	
	foreach ($tabNames as $tab){
		$cocorico->component('link', $tab, '#'.$tab, array('class'=>'nav-tab'));
	}
	
	$cocorico->endWrapper('group-header');
}
CocoDictionary::register('shorthand', 'groupHeader', 'cocoricoGroupHeader');