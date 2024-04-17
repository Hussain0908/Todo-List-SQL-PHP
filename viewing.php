<?php

include 'db_connect.php';

$con = mysqli_connect($servername, $username, $password, $dbname);
$result_task = mysqli_query($con, "SELECT * FROM tasks ORDER BY priority ASC");
$data_task = $result_task->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];
    $result_task = mysqli_query($con, "SELECT * FROM tasks_completed WHERE due_date = '$selected_date' ORDER BY due_date ASC");
    $data1_task = $result_task->fetch_all(MYSQLI_ASSOC);
} else {
    $data1_task = []; // No data if no date is selected
}

if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];
    $result_task = mysqli_query($con, "SELECT * FROM tasks_completed WHERE due_date = '$selected_date' ORDER BY due_date ASC");
    $data1_task = $result_task->fetch_all(MYSQLI_ASSOC);
} else {
    $data1_task = []; // No data if no date is selected
}

if (isset($_GET['start_monday'])) {
    $start_monday = $_GET['start_monday'];
    $week_start = new DateTime($start_monday);
    $week_end = clone $week_start;
    $week_end->modify('+6 days');
    
    $query = "SELECT due_date, COUNT(*) as count FROM tasks_completed WHERE due_date BETWEEN '".$week_start->format('Y-m-d')."' AND '".$week_end->format('Y-m-d')."' GROUP BY due_date ORDER BY due_date ASC";
    $result_week = mysqli_query($con, $query);
    $data_week = $result_week->fetch_all(MYSQLI_ASSOC);
    $total_tasks = array_sum(array_column($data_week, 'count'));
} else {
    $data_week = [];
    $total_tasks = 0;
}

$result_category = mysqli_query($con,"SELECT * FROM categories");
$data_category = $result_category->fetch_all(MYSQLI_ASSOC);

$result_complete = mysqli_query($con,"SELECT * FROM tasks_completed");
$data_complete = $result_complete->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
    <link href="authorstyle.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <section>
            <h2><span class="icon progress-icon">&#128202;</span> Project Progress</h2> 
            <p>🟧 For Due Today Tasks</p>
            <p>🟥 For Overdue Tasks</p>
            <p>⬛ For Future Tasks</p>
            <p>The ToDo List</p>
            <!-- Assuming task display happens here -->
            <table>
                <?php
                $current_date = date('Y-m-d'); // Get current date in YYYY-MM-DD format
                foreach ($data_task as $task) {
                    echo "<tr>";
                    echo "<td>" . $task['description'] . "</td>";  // Display the task description
                    $due_date = new DateTime($task['due_date']);
                    $today = new DateTime($current_date);
                    if ($due_date < $today) {
                        echo "<td><span style='color: red;'>" . $task['due_date'] . "</span></td>";
                    } elseif ($due_date == $today) {
                        echo "<td><span style='color: orange;'>" . $task['due_date'] . "</span></td>";
                    } else {
                        echo "<td>" . $task['due_date'] . "</td>";
                    }
                    // Check the priority and display the corresponding label
                    $priority_label = '';
                    switch ($task['priority']) {
                        case 1:
                            $priority_label = 'High';
                            break;
                        case 2:
                            $priority_label = 'Medium';
                            break;
                        case 3:
                            $priority_label = 'Low';
                            break;
                        case 4:
                            $priority_label = 'Other';
                            break;
                    }
                    echo "<td><span class='priority-box'>" . $priority_label . "</span></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>

        <section>
            <h2>Completed Tasks on Selected Day</h2> 
            <form action="" method="get">
                <label for="date">Select a Date:</label>
                <input type="date" id="date" name="date">
                <button type="submit" class="btn-default">View Tasks</button>
            </form>
            <?php if (!empty($data1_task)): ?>
            <table>
                <?php foreach ($data1_task as $task): ?>
                    <tr>
                        <td><?= $task['description']; ?></td>
                        <td><?= $task['due_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>No tasks completed on this date.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Weekly Task Report</h2>
            <form action="" method="get">
                <label for="start_monday">Select a Monday:</label>
                <input type="date" id="start_monday" name="start_monday" min="2020-01-01" max="2030-12-31" onchange="validateMonday(this);">
                <button type="submit">View Report</button>
            </form>
            <?php if (!empty($data_week)): ?>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Number of Tasks</th>
                    </tr>
                    <?php foreach ($data_week as $day): ?>
                        <tr>
                            <td><?= $day['due_date']; ?></td>
                            <td><?= $day['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong><?= $total_tasks; ?></strong></td>
                    </tr>
                </table>
            <?php else: ?>
                <p>No tasks completed in this week.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2><span class="icon navigation-icon">&#128506;</span> Navigation</h2> 
            <ul class="navigation-list">
                <li class="navigation-item"><a href="index.php" class="navigation-link">Home Page</a></li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ToDo List App. All rights reserved.</p>
    </footer>
</body>
</html>
