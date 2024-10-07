<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $status = $_POST['status'];

    //input vaidation
    if (empty($title) || empty($description) || empty($dueDate)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }else{
        // Prepare the SQL query for inserting a new task
        $query = $conn->prepare("INSERT INTO tbl_task (title, description, due_date, status) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $title, $description, $dueDate, $status);

        if ($query->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Task created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create task']);
        }

        $query->close();
        $conn->close();
    }
}
?>
