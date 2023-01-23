<?php

class block_importstuffs extends block_base {
	public function init () {
		$this->title = get_string('blocktitle', 'block_importstuffs');
	}
	
	public function get_content () {	
		$this->content = new stdClass;
		$this->content->text = 
		"Acesse a área de administração";
		
		$url = new moodle_url('/blocks/importstuffs/view.php');
		$this->content->text .= html_writer::link($url, 'Upload stuffs');

		return $this->content;
		
	}
}

