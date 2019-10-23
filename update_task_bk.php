<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script

if (isset($_POST["dataObj"])) {
	
	$taskData=json_decode($_POST["dataObj"]);
	
	$id=$taskData->id;
	$name=htmlentities($taskData->name);
	$description=htmlentities($taskData->description);
	$update=$taskData->update;
	$delete=$taskData->delete;
	echo $id." ".$name." ".$description;

	if (intval($id) < 1) {
	    echo "create new";
	    $task = new Task();
	    $task->Save($name, $description);
	}
	else {
		if ($update == "true") {
			echo "update existing";
			$task = new Task($id);
			$task->Save($name, $description);
			var_dump($task);
		}
		if ($delete == "true") {
			echo "delete existing";
			$task = new Task($id);
			$task->Delete();
			var_dump($task);
		}
		
	}
}


?>