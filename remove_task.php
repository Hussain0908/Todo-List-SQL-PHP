<?php
include 'db_connect.php';

// $description = $conn->real_escape_string($_POST['taskDescription']);
// $due_date = $conn->real_escape_string($_POST['dueDate']);
// $category = $conn->real_escape_string($_POST['category']);
// $priority = $conn->real_escape_string($_POST['priority']);

// Insert data into tasks table
foreach($_POST['checkbox'] as $val)
{
    // $remove = "DELETE FROM tasks WHERE (task_id = $val)";
    $copy = "INSERT INTO tasks_completed (description, due_date, category_id, priority, status)
    SELECT description, due_date, category_id, priority, status FROM tasks WHERE task_id = $val"; 

    if ($conn->query($copy) === TRUE) {
        echo "Record Moved", "\n";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $delete = "DELETE FROM tasks WHERE task_id = $val";

    if ($conn->query($delete) === TRUE) {
        echo "Record Removed", "\n";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo "ID " . $val . " was Deleted";
}
header("Location: index.php");
$conn->close();
?>
