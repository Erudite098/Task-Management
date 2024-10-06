<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = 'Completed';

    $sql = "UPDATE tbl_task SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task marked as completed']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to mark task as completed']);
    }

    $stmt->close();
    $conn->close();
}
?>
