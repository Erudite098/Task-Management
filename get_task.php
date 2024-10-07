<?php
include 'conn.php';

// Check if an ID is provided in the request
$taskId = $_GET['id'] ?? null;

if ($taskId) {
    // Fetch a specific task by ID
    $task = getTaskById($conn, $taskId);
    echo json_encode($task); 
} else {
    // Fetch all tasks (excluding completed tasks)
    $tasks = getAllTasks($conn);
    echo json_encode($tasks); 
}

// Function to fetch a specific task by ID 
// This is for edit button, it uses id when prefilling the form
function getTaskById($conn, $taskId) {
    $query = $conn->prepare("SELECT * FROM tbl_task WHERE id = ?");
    $query->bind_param("i", $taskId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return task details
    } else {
        return ['status' => 'error', 'message' => 'Task not found.'];
    }
    $query->close();
}

// Function to fetch all tasks excluding completed tasks
function getAllTasks($conn) {
    // Modify the query to exclude tasks with the status 'Completed'
    $query = "SELECT * FROM tbl_task WHERE status != 'Completed'";
    $result = $conn->query($query);
    $tasks = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row; // Add each task to the tasks array
        }
    }

    return $tasks; // Return all tasks
}
$conn->close();
?>
