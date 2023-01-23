<?php

require_once('../../config.php');
require_once("$CFG->dirroot/user/lib.php");

global $DB;

$id = required_param('id', PARAM_INT);

$record = $DB->get_record('block_importstuffs', ['id' => $id]);

$lines = explode(PHP_EOL, $record->file);

foreach($lines as $line){

	if(empty($line)) continue;
	$user = str_getcsv($line);
	$userdb = $DB -> get_record('user',[ 'email' => $user[3]]);
	
	$newuser = new stdClass();
	$newuser->username =$user[1];
	$newuser ->firstname = $user[2];
	$newuser->email = $user[3];

	if($userdb){
	//atualização
	$newuser->id = $userdb->id;
	user_update_user($newuser);
	\core\notification::success("Usúario $user[2] atualizado com sucesso!");
	} elseif(!empy($newuser->username)) {
	// Criar usúario
	user_create_user($newuser);
	\core\notification::success("Usúario $user[2] atualizado com sucesso!");
	} else {
		continue;
	}
	
	$course = $DB->get_record('course', ['shortname' => $user[0]]);
	if(!$course){
		\core\notification::error("O curso de código " . $user[0] . " não existe");
	
	}
	
	$instances = enrol_get_instances($course->id, false);
	$instances = array_values($instances)[0]; //opção de inscrição manual
	$plugin = enrol_get_plugin('manual');
	
	//Qual o nome do estudante?
	$student = $DB ->get_record('role', ['shortname'=>'student']);
	
	$userdb = $DB->get_record('user', ['email'=>$user[3]]);
	
	$plugin->enrol_user($instance, $userdb->id, $course->id);
	
	role_assign($student->id, $userdb->id, $context->id);

} 
redirect($CFG->wwwroot . '/blocks/importstuffs/view.php');
