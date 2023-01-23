<?php

// capturar o ID do arquivo csv

require_once('../../config.php');
require_once("$CFG->dirroot/course/lib.php");

global $DB;

$id = required_param('id', PARAM_INT);


$record = $DB->get_record('block_importstuffs', ['id'=>$id]);

$lines = explode(PHP_EOL, $record->file);

foreach($lines as $line){
	$course = str_getcsv($line);
	
	if( $DB->get_record('course', ['shortname' => $course[0]]) ){
	   \core\notification::error('O curso ' . $course[1] . ' já existe');
	continue;
	}
	   
	 #######  // Criando o Curso
	   
	   $newcourse = new stdClass();
	   $newcourse->shortname = $course[0];
	   $newcourse->fullname = $course[1];
	   $newcourse->category = 1;
	   
	   create_course($newcourse);
	   \core\notification::success("Curso {$course[1]} criado com sucesso"); 
}

redirect($CFG->wwwroot . '/blocks/importstuffs/view.php');
