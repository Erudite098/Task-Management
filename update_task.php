<?php
include 'conn.php';

// Check if an ID is provided to determine if we can update the task
$taskId = $_POST['id'] ?? null;

if ($taskId) {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $status = $_POST['status'];

    // Prepare the SQL query for updating the task
    $query = $conn->prepare("UPDATE tbl_task SET title = ?, description = ?, due_date = ?, status = ? WHERE id = ?");
    $query->bind_param("ssssi", $title, $description, $dueDate, $status, $taskId);

    if ($query->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update task']);
    }

    $query->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Task ID is required for updating']);
}

$conn->close();
?>
