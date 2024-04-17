<?php
include 'db_connect.php';

$new_category = $conn->real_escape_string($_POST['categoryChange']);
$category = $conn->real_escape_string($_POST['categoryEdit']);


$change_query = "UPDATE categories 
                AS t JOIN (SELECT category_id FROM categories WHERE name = '$category') 
                AS sub ON t.category_id = sub.category_id SET t.name = '$new_category'";

if ($conn->query($change_query) === TRUE) {
    echo "Category Changed", "\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: index.php");
$conn->close();
?>
