<?php


require_once('../../config.php');
require_once('uploadform.php');

$uploadform = new uploadform();

global $DB;

$request = $uploadform->get_data();
if (!empty($request) and !is_null($request))  {

	$row = new stdClass();
	$row->description =$request->description;
	$row->type = $request->type;
	$row->file = $uploadform->get_file_content('file');
	$DB->insert_record('block_importstuffs', $row);

 \core\notification::success('Arquivo CSV criado com sucesso');
}

$records = array_values($DB->get_records('block_importstuffs'));


global $PAGE, $OUTPUT;

$url = new moodle_url("/blocks/importstuffs/view.php");
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('admin');
require_login();

$PAGE->set_pagelayout('standard');

$data= [
	'title' => 'Plugin de importação de coisas',
	'uploadform' => $uploadform->render(),
	'records' => $records,
];
	

print $OUTPUT->header();
print $OUTPUT->render_from_template('block_importstuffs/view', $data);
print $OUTPUT->footer();
 
 
 

  
  




