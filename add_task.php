<?php
include 'db_connect.php';

// Escape user inputs for security
$description = $conn->real_escape_string($_POST['taskDescription']);
$due_date = $conn->real_escape_string($_POST['dueDate']);
$category = $conn->real_escape_string($_POST['category']);
if ($category === "Other") {
    $category = $_POST['othercategory'];
}
$priority = $conn->real_escape_string($_POST['priority']);

$category_id = null; 

// Check if category exists
$select_query = "SELECT category_id FROM categories WHERE name='$category'";
$result = $conn->query($select_query);

if ($result->num_rows > 0) {
    // Category exists, fetch its ID
    $row = $result->fetch_assoc();
    $category_id = $row['category_id'];
    echo "Category already exists\n";
} else {
    // Category does not exist, insert it
    $insert_query = "INSERT INTO categories (name) VALUES ('$category')";
    
    if ($conn->query($insert_query) === TRUE) {
        // Get the ID of the newly inserted category
        $category_id = $conn->insert_id;
        echo "New category added\n";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

// Insert task with the determined category_id
$sql = "INSERT INTO tasks (description, due_date, category_id, priority, status) VALUES ('$description', '$due_date', '$category_id', '$priority', 'active')";

if ($conn->query($sql) === TRUE) {
    echo "New record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: index.php");
$conn->close();
// $sql = "INSERT INTO tasks (description, due_date, category_id, priority, status) VALUES ('$description', '$due_date', (SELECT category_id FROM categories WHERE name='$category'), '$priority', 'active')";
?>


