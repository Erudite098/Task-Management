<?php
include 'conn.php';

$sql = "SELECT id, title, description, due_date FROM tbl_task WHERE status = 'Completed'";
$result = $conn->query($sql);

$tasks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

echo json_encode($tasks);

$conn->close();
?>
