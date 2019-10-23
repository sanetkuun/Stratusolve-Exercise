<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script
class TaskCRUD {
    public $Id;
    public $Name;
    public $Description;
    public $Updating;
    public $Deleting;

    public function Create($Task) {
    	$task = new Task();
	    $task->Save($Task->Name, $Task->Description);
    }

    public function Read($data) {

    	return json_decode($data);

    }

    public function Update($Task) {
        $task = new Task($Task->Id);
		$task->Save($Task->Name, $Task->Description);
		//var_dump($task);
    }

    public function Delete($Task) {
        $task = new Task($Task->Id);
		$task->Delete();
		//var_dump($task);
    }
}

try {
	$taskCRUD = new TaskCRUD();
	if (isset($_POST["dataObj"])) {
		$taskData=$taskCRUD->Read($_POST["dataObj"]);
		if ($taskData != null)
		{
			$taskCRUD->Id = intval($taskData->id);
			$taskCRUD->Name = isset($taskData->name) ? htmlentities($taskData->name) : ''; 
			$taskCRUD->Description = isset($taskData->description) != '' ? htmlentities($taskData->description) : '';
			$taskCRUD->Updating = isset($taskData->update) ? $taskData->update : '';
			$taskCRUD->Deleting = isset($taskData->delete) ? $taskData->delete : '';

			if ($taskCRUD->Id < 1) {
				    $taskCRUD->Create($taskCRUD);
			} else {

				if ($taskCRUD->Updating == "true") {
					$taskCRUD->Update($taskCRUD);
				}
				if ($taskCRUD->Deleting == "true") {
					$taskCRUD->Delete($taskCRUD);
				}	
			}
		}
		
	} else {
		$taskData = null;
	}
	
} catch (Exception $e) {
	echo 'Exception: ',  $e->getMessage(), "\n";
}



?>