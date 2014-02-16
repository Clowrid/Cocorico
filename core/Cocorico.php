<?php
class Cocorico{
	
	protected $stack = array();
	protected $validated = true;//default to true so that the nonce filter runs
	protected $autoForm;
	protected $wrapperArgsStack = array();
	
	public function __construct($autoForm=true, $autoNonce=true){
		$this->autoForm = $autoForm;
		if ($this->autoForm) $this->startWrapper('form');
		if ($autoNonce) $this->nonce();
	}
	
	public function nonce(){
		$nonce_action = 'cocorico_nonce_validation';
		$nonce = $this->field('nonce', 'coco_nonce', $nonce_action)->filter('nonce', $nonce_action);
		$this->validated = (bool)$nonce->getValue();
	}
	
	public function field($alias, $name){
		$fn = CocoDictionary::translate($alias, 'ui');
		
		$instance = new CocoUI($name, $fn);
		if (!$this->validated) $instance->preventFilters();
		
		$args = array_slice(func_get_args(), 2);
		array_push($this->stack, array( 'action'=>'render',
										'instance'=>$instance, 
										'args'=>$args));
		
		return $instance;
	}
	
	public function startWrapper($name){
		//nameparam is just there for clarity
		$args = array_slice(func_get_args(), 1);
		array_push($this->stack, array('action'=>'startBuffer',
										'args'=>$args));
	}
	
	public function endWrapper($name){
		array_push($this->stack, array( 'action'=>'endBuffer',
										'wrapper'=>$name));
	}
	
	private function shorthand($alias){
		$fn = CocoDictionary::translate($alias, 'shorthand');
		$args = array_slice(func_get_args(), 1);
		array_unshift($args, $this);
		call_user_func_array($fn, $args);
	}
	
	public function __call($name, $args){
		array_unshift($args, $name);
		call_user_func_array(array($this, 'shorthand'), $args);
	}
	
	public function render(){
		if ($this->autoForm) $this->endWrapper('form');
		
		foreach ($this->stack as $action){
			if ($action['action'] === 'render'){
				echo $action['instance']->render($action['args']);
			}
			else if ($action['action'] === 'startBuffer'){
				array_push($this->wrapperArgsStack, $action['args']);
				ob_start();
			}
			else if ($action['action'] === 'endBuffer'){
				$content = ob_get_contents();
				ob_end_clean();
				
				$args = array_pop($this->wrapperArgsStack);
				array_unshift($args, $content);
				$wrapperFn = CocoDictionary::translate($action['wrapper'], 'wrapper');
				echo call_user_func_array($wrapperFn, $args);
			}
		}
	}
	
}