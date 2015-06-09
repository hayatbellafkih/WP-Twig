<?php
class TWP_Entree {
	private $type = 'twig';
	private $template = 'index.twig';
	private $data_template = array ();
	public function TWP_Entree($type, $template, $data_template = array()) {
		$this->type = $type;
		$this->template = $template;
		$this->data_template = $data_template;
	}
	public function getType() {
		return $this->type;
	}
	public function getTemplate() {
		return $this->template;
	}
	public function getDataTemplate() {
		return $this->data_template;
	}
}
?>