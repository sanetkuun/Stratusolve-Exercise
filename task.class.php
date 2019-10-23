<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();

    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        /*echo "new ".$this->TaskId;*/
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
        array_push($this->TaskDataSource, $this);
        /*var_dump($this->TaskDataSource);*/
        $this->Save($this->TaskName, $this->TaskDescription);
    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        if (!$this->TaskDataSource) {
            return 1;
        } else {
            $lastTask = end($this->TaskDataSource);
            /*echo "last ".$lastTask->TaskId;*/
            return intval($lastTask->TaskId)+1; //should probs check that this id does not exist in the file for in case no sequential order.... 
        }

        return -1; // Placeholder return for now
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            foreach ($this->TaskDataSource as $task) {  
                if ($task->TaskId == intval($Id)) {
                    $this->TaskId = intval($task->TaskId);
                    $this->TaskName = $task->TaskName;
                    $this->TaskDescription = $task->TaskDescription;
                    /*var_dump($this);*/
                    return $this; 
                }
            }
        } else
            return null;
    }

    public function Save($Name, $Description) {
        //Assignment: Code to save task here

        /*var_dump($this->TaskDataSource);*/ 
        $this->TaskName = $Name;
        $this->TaskDescription = $Description;
        foreach ($this->TaskDataSource as $task) {  
           if ($task->TaskId == intval($this->TaskId)) {
                $task->TaskName = $this->TaskName;
                $task->TaskDescription = $this->TaskDescription;
            }
        }
        $converted = json_encode(array_values($this->TaskDataSource), JSON_PRETTY_PRINT);
        if(file_put_contents('Task_Data.txt', $converted)) {
            echo 'Success';
        } else {
            echo "Error";
        }
    }

    public function Delete() {
        //Assignment: Code to delete task here

        foreach ($this->TaskDataSource as $key => $task) {
            if ($task->TaskId == intval($this->TaskId)) {
                unset($this->TaskDataSource[$key]);
            }          
        }

        var_dump($this->TaskDataSource);
        $converted = json_encode(array_values($this->TaskDataSource), JSON_PRETTY_PRINT);
        if(file_put_contents('Task_Data.txt', $converted)) {
            echo 'Success';
        } else {
            echo "Error";
        }
    }
}
?>