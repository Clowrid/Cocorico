<?php
class CocoUI{
	
	const STOP_FILTERS = 'CocoUiStopFiltersConstant';
	
	protected $renderFn;
	protected $name;//html sense of name
	protected $value = null;
	protected $runFilters = true;
	
	public function __construct($name, $fn){
		$this->name = $name;
		$this->renderFn = $fn;
		
		//get the requested value for the filters
		if ($this->value === null){
			$this->value = CocoRequest::request($this->name);
		}
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function render($args){
		//get the stored value, because the filter ran by now
		$this->value = CocoStore::get($this->name);
		array_unshift($args, $this);
		return call_user_func_array($this->renderFn, $args);
	}
	
	public function preventFilters(){
		$this->runFilters = false;
	}
	
	public function filter($filter){
		//run through the filters
		if ($this->runFilters !== false){
			$args = array_slice(func_get_args(), 1);
			array_unshift($args, $this->value);
			$filterFn = CocoDictionary::translate($filter, 'filter');
			$return = call_user_func_array($filterFn, $args);
			
			if ($return === CocoUI::STOP_FILTERS) $this->preventFilters();
			else $this->value = $return;
		}
		
		return $this;
	}
}