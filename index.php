
<?php

include 'db_connect.php';

$con = mysqli_connect($servername, $username, $password, $dbname);
$result_task = mysqli_query($con,"SELECT * FROM tasks");
$data_task = $result_task->fetch_all(MYSQLI_ASSOC);

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
    <title> ToDo List</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
</head>
<body>
<header>
    <h1><span class="icon progress-icon">&#128202;</span> ToDo List</h1> 
</header>

<main>
    <section>
        <h2><span class="icon progress-icon">&#128202;</span> Project Progress</h2>
        <p>The ToDo List is a web application designed to help users manage their tasks effectively.</p>
        <p class="bold-text">Current Features:</p>
        <form action="remove_task.php" method="post">
            <ul class="tasks-list">
                <?php foreach($data_task as $row): ?>
                <li class="task-item">
                    <div class="task-content">
                        <input type='checkbox' name='checkbox[]' value="<?= htmlspecialchars($row['task_id']) ?>">
                        <span><?= htmlspecialchars($row['description']) ?></span>
                    </div>
                    <span class='due-date'><?= htmlspecialchars($row['due_date']) ?></span>
                </li>
                <?php endforeach ?>
            </ul>
            <button type="submit" class="btn-remove">Finished</button>
        </form>
        
        <p>We are continuously working on improving the app and adding new features to enhance user experience.</p>
    </section>

    <section>
        <h2><span class="icon progress-icon">&#128202;</span> Completed Tasks</h2>
        <form method="post">
            <ul>
                <?php foreach($data_complete as $row): ?>
                <li>
                    <!-- <td><input type='checkbox' name='checkbox[]' value=<?= htmlspecialchars($row['complete_id']) ?>></td> -->
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td align='center'><?= htmlspecialchars($row['priority']) ?></td>
                </li>
                <?php endforeach ?>
            </ul>
                <!-- <button type="submit" class="btn-remove">Remove</button> -->
        </form>
        
    </section>

    <!-- Just tasks for now, they are not functional but working to make them functional within the next few weeks-->
    <section id="createTaskSection">
        <h2>Create Task</h2>
        <form action="add_task.php" method="post">
            <div class="input-group">
                <label for="taskDescription">Task Description:</label><br>
                <input type="text" id="taskDescription" name="taskDescription" required>
            </div>

            <div class="input-group">
                <label for="dueDate">Due Date:</label><br>
                <input type="date" id="dueDate" name="dueDate" required>
            </div>

            <div class="input-group" id="categoryGroup">
                <label for="category">Category:</label>
                <label style="font-weight:100;">Use 'other' to add category</label><br>
                <select id="categoryDropdown" name="category">
                    <!-- Goes through column for each value -->
                    <?php foreach($data_category as $row): ?>
                    <option><?= htmlspecialchars($row['name']) ?></option>
                    <?php endforeach ?>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="categoryInput" name="othercategory" style="display:none;">
            </div>

            <div class="input-group">
                <label for="priority">Priority:</label><br>
                <select id="priority" name="priority">
                    <option value="1">High</option>
                    <option value="2">Medium</option>
                    <option value="3">Low</option>
                    <option value="4">Other</option>
                </select>
            </div>

            <button type="submit" class="btn-create">Create Task</button>
        </form>
    </section>
    
    <section>
        <h2>Category Edit</h2>
        <form id="categoryForm" action="name_change.php" method="post">
            <label for="categoryName">Category Name:</label>
            <select id="categoryEdit" name="categoryEdit">
                    <!-- Goes through column for each value -->
                    <?php foreach($data_category as $row): ?>
                    <option><?= htmlspecialchars($row['name']) ?></option>
                    <?php endforeach ?>
            </select>
            <label for="parentCategory">Edit To:</label>
            <input type="text" id="categoryChange" name="categoryChange"><br><br>

            <button type="submit" class="btn-create">Change Category</button>
        </form>
    </section>
   
    <section>
        <h2><span class="icon navigation-icon">&#128506;</span> Navigation</h2> 
        <ul class="navigation-list">
            <li class="navigation-item"><a href="authors.html" class="navigation-link">Authors Page</a></li>
            <li class="navigation-item"><a href="viewing.php" class="navigation-link">View Reports</a></li>
        </ul>
    </section>

</main>
<footer>
    <p>&copy; 2024 ToDo List App. All rights reserved.</p>
</footer>
<div id="editTaskModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Edit Task</h2>
        <label for="taskName">Task Name:</label>
        <input type="text" id="taskName" name="taskName" required><br>
        
        <button id="saveTaskBtn">Save Changes</button>
        <button id="cancelEditBtn">Cancel</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('taskForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var taskDescription = document.getElementById('taskDescription').value;
            var dueDate = document.getElementById('dueDate').value;
            var category = document.getElementById('category').value;
            var priority = document.getElementById('priority').value;
            var task = {
                description: taskDescription,
                dueDate: dueDate,
                category: category,
                priority: priority
            };
            addTaskToList(task);
            document.getElementById('taskForm').reset();
        });

        function addTaskToList(task) {
            var taskItem = document.createElement('li');
            taskItem.innerHTML = `
                <input type="checkbox" id="task${taskId}">
                <label for="task${taskId}">${task.description}</label>
                <span class="priority">${task.priority}</span>
                <button class="edit-btn">Edit</button>
            `;
            var taskList = document.getElementById('taskList');
            taskList.appendChild(taskItem);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        function handleTaskCompletion(event) {
            var checkbox = event.target;
            var taskDescription = checkbox.parentElement.querySelector('label').innerText;
            if (checkbox.checked) {
                console.log('Task completed:', taskDescription);
                checkbox.parentElement.querySelector('label').classLisst.add('completed');
            } else {
                console.log('Task marked as incomplete:', taskDescription);
                checkbox.parentElement.querySelector('label').classList.remove('completed');
            }
        }
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', handleTaskCompletion);
        });
    });

    document.getElementById('categoryDropdown').addEventListener('change', function() {
        var categoryDropdown = document.getElementById('categoryDropdown');
        var categoryInput = document.getElementById('categoryInput');

        if (categoryDropdown.value === 'Other') {
            categoryDropdown.style.display = 'none';
            categoryInput.style.display = 'block';
            categoryInput.value = ''; // Clear input value if user switched to input box
            categoryInput.focus(); // Set focus to the input box
        } else {
            categoryInput.style.display = 'none';
            categoryDropdown.style.display = 'block';
        }
    });
</script>
</body>
</html>
