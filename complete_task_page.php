<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="styles.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
    <title>Complw</title>
</head>
<body>
    <?php include 'conn.php'?>

    <nav>
        <div class="container">
            <div class="brand-logo left">Task Management</div>
            <ul class="right"><li><a href="home_page.php">All Tasks</a></li></ul>

        </div>  
    </nav>

    <br><br>
    <div class="container">
        <br>
        <section class="section task-section">
            <div class="container">
                <h4>Completed Tasks</h1>
                <div class="row">
                    <table class="highlight completed-tbl">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>                               
                                <th>Due Date</th>                              
                            </tr>
                        </thead>
                        <tbody id="completedTasksTable"></tbody>
                    </table>                     
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        // Fetch and display completed tasks
        $(document).ready(function() {
            fetchCompletedTasks();

            function fetchCompletedTasks() {
                $.ajax({
                    url: 'get_completed_tasks.php', // Fetch completed tasks
                    type: 'GET',
                    dataType: 'json',
                    success: function(tasks) {
                        updateCompletedTaskTable(tasks);
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred while fetching tasks: " + error);
                    }
                });
            }

            // Update the tasks table dynamically when new completed tasks are fetched
            function updateCompletedTaskTable(tasks) {
                //Clear existing rows so that the current tasks are not duplicated
                $('#completedTasksTable').empty(); 
                if (tasks.length > 0) {
                    tasks.forEach(function(task) {
                        $('#completedTasksTable').append(
                            `<tr>
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${task.due_date}</td>
                            </tr>`
                        );
                    });
                } else {
                    $('#completedTasksTable').append('<tr><td colspan="3">No completed tasks available</td></tr>');
                }
            }
        });
    </script>
    
</body>
</html>