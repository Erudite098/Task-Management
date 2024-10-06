<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Task Management</title>
</head>
<body>
    <?php include 'conn.php'?>

    <nav>
        <div class="container">
            <div class="brand-logo left">Task Management</div>
            <ul class="right"><li><a href="complete_task_page.php">Completed Tasks</a></li></ul>

        </div>  
    </nav>

    <br><br><br>
    <div class="container">
        <br>
        <section class="task-section">            
            <div class="container">   
                <h4>All Tasks</h4>   
                <div class="row">
                    <table class="highlight" id="tblTask">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <br>  
                    <button class="btn-floating modal-trigger" type="submit" name="addTask" data-target="modal">
                        <i class="fa-solid fa-plus fa-2xs"></i>                     
                    </button>
                  
                </div>
            </div>
        </section>

        <!-- Modal Structure -->       
        <div id="modal" class="modal">
            <form method="POST" class="col s6" id="taskForm">
                <div class="modal-content">                  
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" class="validate" id="title" name="title">
                                <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea class="materialize-textarea" id="description" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" class="datepicker" id="dueDate" name="dueDate">
                            <label for="dueDate">Due Date</label>
                        </div>
                        <div class="input-field col s6">                            
                            <select name="status">                              
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>                              
                                <label for="status">Status</label>
                            </select>
                        </div>
                    </div>
                                       
                </div>

                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect btn-flat" id="cancelBtn">Cancel</a>
                    <button class="btn waves-effect waves-light" type="submit" name="submit">Add Task</button>
                </div>
            </form>  
        </div>

    </div>


    <!-- JQuery-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize modal, datepicker, and select
            $('.modal').modal();
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoClose: true           
            });
            $('select').formSelect();

            // Open modal to add a new task
            $('.btn-floating').on('click', function() {
                // Clear the form and reset the button text to "Add Task"
                $('#taskForm')[0].reset();
                $('#taskForm button[type="submit"]').text('Add Task');
                
                // Remove any existing hidden ID field if present
                $('input[name="id"]').remove();

                // Open the modal for adding a new task
                $('#modal').modal('open');
            });

            // Open modal to edit an existing task
            $(document).on('click', '.edit-task', function() {
                const taskId = $(this).data('id');

                // Fetch the task details via AJAX
                $.ajax({
                    url: 'get_task.php',
                    type: 'GET',
                    data: { id: taskId },
                    dataType: 'json',
                    success: function(task) {
                        // Prefill the form with the fetched task data
                        $('#title').val(task.title);
                        $('#description').val(task.description);
                        $('#dueDate').val(task.due_date);
                        $('select[name="status"]').val(task.status);
                        $('select').formSelect(); // Re-initialize select

                        // Add the active class to labels so they don't overlap
                        $('label').addClass('active');

                        // Update the form button text to "Save Changes"
                        $('#taskForm button[type="submit"]').text('Save Changes');

                        // Add hidden input field to store the task ID for updating
                        if ($('#taskForm').find('input[name="id"]').length === 0) {
                            $('#taskForm').append(`<input type="hidden" name="id" value="${task.id}">`);
                        } else {
                            $('input[name="id"]').val(task.id);
                        }

                        // Open the modal for editing
                        $('#modal').modal('open');
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            });

            // Delete task            
            $(document).on('click', '.del-task', function() {
                const taskId = $(this).data('id'); // Get the task ID

                if (confirm('Are you sure you want to delete this task?')) {
                    $.ajax({
                        url: 'delete_task.php', 
                        type: 'POST',
                        data: { id: taskId }, // Send the task ID
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Refresh the task list
                                fetchTasks();
                                alert(response.message);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
                }
            });

            // Handle form submission (Add/Update)
            $('#taskForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Check if this is an add or update action based on button text
                if ($('#taskForm button[type="submit"]').text() === 'Add Task') {
                    $('#taskId').val(''); // Clear the hidden field for a new task
                    actionUrl = 'create_task.php'; // Add 
                      
                } else {
                    actionUrl = 'update_task.php'; // Update
                }   

                // Use AJAX to submit form data
                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Fetch updated tasks and update the table
                            fetchTasks();
                            // Close the modal
                            $('#modal').modal('close');
                            // Clear form fields
                            $('#taskForm')[0].reset();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            });

            //complete
            $(document).on('change', '.mark-complete', function() {
                const taskId = $(this).data('id');
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    if (confirm('Mark this task as completed?')) {
                        $.ajax({
                            url: 'mark_complete.php', 
                            type: 'POST',
                            data: { id: taskId },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Refresh the task list to remove completed tasks
                                    fetchTasks();
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                alert("An error occurred: " + error);
                            }
                        });
                    }
                }
            });

            // Fetch and display tasks
            function fetchTasks() {
                $.ajax({
                    url: 'get_task.php',
                    type: 'GET',
                    dataType: 'json', 
                    success: function(tasks) {
                        // Update table with the fetched tasks
                        updateTaskTable(tasks);
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred while fetching tasks: " + error);
                    }
                });
            }

            // Update the tasks table dynamically
            function updateTaskTable(tasks) {
                // Clear existing rows so that the current tasks are not duplicated
                $('#tblTask tbody').empty(); 

                if (tasks.length > 0) {
                    tasks.forEach(function(task) {
                        $('#tblTask tbody').append(
                            `<tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="mark-complete" data-id="${task.id}"/>
                                        <span>
                                            <div class="task-title">${task.title}</div>
                                            
                                        </span>
                                    </label>                                 
                                </td>
                                <td>${task.description}</td>
                                <td>${task.status}</td>
                                <td>${task.due_date}</td>
                                <td>
                                    <button class="modal-trigger btn-small edit-task" data-id="${task.id}">Edit</button>
                                    <button class="btn-small del-task" data-id="${task.id}">Delete</button>
                                </td>                                          
                            </tr>`
                        );
                    });
                } else {
                    $('#tblTask tbody').append('<tr><td colspan="6" class="no-tasks">No tasks available</td></tr>');
                }
            }

            // Fetch tasks initially when the page loads
            fetchTasks();
        });
    </script>
</body>
</html>