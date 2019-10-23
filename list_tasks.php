<?php
/**
 * Created by PhpStorm.
 * User: johangriesel
 * Date: 15122016
 * Time: 15:14
 * @package    ${NAMESPACE}
 * @subpackage ${NAME}
 * @author     johangriesel <info@stratusolve.com>
 * Task_Data.txt is expected to be a json encoded string, e.g: [{"TaskId":1,"TaskName":"Test","TaskDescription":"Test"},{"TaskId":"2","TaskName":"Test2","TaskDescription":"Test2"}]
 */
try {
    $taskData = file_get_contents('Task_Data.txt');
    //echo $taskData;
    $html = '<a id="newTask" href="#" class="list-group-item" data-toggle="modal" data-target="#myModal">
                        <h4 class="list-group-item-heading">No Tasks Available</h4>
                        <p class="list-group-item-text">Click here to create one</p>
                    </a>';
    if (strlen($taskData) < 1) {
        die($html);
    }
    else {

        $taskArray = json_decode($taskData);

        if (sizeof($taskArray) > 0) {
            $html = '';
            foreach ($taskArray as $task) {
                $html .= '<div class="list-group-item"><span class="task-info"><a id="'.$task->TaskId.'" href="#" data-toggle="modal" data-target="#myModal">
                            <h4 class="list-group-item-heading">'.html_entity_decode($task->TaskName).'</h4>
                            <p class="list-group-item-text">'.html_entity_decode($task->TaskDescription).'</p>
                        </a></span>
                        <span class="task-buttons pull-right">
                          <span class="btn btn-lrg">
                              <a id="'.$task->TaskId.'" onclick="deleteTaskFromIcon('.$task->TaskId.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                          </span>
                          <span class="btn btn-lrg">
                              <a id="'.$task->TaskId.'" href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                          </span>
                      </span></div>';
            }
        }
        die($html);

    }
} catch (Exception $e) {
    echo 'Exception: ',  $e->getMessage(), "\n";
}

?>