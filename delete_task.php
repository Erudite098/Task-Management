<?php
// Include database connection
include 'conn.php';

if (isset($_POST['id'])) {
    $taskId = $_POST['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM tbl_task WHERE id = ?");
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete task.']);
    }

    $stmt->close();
    $conn->close();
}
?>
