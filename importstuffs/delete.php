<?php

require_once('../../config.php');

global $DB;

$id = required_param('id', PARAM_INT);

if($id == 0) {
	$DB->delete_records('block_importstuffs');
} else {
	$DB->delete_records('block_importstuffs', ['id' => $id]);
}
redirect($CFG->wwwroot . '/blocks/importstuffs/view.php');



