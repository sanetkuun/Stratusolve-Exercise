var currentTaskId = -1;
    
$('#myModal').on('show.bs.modal', function (event) {
    var triggerElement = $(event.relatedTarget); // Element that triggered the modal
    var modal = $(this);
    if (triggerElement.attr("id") == 'newTask') {
        modal.find('.modal-title').text('New Task');
        $('#InputTaskName').val("");
        $('#InputTaskDescription').val("");
        $('#deleteTask').hide();
        currentTaskId = -1;
    } else {
        modal.find('.modal-title').text('Task details');
        currentTaskId = triggerElement.attr("id");
        var currentTaskName = $("#"+currentTaskId).find('.list-group-item-heading').html();
        var currentTaskDescription = $("#"+currentTaskId).find('.list-group-item-text').html();
        $('#InputTaskName').val(currentTaskName);
        $('#InputTaskDescription').val(currentTaskDescription);
        $('#deleteTask').show();       
        console.log('Task ID: '+triggerElement.attr("id"));
    }
});

$('#saveTask').click(function() {
    //Assignment: Implement this functionality
    //alert('Save... Id:'+currentTaskId);
    $('#myModal').modal('hide');
    var taskName = $('#InputTaskName').val();
    var taskDescription = $('#InputTaskDescription').val();
    var taskData = { 'id' : currentTaskId, 'name' : taskName, 'description' : taskDescription, 'update' : 'true', 'delete' : 'false'};
    var taskDataString = {"dataObj" : JSON.stringify(taskData)};
    //alert(taskDataString);
    updateTask(taskDataString);
});

$('#deleteTask').click(function() {
    //Assignment: Implement this functionality
    //alert('Delete... Id:'+currentTaskId);
    $('#myModal').modal('hide');
    var taskName = $('#InputTaskName').val();
    var taskDescription = $('#InputTaskDescription').val();
    var taskData = { 'id' : currentTaskId, 'name' : taskName, 'description' : taskDescription, 'update' : 'false', 'delete' : 'true'};
    var taskDataString = {"dataObj" : JSON.stringify(taskData)};
    updateTask(taskDataString);
});

function deleteTaskFromIcon(id) {
    //Assignment: Implement this functionality
    currentTaskId = id;
    //alert('Delete... Id:'+currentTaskId);
    $('#myModal').modal('hide');
    var taskName = $('#InputTaskName').val();
    var taskDescription = $('#InputTaskDescription').val();
    var taskData = { 'id' : currentTaskId, 'delete' : 'true'};
    var taskDataString = {"dataObj" : JSON.stringify(taskData)};
    updateTask(taskDataString);
};

function updateTaskList() {
    $.post("list_tasks.php", function( data ) {
        $( "#TaskList" ).html( data );
    });
}

function updateTask(dataObj) {
    $.post("update_task.php", dataObj, function( data ) {
        updateTaskList();
    });
}

updateTaskList();